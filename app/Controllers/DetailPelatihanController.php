<?php

namespace App\Controllers;

use App\Models\DetailPelatihanModel;
use App\Models\PelatihanModel;
use App\Models\PesertaModel;
use App\Models\DokumenModel;
use App\Models\InstrukturModel;
use CodeIgniter\Controller;

class DetailPelatihanController extends Controller
{
    protected $detailPelatihanModel;
    protected $pelatihanModel;
    protected $pesertaModel;
    protected $dokumenModel;
    protected $instrukturModel;

    public function __construct()
    {
        $this->detailPelatihanModel = new DetailPelatihanModel();
        $this->pelatihanModel = new PelatihanModel();
        $this->pesertaModel = new PesertaModel();
        $this->dokumenModel = new DokumenModel();
        $this->instrukturModel = new InstrukturModel();
    }

    public function index()
    {
        $session = session();
        $userPuslit = $session->get('puslit');
        $userLevel = $session->get('level');
        
        // Get pelatihan for dropdown - filter by puslit if not superadmin
        if ($userLevel == 1) {
            $pelatihan = $this->pelatihanModel->findAll();
        } else {
            // Only get pelatihan for this specific puslit
            $pelatihan = $this->pelatihanModel->where('puslit', $userPuslit)->findAll();
        }
        
        // Filter pelatihan_detail based on user's puslit and level
        if ($userLevel == 1) {
            // Superadmin can see all pelatihan details
            $pelatihan_detail = $this->detailPelatihanModel->getPelatihanDetails();
        } else {
            // Regular admin can only see pelatihan details for their puslit
            $pelatihan_detail = $this->detailPelatihanModel->getPelatihanDetailsByPuslit($userPuslit);
        }

        if (empty($pelatihan_detail)) {
            $pelatihan_detail = [];
        }

        return view('v_detail_pelatihan', [
            'pelatihan' => $pelatihan,
            'pelatihan_detail' => $pelatihan_detail,
            'userPuslit' => $userPuslit,
            'userLevel' => $userLevel
        ]);
    }

    public function saveDetailPelatihan()
    {
        $image_url = null;
        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/pelatihan', $newName);
            $image_url = base_url('uploads/pelatihan/' . $newName);
        }

        // Ambil array pemateri dari form
        $pemateriArr = $this->request->getPost('pemateri_id');
        
        // Debug log
        log_message('debug', 'Raw pemateri data: ' . print_r($pemateriArr, true));
        
        // Pastikan data adalah array dan convert ke string
        if (is_array($pemateriArr)) {
            $pemateriId = implode(',', array_filter($pemateriArr));
        } else {
            $pemateriId = $pemateriArr;
        }
        
        // Debug log
        log_message('debug', 'Processed pemateri string: ' . $pemateriId);
        
        $data = [
            'id_pelatihan' => $this->request->getPost('id_pelatihan'),
            'periode_mulai_daftar' => $this->request->getPost('periode_mulai_daftar'),
            'periode_selesai_daftar' => $this->request->getPost('periode_selesai_daftar'),
            'jadwal_pelatihan' => $this->request->getPost('jadwal_pelatihan'),
            'pemateri' => $pemateriId,
            'status' => 1,
        ];

        if ($image_url !== null) {
            $data['image_url'] = $image_url;
        }

        try {
            $saved = $this->detailPelatihanModel->save($data);
            if ($saved) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Data berhasil disimpan',
                    'debug' => [
                        'pemateri_raw' => $pemateriArr,
                        'pemateri_saved' => $pemateriId
                    ]
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menyimpan data'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function delete($id)
    {
        // Check if ID is valid
        if ($this->detailPelatihanModel->find($id)) {
            // Delete data from database
            $this->detailPelatihanModel->delete($id);
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Data tidak ditemukan.']);
        }
    }

    public function update()
    {
        $id = $this->request->getPost('id_pelatihan');
        $pemateriArr = $this->request->getPost('pemateri_id');
        if (is_array($pemateriArr)) {
            $pemateriId = implode(',', $pemateriArr);
        } else {
            $pemateriId = $pemateriArr;
        }
        $data = [
            'pemateri' => $pemateriId,
            'periode_mulai_daftar' => $this->request->getPost('periode_mulai_daftar'),
            'periode_selesai_daftar' => $this->request->getPost('periode_selesai_daftar'),
            'jadwal_pelatihan' => $this->request->getPost('jadwal_pelatihan'),
        ];
        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/pelatihan', $newName);
            $data['image_url'] = base_url('uploads/pelatihan/' . $newName);
        }
        $this->detailPelatihanModel->update($id, $data);
        return $this->response->setJSON(['success' => true]);
    }

    public function getDetail($id)
    {
        // Get pelatihan detail by ID using model
        $detail = $this->detailPelatihanModel->getPelatihanById($id);

        if ($detail) {
            return $this->response->setJSON(['success' => true, 'data' => $detail]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Data tidak ditemukan.']);
        }
    }

    public function getDokumen($detail_pelatihan_id)
    {
        $dokumen = $this->detailPelatihanModel->getDokumenByDetailPelatihanId($detail_pelatihan_id);
        
        return $this->response->setJSON([
            'data' => $dokumen
        ]);
    }

    public function saveDokumen()
    {
        // Get form data
        $id_detail_pelatihan = $this->request->getPost('id_detail_pelatihan');
        $nama_dokumen = $this->request->getPost('nama_dokumen');
        
        // Handle file upload
        $lampiran_url = null;
        $file = $this->request->getFile('lampiran');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/dokumen', $newName);
            $lampiran_url = base_url('uploads/dokumen/' . $newName);
        }
        
        $data = [
            'id_detail_pelatihan' => $id_detail_pelatihan,
            'nama_dokumen' => $nama_dokumen,
            'lampiran' => $lampiran_url
        ];
        
        try {
            if ($this->dokumenModel->save($data)) {
                return $this->response->setJSON(['success' => true]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menyimpan dokumen'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function deleteDokumen($id)
    {
        // Get dokumen data
        $dokumen = $this->dokumenModel->find($id);
        
        if ($dokumen) {
            // Delete file if exists
            if ($dokumen['lampiran']) {
                $filepath = str_replace(base_url(), FCPATH, $dokumen['lampiran']);
                if (file_exists($filepath)) {
                    unlink($filepath);
                }
            }
            
            // Delete record from database
            if ($this->dokumenModel->delete($id)) {
                return $this->response->setJSON(['success' => true]);
            }
        }
        
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gagal menghapus dokumen'
        ]);
    }

    public function updateDokumen($id)
    {
        // Get form data
        $nama_dokumen = $this->request->getPost('nama_dokumen');
        
        $data = [
            'nama_dokumen' => $nama_dokumen
        ];
        
        // Handle file upload if new file is provided
        $file = $this->request->getFile('lampiran');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Delete old file if exists
            $oldDokumen = $this->dokumenModel->find($id);
            if ($oldDokumen && $oldDokumen['lampiran']) {
                $oldFilepath = str_replace(base_url(), FCPATH, $oldDokumen['lampiran']);
                if (file_exists($oldFilepath)) {
                    unlink($oldFilepath);
                }
            }
            
            // Save new file
            $newName = $file->getRandomName();
            $file->move('uploads/dokumen', $newName);
            $data['lampiran'] = base_url('uploads/dokumen/' . $newName);
        }
        
        try {
            if ($this->dokumenModel->update($id, $data)) {
                return $this->response->setJSON(['success' => true]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal memperbarui dokumen'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function getPeserta($detail_pelatihan_id)
    {
        try {
            $peserta = $this->detailPelatihanModel->getPesertaByDetailPelatihanId($detail_pelatihan_id);
            
            return $this->response->setJSON([
                'draw' => $this->request->getGet('draw'),
                'recordsTotal' => count($peserta),
                'recordsFiltered' => count($peserta),
                'data' => $peserta
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function savePeserta()
    {
        $data = [
            'id_detail_pelatihan' => $this->request->getPost('id_detail_pelatihan'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'nama' => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
            'instansi' => $this->request->getPost('instansi'),
            'telp' => $this->request->getPost('telp')
        ];
        
        try {
            if ($this->pesertaModel->save($data)) {
                return $this->response->setJSON(['success' => true]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to save participant'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function updatePeserta($id)
    {
        $data = [
            'username' => $this->request->getPost('username'),
            'nama' => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
            'instansi' => $this->request->getPost('instansi'),
            'telp' => $this->request->getPost('telp')
        ];
        
        // Update password only if provided
        if ($password = $this->request->getPost('password')) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        
        try {
            if ($this->pesertaModel->update($id, $data)) {
                return $this->response->setJSON(['success' => true]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to update participant'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function deletePeserta($id)
    {
        try {
            if ($this->pesertaModel->delete($id)) {
                return $this->response->setJSON(['success' => true]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function getPesertaCount($id)
    {
        $count = $this->detailPelatihanModel->countPesertaByDetailPelatihanId($id);
        
        return $this->response->setJSON([
            'success' => true,
            'count' => $count
        ]);
    }

    public function deleteAllPeserta($detail_pelatihan_id)
    {
        try {
            // Delete all peserta records related to this detail_pelatihan
            $this->detailPelatihanModel->deleteAllPesertaByDetailPelatihanId($detail_pelatihan_id);
            return $this->response->setJSON(['success' => true]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function deleteAllDokumen($detail_pelatihan_id)
    {
        try {
            // Delete all dokumen records related to this detail_pelatihan
            $this->detailPelatihanModel->deleteAllDokumenByDetailPelatihanId($detail_pelatihan_id);
            return $this->response->setJSON(['success' => true]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function getInstrukturOptions() {
        $instrukturModel = new InstrukturModel();
        $instruktur = $instrukturModel->findAll();
        
        $data = [];
        foreach ($instruktur as $ins) {
            $data[] = [
                'id' => $ins['id'],
                'nama' => $ins['nama']
            ];
        }
        
        return $this->response->setJSON([
            'success' => true,
            'data' => $data
        ]);
    }
}