<?php

namespace App\Controllers;

use App\Models\PelatihanModel;
use CodeIgniter\Controller;

class PelatihanController extends Controller
{
    protected $pelatihanModel;

    public function __construct()
    {
        $this->pelatihanModel = new PelatihanModel();
    }

    public function index()
    {
        return view('v_pelatihan');
    }

    public function getPelatihan()
    {
        $session = session();
        $userPuslit = $session->get('puslit');
        
        if ($userPuslit && $userPuslit !== 'superadmin') {
            // If user has specific puslit, show only their data
            $pelatihan = $this->pelatihanModel->where('puslit', $userPuslit)->findAll();
        } else {
            // If superadmin or no puslit specified, show all data
            $pelatihan = $this->pelatihanModel->findAll();
        }
        
        return $this->response->setJSON(['data' => $pelatihan]);
    }

    public function savePelatihan()
    {
      
        $puslit = $this->request->getPost('puslit');
        $nama_pelatihan = $this->request->getPost('nama_pelatihan');

        $data = [];
        foreach ($nama_pelatihan as $pelatihan) {
            if (!empty($pelatihan)) {
                $data[] = [
                    'puslit' => $puslit,
                    'nama_pelatihan' => $pelatihan
                ];
            }
        }

        if (!empty($data)) {
            $this->pelatihanModel->insertBatch($data);
        }

        return $this->response->setJSON(['success' => true]);
    }


    public function updatePelatihan($id)
    {
        $data = [
            'puslit' => $this->request->getPost('puslit'),
            'nama_pelatihan' => $this->request->getPost('nama_pelatihan'),
        ];

        $this->pelatihanModel->update($id, $data);
        return $this->response->setJSON(['success' => true]);
    }

    public function deletePelatihan($id)
    {
        $this->pelatihanModel->delete($id);
        return $this->response->setJSON(['success' => true]);
    }

    public function getPelatihanById($id)
    {
        $pelatihan = $this->pelatihanModel->find($id);
        
        if ($pelatihan) {
            return $this->response->setJSON([
                'success' => true,
                'data' => $pelatihan
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Pelatihan tidak ditemukan'
            ]);
        }
    }
}