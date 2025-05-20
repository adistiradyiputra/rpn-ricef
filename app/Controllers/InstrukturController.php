<?php

namespace App\Controllers;

use App\Models\InstrukturModel;
use CodeIgniter\Controller;

class InstrukturController extends Controller
{
    protected $instrukturModel;
    
    public function __construct()
    {
        $this->instrukturModel = new InstrukturModel();
    }
    
    public function index()
    {
        return view('v_instruktur');
    }
    
    public function getInstrukturData()
    {
        $instruktur = $this->instrukturModel->getAllInstruktur();
        
        return $this->response->setJSON([
            'data' => $instruktur
        ]);
    }
    
    public function getInstrukturById($id)
    {
        $instruktur = $this->instrukturModel->getInstrukturById($id);
        
        if ($instruktur) {
            return $this->response->setJSON([
                'success' => true,
                'data' => $instruktur
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Instruktur tidak ditemukan'
            ]);
        }
    }
    
    public function save()
    {
        $data = [
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password')
        ];
        
        try {
            $this->instrukturModel->saveInstruktur($data);
            return $this->response->setJSON(['success' => true]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    
    public function update($id)
    {
        $data = [
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password')
        ];
        
        try {
            $this->instrukturModel->updateInstruktur($id, $data);
            return $this->response->setJSON(['success' => true]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    
    public function delete($id)
    {
        try {
            $this->instrukturModel->delete($id);
            return $this->response->setJSON(['success' => true]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    
    public function getInstrukturOptions()
    {
        $instruktur = $this->instrukturModel->findAll();
        
        return $this->response->setJSON([
            'success' => true,
            'data' => $instruktur
        ]);
    }
} 