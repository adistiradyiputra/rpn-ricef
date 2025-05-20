<?php

namespace App\Controllers;

use App\Models\SetSoalModel;
use App\Models\SetSoalItemsModel;
use App\Models\DetailPelatihanModel;
use App\Models\BankSoalModel;
use CodeIgniter\Controller;

class SetSoalController extends Controller
{
    protected $setSoalModel;
    protected $setSoalItemsModel;
    protected $detailPelatihanModel;
    protected $bankSoalModel;
    
    public function __construct()
    {
        $this->setSoalModel = new SetSoalModel();
        $this->setSoalItemsModel = new SetSoalItemsModel();
        $this->detailPelatihanModel = new DetailPelatihanModel();
        $this->bankSoalModel = new BankSoalModel();
    }
    
    public function index()
    {
        $session = session();
        $userPuslit = $session->get('puslit');
        $userLevel = $session->get('level');
        
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
        
        return view('soal/v_set_soal', $data);
    }
    
    public function create()
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
        
        // Hapus kategori karena sudah tidak digunakan
        // $data['kategori'] = $this->kategoriSoalModel->findAll();
        
        return view('soal/v_tambah_set_soal', $data);
    }
    
    public function edit($id)
    {
        $session = session();
        $userPuslit = $session->get('puslit');
        $userLevel = $session->get('level');
        
        $data['set_soal'] = $this->setSoalModel->getSetSoalWithItems($id);
        
        // Cek apakah user memiliki akses ke set soal ini
        if ($userLevel != 1 && $data['set_soal']['puslit'] != $userPuslit) {
            return redirect()->to(site_url('setsoal'))->with('error', 'Anda tidak memiliki akses ke set soal ini');
        }
        
        // Get pelatihan for dropdown - filter by puslit if not superadmin
        if ($userLevel == 1) {
            $data['pelatihan'] = $this->detailPelatihanModel->getPelatihanDetails();
        } else {
            $data['pelatihan'] = $this->detailPelatihanModel->getPelatihanDetailsByPuslit($userPuslit);
        }
        return view('soal/v_edit_set_soal');
    }
    
    public function save()
    {
        $session = session();
        
        $data = [
            'nama_set' => $this->request->getPost('nama_set'),
            'jenis' => $this->request->getPost('jenis'),
            'id_detail_pelatihan' => $this->request->getPost('id_detail_pelatihan'),
            'waktu_pengerjaan' => $this->request->getPost('waktu_pengerjaan'),
            'nilai_lulus' => $this->request->getPost('nilai_lulus'),
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
                    return redirect()->to(site_url('setsoal'))->with('error', 'Gagal menyimpan item soal');
                }
            }
        } else {
            return redirect()->to(site_url('setsoal'))->with('warning', 'Set soal berhasil dibuat tetapi tidak ada soal yang dipilih');
        }
        
        return redirect()->to(site_url('setsoal'))->with('success', 'Set soal berhasil ditambahkan');
    }
    
    public function update($id)
    {
        $session = session();
        
        $data = [
            'nama_set' => $this->request->getPost('nama_set'),
            'jenis' => $this->request->getPost('jenis'),
            'id_detail_pelatihan' => $this->request->getPost('id_detail_pelatihan'),
            'waktu_pengerjaan' => $this->request->getPost('waktu_pengerjaan'),
            'nilai_lulus' => $this->request->getPost('nilai_lulus'),
            'aktif' => $this->request->getPost('aktif') ?? 1,
            'updated_by' => $session->get('id')
        ];
        
        // Tambahkan log untuk debugging
        log_message('debug', 'Updating set soal: ' . json_encode($data));
        
        $this->setSoalModel->update($id, $data);
        
        // Simpan item soal
        $id_soal = $this->request->getPost('id_soal');
        $bobot = $this->request->getPost('bobot');
        
        // Tambahkan log untuk debugging
        log_message('debug', 'id_soal: ' . json_encode($id_soal));
        log_message('debug', 'bobot: ' . json_encode($bobot));
        
        $items = [];
        if ($id_soal) {
            foreach ($id_soal as $key => $id_s) {
                $items[] = [
                    'id_soal' => $id_s,
                    'bobot' => $bobot[$key] ?? 1
                ];
            }
            
            // PERBAIKAN: Gunakan $id sebagai id_set_soal, bukan sebagai array items
            $result = $this->setSoalItemsModel->saveSetSoalItems($id, $items);
            if (!$result) {
                return redirect()->to(site_url('setsoal'))->with('error', 'Gagal menyimpan item soal');
            }
        } else {
            return redirect()->to(site_url('setsoal'))->with('warning', 'Set soal berhasil diperbarui tetapi tidak ada soal yang dipilih');
        }
        
        return redirect()->to(site_url('setsoal'))->with('success', 'Set soal berhasil diperbarui');
    }
    
    public function delete($id)
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
} 