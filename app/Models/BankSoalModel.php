<?php

namespace App\Models;

use CodeIgniter\Model;

class BankSoalModel extends Model
{
    protected $table = 'bank_soal';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'pertanyaan', 
        'aktif', 'created_by', 'updated_by'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    public function getSoalWithKategori($id = null)
    {
        $builder = $this->db->table('bank_soal bs');
        $builder->select('bs.*');
        
        if ($id !== null) {
            $builder->where('bs.id', $id);
            return $builder->get()->getRowArray();
        }
        
        $builder->orderBy('bs.id', 'DESC');
        return $builder->get()->getResultArray();
    }
    
    public function getSoalWithPilihan($id)
    {
        $soal = $this->getSoalWithKategori($id);
        
        if ($soal) {
            $pilihanModel = new PilihanJawabanModel();
            $soal['pilihan'] = $pilihanModel->where('id_soal', $id)
                                           ->orderBy('urutan', 'ASC')
                                           ->findAll();
        }
        
        return $soal;
    }
    
} 