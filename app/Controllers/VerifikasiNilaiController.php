<?php

namespace App\Controllers;

use App\Models\HasilTestModel;
use App\Models\JawabanPesertaModel;
use App\Models\BankSoalModel;
use App\Models\PilihanJawabanModel;
use CodeIgniter\Controller;

class VerifikasiNilaiController extends Controller
{
    protected $hasilTestModel;
    protected $jawabanPesertaModel;
    protected $bankSoalModel;
    protected $pilihanJawabanModel;
    
    public function __construct()
    {
        $this->hasilTestModel = new HasilTestModel();
        $this->jawabanPesertaModel = new JawabanPesertaModel();
        $this->bankSoalModel = new BankSoalModel();
        $this->pilihanJawabanModel = new PilihanJawabanModel();
    }
    
    public function index()
    {
        $session = session();
        $userPuslit = $session->get('puslit');
        $userLevel = $session->get('level');
        
        if ($userLevel == 1) {
            // Superadmin dapat melihat semua hasil test
            $data['hasil_test'] = $this->hasilTestModel->getHasilTest();
        } else {
            // Admin hanya dapat melihat hasil test dari puslit mereka
            $data['hasil_test'] = $this->hasilTestModel->getHasilTestByPuslit($userPuslit);
        }
        
        return view('admin/v_verifikasi_nilai', $data);
    }
    
    public function detail($id)
    {
        $session = session();
        $userPuslit = $session->get('puslit');
        $userLevel = $session->get('level');
        
        $data['hasil'] = $this->hasilTestModel->getHasilTestById($id);
        
        // Cek apakah admin memiliki akses ke hasil test ini
        if ($userLevel != 1 && $data['hasil']['puslit'] != $userPuslit) {
            return redirect()->to(site_url('verifikasi'))->with('error', 'Anda tidak memiliki akses ke hasil test ini');
        }
        
        // Ambil jawaban peserta
        $id_peserta = $data['hasil']['id_peserta'];
        $id_set_soal = $data['hasil']['id_set_soal'];
        
        $jawaban = $this->jawabanPesertaModel->getJawabanPeserta($id_peserta, $id_set_soal);
        
        $data['jawaban'] = [];
        foreach ($jawaban as $j) {
            $soal = $this->bankSoalModel->getSoalWithPilihan($j['id_soal']);
            $j['soal'] = $soal;
            
            if ($j['id_pilihan_jawaban']) {
                $j['pilihan'] = $this->pilihanJawabanModel->find($j['id_pilihan_jawaban']);
            }
            
            $data['jawaban'][] = $j;
        }
        
        return view('admin/v_detail_verifikasi', $data);
    }
    
    public function verifikasi($id)
    {
        $session = session();
        $id_admin = $session->get('id');
        
        // Removed nilai_akhir, keep only status_lulus
        $status_lulus = $this->request->getPost('status_lulus');
        $catatan = $this->request->getPost('catatan');
        
        // Get the current nilai_mentah
        $hasil = $this->hasilTestModel->find($id);
        $nilai_mentah = $hasil['nilai_mentah'];
        
        // Verifikasi hasil test with the calculated nilai_mentah
        $this->hasilTestModel->verifikasiHasil($id, $nilai_mentah, $status_lulus, $catatan, $id_admin);
        
        return redirect()->to(site_url('verifikasi'))->with('success', 'Hasil test berhasil diverifikasi');
    }
} 