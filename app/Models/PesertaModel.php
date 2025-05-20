<?php

namespace App\Models;

use CodeIgniter\Model;

class PesertaModel extends Model
{
    protected $table = 'peserta';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_detail_pelatihan',
        'username',
        'password',
        'nama',
        'alamat',
        'instansi',
        'telp',
        'level',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    /**
     * Get all peserta with their related pelatihan details
     *
     * @return array
     */
    public function getAllPesertaWithDetails()
    {
        $builder = $this->builder();
        $builder->select('peserta.*, detail_pelatihan.jadwal_pelatihan, pelatihan.id as id_pelatihan, pelatihan.nama_pelatihan, pelatihan.puslit');
        $builder->join('detail_pelatihan', 'detail_pelatihan.id = peserta.id_detail_pelatihan', 'left');
        $builder->join('pelatihan', 'pelatihan.id = detail_pelatihan.id_pelatihan', 'left');
        $builder->orderBy('peserta.id', 'DESC');
        
        return $builder->get()->getResultArray();
    }
    
    /**
     * Get peserta filtered by puslit with their related pelatihan details
     *
     * @param string $puslit
     * @return array
     */
    public function getPesertaByPuslitWithDetails($puslit)
    {
        $builder = $this->builder();
        $builder->select('peserta.*, detail_pelatihan.jadwal_pelatihan, pelatihan.id as id_pelatihan, pelatihan.nama_pelatihan, pelatihan.puslit');
        $builder->join('detail_pelatihan', 'detail_pelatihan.id = peserta.id_detail_pelatihan', 'left');
        $builder->join('pelatihan', 'pelatihan.id = detail_pelatihan.id_pelatihan', 'left');
        $builder->where('pelatihan.puslit', $puslit);
        $builder->orderBy('peserta.id', 'DESC');
        
        return $builder->get()->getResultArray();
    }
} 