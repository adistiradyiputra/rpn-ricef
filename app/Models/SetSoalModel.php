<?php

namespace App\Models;

use CodeIgniter\Model;

class SetSoalModel extends Model
{
    protected $table = 'set_soal';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama_set', 'jenis', 'id_detail_pelatihan', 'aktif', 'created_by', 'updated_by'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    public function getSetSoalWithDetail()
    {
        return $this->select('
            set_soal.*,
            detail_pelatihan.id as id_detail_pelatihan,
            pelatihan.nama_pelatihan,
            pelatihan.puslit,
            users.name as created_by_name
        ')
        ->join('detail_pelatihan', 'detail_pelatihan.id = set_soal.id_detail_pelatihan', 'left')
        ->join('pelatihan', 'pelatihan.id = detail_pelatihan.id_pelatihan', 'left')
        ->join('users', 'users.id = set_soal.created_by', 'left')
        ->orderBy('set_soal.id', 'DESC')
        ->findAll();
    }
    
    public function getSetSoalByPelatihan($id_detail_pelatihan, $jenis = null)
    {
        $builder = $this->select('
            set_soal.*,
            detail_pelatihan.id as id_detail_pelatihan,
            pelatihan.nama_pelatihan,
            pelatihan.puslit
        ')
        ->join('detail_pelatihan', 'detail_pelatihan.id = set_soal.id_detail_pelatihan')
        ->join('pelatihan', 'pelatihan.id = detail_pelatihan.id_pelatihan')
        ->where('set_soal.id_detail_pelatihan', $id_detail_pelatihan)
        ->where('set_soal.aktif', 1);

        if ($jenis) {
            $builder->where('set_soal.jenis', $jenis);
        }

        return $builder->findAll();
    }
    
    public function getSetSoalWithItems($id)
    {
        // Get set soal data
        $set_soal = $this->select('
            set_soal.*,
            detail_pelatihan.id as id_detail_pelatihan,
            pelatihan.nama_pelatihan,
            pelatihan.puslit
        ')
        ->join('detail_pelatihan', 'detail_pelatihan.id = set_soal.id_detail_pelatihan', 'left')
        ->join('pelatihan', 'pelatihan.id = detail_pelatihan.id_pelatihan', 'left')
        ->find($id);

        if ($set_soal) {
            // Get items (soal) for this set
            $db = \Config\Database::connect();
            $items = $db->table('set_soal_items')
                ->select('
                    set_soal_items.*,
                    bank_soal.pertanyaan
                ')
                ->join('bank_soal', 'bank_soal.id = set_soal_items.id_soal')
                ->where('set_soal_items.id_set_soal', $id)
                ->get()
                ->getResultArray();
            
            // Get pilihan jawaban for each soal
            $pilihanJawabanModel = new \App\Models\PilihanJawabanModel();
            foreach ($items as &$item) {
                $item['pilihan'] = $pilihanJawabanModel->where('id_soal', $item['id_soal'])
                                                   ->orderBy('urutan', 'ASC')
                                                   ->findAll();
            }

            $set_soal['items'] = $items;
            
            // Debugging - log jumlah items
            log_message('debug', 'Set Soal ID: ' . $id . ' memiliki ' . count($items) . ' soal');
        }

        return $set_soal;
    }
} 