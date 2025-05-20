<?php

namespace App\Models;

use CodeIgniter\Model;

class HasilTestModel extends Model
{
    protected $table = 'hasil_test';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_peserta', 'id_set_soal', 'waktu_mulai', 'waktu_selesai',
        'nilai_mentah', 'nilai_akhir', 'status_lulus', 'status_verifikasi',
        'catatan', 'diverifikasi_oleh'
    ];
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    public function getHasilTest($id_peserta = null)
    {
        $builder = $this->db->table('hasil_test ht');
        $builder->select('
            ht.*,
            p.nama as nama_peserta,
            ss.nama_set,
            ss.jenis,
            ss.aktif as set_aktif,
            pel.nama_pelatihan
        ');
        $builder->join('peserta p', 'p.id = ht.id_peserta', 'left');
        $builder->join('set_soal ss', 'ss.id = ht.id_set_soal', 'left');
        $builder->join('detail_pelatihan dp', 'dp.id = ss.id_detail_pelatihan', 'left');
        $builder->join('pelatihan pel', 'pel.id = dp.id_pelatihan', 'left');
        
        if ($id_peserta) {
            $builder->where('ht.id_peserta', $id_peserta);
        }
        
        $builder->orderBy('ht.id', 'DESC');
        return $builder->get()->getResultArray();
    }
    
    public function getHasilTestByPuslit($puslit)
    {
        $builder = $this->db->table('hasil_test ht');
        $builder->select('
            ht.*,
            p.nama as nama_peserta,
            ss.nama_set,
            ss.jenis,
            ss.aktif as set_aktif,
            pel.nama_pelatihan,
            pel.puslit
        ');
        $builder->join('peserta p', 'p.id = ht.id_peserta', 'left');
        $builder->join('set_soal ss', 'ss.id = ht.id_set_soal', 'left');
        $builder->join('detail_pelatihan dp', 'dp.id = ss.id_detail_pelatihan', 'left');
        $builder->join('pelatihan pel', 'pel.id = dp.id_pelatihan', 'left');
        $builder->where('pel.puslit', $puslit);
        $builder->orderBy('ht.id', 'DESC');
        return $builder->get()->getResultArray();
    }
    
    public function getHasilTestById($id)
    {
        $builder = $this->db->table('hasil_test ht');
        $builder->select('
            ht.*,
            p.nama as nama_peserta,
            ss.nama_set,
            ss.jenis,
            ss.aktif as set_aktif,
            pel.nama_pelatihan,
            pel.puslit
        ');
        $builder->join('peserta p', 'p.id = ht.id_peserta', 'left');
        $builder->join('set_soal ss', 'ss.id = ht.id_set_soal', 'left');
        $builder->join('detail_pelatihan dp', 'dp.id = ss.id_detail_pelatihan', 'left');
        $builder->join('pelatihan pel', 'pel.id = dp.id_pelatihan', 'left');
        $builder->where('ht.id', $id);
        return $builder->get()->getRowArray();
    }
    
    public function saveHasil($data)
    {
        // Cek apakah hasil sudah ada
        $existing = $this->where('id_peserta', $data['id_peserta'])
                         ->where('id_set_soal', $data['id_set_soal'])
                         ->first();
        
        if ($existing) {
            return $this->update($existing['id'], $data);
        } else {
            return $this->insert($data);
        }
    }
    
    public function verifikasiHasil($id, $nilai_mentah, $status_lulus, $catatan, $id_admin)
    {
        // Nilai akhir is same as nilai mentah
        $data = [
            'nilai_akhir' => $nilai_mentah,
            'status_lulus' => $status_lulus,
            'catatan' => $catatan,
            'status_verifikasi' => 'terverifikasi',
            'diverifikasi_oleh' => $id_admin
        ];
        
        return $this->update($id, $data);
    }
} 