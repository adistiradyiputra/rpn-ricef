<?php

namespace App\Controllers;

use App\Models\BankSoalModel;
use App\Models\PilihanJawabanModel;
use App\Models\SetSoalModel;
use App\Models\SetSoalItemsModel;
use App\Models\DetailPelatihanModel;
use CodeIgniter\Controller;

class BankSoalController extends Controller
{
    protected $bankSoalModel;
    protected $pilihanJawabanModel;
    protected $setSoalModel;
    protected $setSoalItemsModel;
    protected $detailPelatihanModel;
    
    public function __construct()
    {
        $this->bankSoalModel = new BankSoalModel();
        $this->pilihanJawabanModel = new PilihanJawabanModel();
        $this->setSoalModel = new SetSoalModel();
        $this->setSoalItemsModel = new SetSoalItemsModel();
        $this->detailPelatihanModel = new DetailPelatihanModel();
    }
    
    public function index()
    {
        $session = session();
        $userPuslit = $session->get('puslit');
        $userLevel = $session->get('level');
        
        // Dapatkan set soal dengan detail termasuk jumlah soal
        $data['set_soal'] = $this->setSoalModel->getSetSoalWithDetail();
        
        // Filter berdasarkan puslit jika bukan superadmin
        if ($userLevel != 1) {
            $filtered = [];
            foreach ($data['set_soal'] as $set) {
                if ($set['puslit'] == $userPuslit) {
                    $filtered[] = $set;
                }
            }
            $data['set_soal'] = $filtered;
        }
        
        // Dapatkan jumlah soal untuk setiap set soal
        foreach ($data['set_soal'] as &$set) {
            $items = $this->setSoalItemsModel->where('id_set_soal', $set['id'])->findAll();
            $set['items'] = $items;
        }
        
        return view('soal/v_bank_soal_combined', $data);
    }
    
    public function create()
    {
        // Get pelatihan for dropdown - filter by puslit if not superadmin
        $session = session();
        $userPuslit = $session->get('puslit');
        $userLevel = $session->get('level');
        
        if ($userLevel == 1) {
            $data['pelatihan'] = $this->detailPelatihanModel->getPelatihanDetails();
        } else {
            $data['pelatihan'] = $this->detailPelatihanModel->getPelatihanDetailsByPuslit($userPuslit);
        }
        
        return view('soal/v_tambah_soal_combined', $data);
    }
    
    public function edit($id)
    {
        $data['soal'] = $this->bankSoalModel->getSoalWithPilihan($id);
        return view('soal/v_edit_soal', $data);
    }
    
    public function save()
    {
        $session = session();
        
        $data = [
            'pertanyaan' => $this->request->getPost('pertanyaan'),
            'aktif' => $this->request->getPost('aktif') ?? 1,
            'created_by' => $session->get('id')
        ];
        
        $this->bankSoalModel->save($data);
        $id_soal = $this->bankSoalModel->getInsertID();
        
        // Simpan pilihan jawaban
        $pilihan = [];
        $teks_pilihan = $this->request->getPost('teks_pilihan');
        $is_benar = $this->request->getPost('is_benar');
        
        if (!empty($teks_pilihan)) {
            foreach ($teks_pilihan as $key => $teks) {
                if (!empty($teks)) {
                    $pilihan[] = [
                        'teks' => $teks,
                        'is_benar' => ($is_benar == $key) ? 1 : 0
                    ];
                }
            }
            
            $this->pilihanJawabanModel->savePilihanJawaban($id_soal, $pilihan);
        }
        
        return redirect()->to(site_url('banksoal'))->with('success', 'Soal berhasil ditambahkan');
    }
    
    public function update($id)
    {
        $session = session();
        
        $data = [
            'pertanyaan' => $this->request->getPost('pertanyaan'),
            'aktif' => $this->request->getPost('aktif') ?? 1,
            'updated_by' => $session->get('id')
        ];
        
        $this->bankSoalModel->update($id, $data);
        
        // Simpan pilihan jawaban
        $pilihan = [];
        $teks_pilihan = $this->request->getPost('teks_pilihan');
        $is_benar = $this->request->getPost('is_benar');
        
        if (!empty($teks_pilihan)) {
            foreach ($teks_pilihan as $key => $teks) {
                if (!empty($teks)) {
                    $pilihan[] = [
                        'teks' => $teks,
                        'is_benar' => ($is_benar == $key) ? 1 : 0
                    ];
                }
            }
            
            $this->pilihanJawabanModel->savePilihanJawaban($id, $pilihan);
        }
        
        return redirect()->to(site_url('banksoal'))->with('success', 'Soal berhasil diperbarui');
    }
    
    public function delete($id)
    {
        $this->bankSoalModel->delete($id);
        return $this->response->setJSON(['success' => true]);
    }
    
    public function getSoal($id = null)
    {
        if ($id) {
            $data = $this->bankSoalModel->getSoalWithPilihan($id);
        } else {
            $data = $this->bankSoalModel->getSoalWithKategori();
        }
        
        return $this->response->setJSON(['success' => true, 'data' => $data]);
    }
    
    public function getSoalByKategori()
    {
        
        // Log jumlah soal yang ditemukan
        log_message('debug', 'Found ' . count($data) . ' soal');
        
        return $this->response->setJSON(['success' => true, 'data' => $data]);
    }
    
    // Add set soal functions from SetSoalController
    public function create_set()
    {
        $session = session();
        $userPuslit = $session->get('puslit');
        $userLevel = $session->get('level');
        
        // Get pelatihan for dropdown - filter by puslit if not superadmin
        if ($userLevel == 1) {
            $data['pelatihan'] = $this->detailPelatihanModel->getPelatihanDetails();
        } else {
            $data['pelatihan'] = $this->detailPelatihanModel->getPelatihanDetailsByPuslit($userPuslit);
        }
        
        return view('soal/v_tambah_set_soal_combined', $data);
    }
    
    public function edit_set($id)
    {
        $session = session();
        $userPuslit = $session->get('puslit');
        $userLevel = $session->get('level');
        
        $data['set_soal'] = $this->setSoalModel->getSetSoalWithItems($id);
        
        // Cek apakah user memiliki akses ke set soal ini
        if ($userLevel != 1 && $data['set_soal']['puslit'] != $userPuslit) {
            return redirect()->to(site_url('banksoal'))->with('error', 'Anda tidak memiliki akses ke set soal ini');
        }
        
        // Get pelatihan for dropdown - filter by puslit if not superadmin
        if ($userLevel == 1) {
            $data['pelatihan'] = $this->detailPelatihanModel->getPelatihanDetails();
        } else {
            $data['pelatihan'] = $this->detailPelatihanModel->getPelatihanDetailsByPuslit($userPuslit);
        }
        return view('soal/v_edit_set_soal_combined', $data);
    }
    
    public function save_set()
    {
        $session = session();
        
        $data = [
            'nama_set' => $this->request->getPost('nama_set'),
            'jenis' => $this->request->getPost('jenis'),
            'id_detail_pelatihan' => $this->request->getPost('id_detail_pelatihan'),
            'aktif' => $this->request->getPost('aktif') ?? 1,
            'created_by' => $session->get('id')
        ];
        
        // Simpan set soal
        $this->setSoalModel->save($data);
        $id_set_soal = $this->setSoalModel->getInsertID();
        
        // Ambil data soal dan bobot
        $id_soal = $this->request->getPost('id_soal');
        $bobot = $this->request->getPost('bobot_values');
        
        // Debug
        log_message('debug', 'id_soal: ' . json_encode($id_soal));
        log_message('debug', 'bobot: ' . json_encode($bobot));
        
        // Jika ada soal yang dipilih
        if ($id_soal && is_array($id_soal)) {
            $items = [];
            
            // Pastikan jumlah bobot sesuai dengan jumlah soal
            $bobotCount = is_array($bobot) ? count($bobot) : 0;
            
            foreach ($id_soal as $key => $id) {
                // Gunakan bobot yang sesuai jika tersedia, atau default ke 1
                $bobotValue = ($key < $bobotCount && isset($bobot[$key])) ? $bobot[$key] : 1;
                
                $items[] = [
                    'id_soal' => $id,
                    'bobot' => $bobotValue
                ];
            }
            
            if (!empty($items)) {
                $result = $this->setSoalItemsModel->saveSetSoalItems($id_set_soal, $items);
                if (!$result) {
                    return redirect()->to(site_url('banksoal'))->with('error', 'Gagal menyimpan item soal');
                }
            }
        } else {
            return redirect()->to(site_url('banksoal'))->with('warning', 'Set soal berhasil dibuat tetapi tidak ada soal yang dipilih');
        }
        
        return redirect()->to(site_url('banksoal'))->with('success', 'Set soal berhasil ditambahkan');
    }
    
    public function update_set($id)
    {
        $session = session();
        
        $data = [
            'nama_set' => $this->request->getPost('nama_set'),
            'jenis' => $this->request->getPost('jenis'),
            'id_detail_pelatihan' => $this->request->getPost('id_detail_pelatihan'),
            'aktif' => $this->request->getPost('aktif') ?? 1,
            'updated_by' => $session->get('id')
        ];
        
        // Update set soal data
        $this->setSoalModel->update($id, $data);
        
        // Get existing questions to keep
        $id_soal = $this->request->getPost('id_soal') ?? [];
        $pertanyaan = $this->request->getPost('pertanyaan') ?? [];
        
        // Get questions to delete
        $delete_soal = $this->request->getPost('delete_soal') ?? [];
        
        // Filter out deleted questions
        $keep_soal = [];
        foreach ($id_soal as $idx => $id_s) {
            if (!in_array($id_s, $delete_soal)) {
                $keep_soal[] = [
                    'id' => $id_s,
                    'pertanyaan' => $pertanyaan[$idx] ?? ''
                ];
            }
        }
        
        // New questions to add
        $pertanyaan_baru = $this->request->getPost('pertanyaan_baru') ?? [];
        
        // Prepare items array for existing questions
        $items = [];
        
        // Update existing questions
        foreach ($keep_soal as $idx => $soal) {
            // Update question text if needed
            $this->bankSoalModel->update($soal['id'], [
                'pertanyaan' => $soal['pertanyaan'],
                'updated_by' => $session->get('id')
            ]);
            
            // Add to items array
            $items[] = [
                'id_soal' => $soal['id']
            ];
            
            // Update answer choices
            $teks_pilihan = $this->request->getPost('teks_pilihan_' . $idx) ?? [];
            $is_benar = $this->request->getPost('is_benar_' . $idx) ?? 0;
            
            $pilihan = [];
            if (!empty($teks_pilihan)) {
                foreach ($teks_pilihan as $key => $teks) {
                    if (!empty($teks)) {
                        $pilihan[] = [
                            'teks' => $teks,
                            'is_benar' => ($is_benar == $key) ? 1 : 0
                        ];
                    }
                }
                
                if (!empty($pilihan)) {
                    $this->pilihanJawabanModel->savePilihanJawaban($soal['id'], $pilihan);
                }
            }
        }
        
        // Process new questions
        if (!empty($pertanyaan_baru)) {
            foreach ($pertanyaan_baru as $index => $teks_pertanyaan) {
                // Save the new question
                $data_soal = [
                    'pertanyaan' => $teks_pertanyaan,
                    'aktif' => 1,
                    'created_by' => $session->get('id')
                ];
                
                $this->bankSoalModel->save($data_soal);
                $new_id_soal = $this->bankSoalModel->getInsertID();
                
                // Add to items array
                $items[] = [
                    'id_soal' => $new_id_soal
                ];
                
                // Get the answer choices for this question
                $question_index = 'new_' . $index;
                $teks_pilihan = $this->request->getPost('teks_pilihan_new_' . $index) ?? [];
                $is_benar = $this->request->getPost('is_benar_new_' . $index) ?? 0;
                
                // Save answer choices
                $pilihan = [];
                if (!empty($teks_pilihan)) {
                    foreach ($teks_pilihan as $key => $teks) {
                        if (!empty($teks)) {
                            $pilihan[] = [
                                'teks' => $teks,
                                'is_benar' => ($is_benar == $key) ? 1 : 0
                            ];
                        }
                    }
                    
                    if (!empty($pilihan)) {
                        $this->pilihanJawabanModel->savePilihanJawaban($new_id_soal, $pilihan);
                    }
                }
            }
        }
        
        // Save all items to the set
        if (!empty($items)) {
            $result = $this->setSoalItemsModel->saveSetSoalItems($id, $items);
            if (!$result) {
                return redirect()->to(site_url('banksoal'))->with('error', 'Gagal menyimpan item soal');
            }
        } else {
            return redirect()->to(site_url('banksoal'))->with('warning', 'Set soal berhasil diperbarui tetapi tidak ada soal yang dipilih');
        }
        
        return redirect()->to(site_url('banksoal'))->with('success', 'Set soal berhasil diperbarui');
    }
    
    public function delete_set($id)
    {
        $this->setSoalModel->delete($id);
        return $this->response->setJSON(['success' => true]);
    }
    
    public function getSetSoal($id = null)
    {
        if ($id) {
            $data = $this->setSoalModel->getSetSoalWithItems($id);
        } else {
            $data = $this->setSoalModel->getSetSoalWithDetail();
        }
        
        return $this->response->setJSON(['success' => true, 'data' => $data]);
    }
    
    public function getSetSoalByPelatihan($id_detail_pelatihan, $jenis = null)
    {
        $data = $this->setSoalModel->getSetSoalByPelatihan($id_detail_pelatihan, $jenis);
        return $this->response->setJSON(['success' => true, 'data' => $data]);
    }
    
    public function save_combined()
    {
        $session = session();
        
        // Ambil data form
        $id_detail_pelatihan = $this->request->getPost('id_detail_pelatihan');
        $jenis = $this->request->getPost('jenis');
        $aktif = $this->request->getPost('aktif') ?? 1;
        $pertanyaan = $this->request->getPost('pertanyaan');
        
        // Buat set soal baru
        $data_set = [
            'nama_set' => 'Set ' . $jenis . ' ' . date('Y-m-d H:i:s'), // Generate nama set otomatis
            'jenis' => $jenis,
            'id_detail_pelatihan' => $id_detail_pelatihan,
            'aktif' => $aktif,
            'created_by' => $session->get('id')
        ];
        
        // Simpan set soal
        $this->setSoalModel->save($data_set);
        $id_set_soal = $this->setSoalModel->getInsertID();
        
        // Proses setiap pertanyaan
        if (!empty($pertanyaan) && is_array($pertanyaan)) {
            $items = []; // Untuk mengumpulkan item soal untuk set soal
            
            foreach ($pertanyaan as $index => $teks_pertanyaan) {
                // Simpan soal
                $data_soal = [
                    'pertanyaan' => $teks_pertanyaan,
                    'aktif' => 1,
                    'created_by' => $session->get('id')
                ];
                
                $this->bankSoalModel->save($data_soal);
                $id_soal = $this->bankSoalModel->getInsertID();
                
                // Ambil pilihan jawaban untuk pertanyaan ini
                $teks_pilihan = $this->request->getPost('teks_pilihan_' . $index);
                $is_benar = $this->request->getPost('is_benar_' . $index);
                
                // Simpan pilihan jawaban
                $pilihan = [];
                if (!empty($teks_pilihan)) {
                    foreach ($teks_pilihan as $key => $teks) {
                        if (!empty($teks)) {
                            $pilihan[] = [
                                'teks' => $teks,
                                'is_benar' => ($is_benar == $key) ? 1 : 0
                            ];
                        }
                    }
                    
                    if (!empty($pilihan)) {
                        $this->pilihanJawabanModel->savePilihanJawaban($id_soal, $pilihan);
                    }
                }
                
                // Tambahkan soal ke set soal dengan bobot 1
                $items[] = [
                    'id_soal' => $id_soal,
                ];
            }
            
            // Simpan item ke set soal
            if (!empty($items)) {
                $this->setSoalItemsModel->saveSetSoalItems($id_set_soal, $items);
            }
        }
        
        return redirect()->to(site_url('banksoal'))->with('success', 'Soal berhasil ditambahkan ke Bank Soal');
    }

    // Tambahkan method untuk melihat detail set soal
    public function detail_set($id)
    {
        $session = session();
        $userPuslit = $session->get('puslit');
        $userLevel = $session->get('level');
        
        $data['set_soal'] = $this->setSoalModel->getSetSoalWithItems($id);
        
        // Cek apakah user memiliki akses ke set soal ini
        if ($userLevel != 1 && $data['set_soal']['puslit'] != $userPuslit) {
            return redirect()->to(site_url('banksoal'))->with('error', 'Anda tidak memiliki akses ke set soal ini');
        }
        
        return view('soal/v_detail_set_soal', $data);
    }
}