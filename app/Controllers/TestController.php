<?php

namespace App\Controllers;

use App\Models\SetSoalModel;
use App\Models\SetSoalItemsModel;
use App\Models\BankSoalModel;
use App\Models\PilihanJawabanModel;
use App\Models\JawabanPesertaModel;
use App\Models\HasilTestModel;
use CodeIgniter\Controller;

class TestController extends Controller
{
    protected $setSoalModel;
    protected $setSoalItemsModel;
    protected $bankSoalModel;
    protected $pilihanJawabanModel;
    protected $jawabanPesertaModel;
    protected $hasilTestModel;
    
    public function __construct()
    {
        $this->setSoalModel = new SetSoalModel();
        $this->setSoalItemsModel = new SetSoalItemsModel();
        $this->bankSoalModel = new BankSoalModel();
        $this->pilihanJawabanModel = new PilihanJawabanModel();
        $this->jawabanPesertaModel = new JawabanPesertaModel();
        $this->hasilTestModel = new HasilTestModel();
    }
    
    public function index()
    {
        $session = session();
        $id_peserta = $session->get('user_id');
        $id_detail_pelatihan = $session->get('id_detail_pelatihan');
        
        if (!$id_peserta) {
            return redirect()->to(site_url('login'))->with('error', 'Sesi tidak valid. Silakan login kembali.');
        }
        
        // Debugging
        echo "<!-- Debug Info: -->";
        echo "<!-- ID Peserta: " . $id_peserta . " -->";
        echo "<!-- ID Detail Pelatihan: " . $id_detail_pelatihan . " -->";
        
        // Ambil data test yang tersedia untuk peserta
        $data['hasil_test'] = $this->hasilTestModel->getHasilTest($id_peserta);
        
        // Jika tidak ada hasil test, cek set soal yang tersedia untuk pelatihan ini
        if (empty($data['hasil_test']) && $id_detail_pelatihan) {
            $available_tests = $this->setSoalModel->getSetSoalByPelatihan($id_detail_pelatihan);
            
            // Debugging
            echo "<!-- Available Tests: " . count($available_tests) . " -->";
            
            // Buat entri hasil test untuk setiap set soal yang tersedia
            foreach ($available_tests as $test) {
                $this->hasilTestModel->save([
                    'id_peserta' => $id_peserta,
                    'id_set_soal' => $test['id'],
                    'status_verifikasi' => 'belum',
                    'nilai_akhir' => 0
                ]);
            }
            
            // Ambil lagi data hasil test setelah membuat entri baru
            $data['hasil_test'] = $this->hasilTestModel->getHasilTest($id_peserta);
        }
        
        // Debug hasil test
        echo "<!-- Jumlah Hasil Test: " . count($data['hasil_test']) . " -->";
        
        return view('peserta/v_test', $data);
    }
    
    public function mulaiTest($id_set_soal)
    {
        $session = session();
        // Coba ambil id_peserta, jika tidak ada gunakan user_id
        $id_peserta = $session->get('id_peserta') ?? $session->get('user_id');
        
        // Tambahkan debugging
        echo "<!-- Debug: ID Peserta yang digunakan: " . $id_peserta . " -->";
        
        // Cek apakah peserta sudah pernah mengerjakan test ini
        $hasil = $this->hasilTestModel->where('id_peserta', $id_peserta)
                                     ->where('id_set_soal', $id_set_soal)
                                     ->first();
        
        if ($hasil && $hasil['status_verifikasi'] == 'terverifikasi') {
            return redirect()->to(site_url('test'))->with('error', 'Anda sudah mengerjakan test ini dan telah diverifikasi');
        }
        
        // Ambil data set soal
        $data['set_soal'] = $this->setSoalModel->getSetSoalWithItems($id_set_soal);
        
        // Debugging
        echo "<!-- Debug: Set Soal: " . json_encode($data['set_soal']) . " -->";
        
        // Cek apakah set soal memiliki items
        if (empty($data['set_soal']['items'])) {
            return redirect()->to(site_url('test'))->with('error', 'Set soal tidak memiliki soal yang terkait. Silakan hubungi admin.');
        }
        
        // Jika belum ada hasil, buat data hasil baru
        if (!$hasil) {
            $this->hasilTestModel->save([
                'id_peserta' => $id_peserta,
                'id_set_soal' => $id_set_soal,
                'waktu_mulai' => date('Y-m-d H:i:s'),
                'status_verifikasi' => 'belum'
            ]);
        }
        
        // Ambil soal-soal dalam set
        $data['soal'] = [];
        foreach ($data['set_soal']['items'] as $item) {
            $soal = $this->bankSoalModel->getSoalWithPilihan($item['id_soal']);
            
            // Cek jawaban peserta jika ada
            $jawaban = $this->jawabanPesertaModel->where('id_peserta', $id_peserta)
                                                ->where('id_set_soal', $id_set_soal)
                                                ->where('id_soal', $item['id_soal'])
                                                ->first();
            
            if ($jawaban) {
                $soal['jawaban_peserta'] = $jawaban;
            }
            
            $data['soal'][] = $soal;
        }
        
        return view('peserta/v_kerjakan_test', $data);
    }
    
    public function simpanJawaban()
    {
        $session = session();
        $id_peserta = $session->get('user_id');

        if (!$id_peserta) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sesi tidak valid']);
        }

        // Debugging
        log_message('debug', 'Data yang diterima: ' . json_encode($this->request->getPost()));

        $id_set_soal = $this->request->getPost('id_set_soal');
        $id_soal = $this->request->getPost('id_soal');
        $jawaban = $this->request->getPost('jawaban');

        // Validasi data yang diterima
        if (!$id_set_soal || !$id_soal) {
            return $this->response->setJSON(['success' => false, 'message' => 'Data tidak lengkap']);
        }
        
        // Cek jawaban benar
        $is_benar = 0;
        
        // Cek apakah jawaban benar (untuk pilihan ganda)
        $jawaban_benar = $this->pilihanJawabanModel->getJawabanBenar($id_soal);
        
        if ($jawaban_benar && $jawaban_benar['id'] == $jawaban) {
            $is_benar = 1;
        }
        
        $data = [
            'id_peserta' => $id_peserta,
            'id_set_soal' => $id_set_soal,
            'id_soal' => $id_soal,
            'id_pilihan_jawaban' => $jawaban,
            'is_benar' => $is_benar,
            'nilai_soal' => 0 // Nilai per soal tidak lagi digunakan
        ];

        try {
            $saved = $this->jawabanPesertaModel->saveJawaban($data);
            if ($saved) {
                return $this->response->setJSON(['success' => true]);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Gagal menyimpan jawaban']);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error saving jawaban: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Terjadi kesalahan sistem']);
        }
    }
    
    public function selesaiTest()
    {
        $session = session();
        // Get id_peserta from either peserta-specific session or user_id
        $id_peserta = $session->get('user_id'); // Since we store the ID as user_id in login
        $id_set_soal = $this->request->getPost('id_set_soal');

        if (!$id_peserta) {
            return redirect()->to(site_url('test'))->with('error', 'Sesi tidak valid. Silakan login kembali.');
        }

        // Get total number of questions in the set
        $set_soal = $this->setSoalModel->getSetSoalWithItems($id_set_soal);
        $totalQuestions = count($set_soal['items']);
        
        // Get number of answered questions
        $answeredQuestions = $this->jawabanPesertaModel->countAnsweredQuestions($id_peserta, $id_set_soal);
        
        // Check if all questions have been answered
        if ($answeredQuestions < $totalQuestions) {
            return redirect()->to(site_url('test/mulai/' . $id_set_soal))->with('error', 'Anda harus menjawab semua soal sebelum menyelesaikan test.');
        }

        // Hitung nilai mentah
        $nilai_mentah = $this->jawabanPesertaModel->hitungNilaiMentah($id_peserta, $id_set_soal);

        // Update hasil test
        $data = [
            'id_peserta' => $id_peserta,
            'id_set_soal' => $id_set_soal,
            'nilai_mentah' => $nilai_mentah,
            'nilai_akhir' => $nilai_mentah, // Nilai mentah dan akhir sama
            'status_verifikasi' => 'proses',
            'waktu_selesai' => date('Y-m-d H:i:s')
        ];

        try {
            $this->hasilTestModel->saveHasil($data);
            return redirect()->to(site_url('test'))->with('success', 'Test berhasil diselesaikan. Hasil akan diverifikasi oleh admin.');
        } catch (\Exception $e) {
            return redirect()->to(site_url('test'))->with('error', 'Terjadi kesalahan saat menyimpan hasil test.');
        }
    }
} 