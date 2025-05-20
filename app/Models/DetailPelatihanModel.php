<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailPelatihanModel extends Model
{
    protected $table = 'detail_pelatihan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_pelatihan', 'periode_mulai_daftar', 'periode_selesai_daftar', 'jadwal_pelatihan', 'pemateri', 'status', 'image_url'];

    protected $useTimestamps = true;

    /**
     * Get all pelatihan details for superadmin
     * 
     * @return array
     */
    public function getPelatihanDetails()
    {
        return $this->select("detail_pelatihan.*, pelatihan.nama_pelatihan, pelatihan.puslit, (
            SELECT GROUP_CONCAT(nama SEPARATOR ', ') FROM instruktur WHERE FIND_IN_SET(instruktur.id, detail_pelatihan.pemateri)
        ) as nama_pemateri")
            ->join('pelatihan', 'pelatihan.id = detail_pelatihan.id_pelatihan')
            ->orderBy('detail_pelatihan.id', 'DESC')
            ->findAll();
    }

    /**
     * Get pelatihan details by ID
     * 
     * @param int $id
     * @return array|null
     */
    public function getPelatihanById($id)
    {
        return $this->select("detail_pelatihan.*, pelatihan.nama_pelatihan, pelatihan.puslit, (
            SELECT GROUP_CONCAT(nama SEPARATOR ', ') FROM instruktur WHERE FIND_IN_SET(instruktur.id, detail_pelatihan.pemateri)
        ) as nama_pemateri")
            ->join('pelatihan', 'pelatihan.id = detail_pelatihan.id_pelatihan')
            ->where('detail_pelatihan.id', $id)
            ->first();
    }

    /**
     * Get pelatihan details filtered by puslit
     * 
     * @param string $puslit
     * @return array
     */
    public function getPelatihanDetailsByPuslit($puslit)
    {
        return $this->select("detail_pelatihan.*, pelatihan.nama_pelatihan, pelatihan.puslit, (
            SELECT GROUP_CONCAT(nama SEPARATOR ', ') FROM instruktur WHERE FIND_IN_SET(instruktur.id, detail_pelatihan.pemateri)
        ) as nama_pemateri")
            ->join('pelatihan', 'pelatihan.id = detail_pelatihan.id_pelatihan')
            ->where('pelatihan.puslit', $puslit)
            ->orderBy('detail_pelatihan.id', 'DESC')
            ->findAll();
    }
    
    /**
     * Get dokumen by detail_pelatihan_id
     * 
     * @param int $detail_pelatihan_id
     * @return array
     */
    public function getDokumenByDetailPelatihanId($detail_pelatihan_id)
    {
        $dokumenModel = new \App\Models\DokumenModel();
        return $dokumenModel->where('id_detail_pelatihan', $detail_pelatihan_id)->findAll();
    }
    
    /**
     * Get peserta by detail_pelatihan_id
     * 
     * @param int $detail_pelatihan_id
     * @return array
     */
    public function getPesertaByDetailPelatihanId($detail_pelatihan_id)
    {
        $pesertaModel = new \App\Models\PesertaModel();
        return $pesertaModel->where('id_detail_pelatihan', $detail_pelatihan_id)->findAll();
    }
    
    /**
     * Count peserta by detail_pelatihan_id
     * 
     * @param int $detail_pelatihan_id
     * @return int
     */
    public function countPesertaByDetailPelatihanId($detail_pelatihan_id)
    {
        $pesertaModel = new \App\Models\PesertaModel();
        return $pesertaModel->where('id_detail_pelatihan', $detail_pelatihan_id)->countAllResults();
    }
    
    /**
     * Delete all peserta by detail_pelatihan_id
     * 
     * @param int $detail_pelatihan_id
     * @return bool
     */
    public function deleteAllPesertaByDetailPelatihanId($detail_pelatihan_id)
    {
        $pesertaModel = new \App\Models\PesertaModel();
        return $pesertaModel->where('id_detail_pelatihan', $detail_pelatihan_id)->delete();
    }
    
    /**
     * Delete all dokumen by detail_pelatihan_id
     * 
     * @param int $detail_pelatihan_id
     * @return bool
     */
    public function deleteAllDokumenByDetailPelatihanId($detail_pelatihan_id)
    {
        $dokumenModel = new \App\Models\DokumenModel();
        
        // Get all dokumen records to delete their files
        $dokumen = $dokumenModel->where('id_detail_pelatihan', $detail_pelatihan_id)->findAll();
        
        // Delete physical files
        foreach ($dokumen as $doc) {
            if (!empty($doc['lampiran'])) {
                $filepath = str_replace(base_url(), FCPATH, $doc['lampiran']);
                if (file_exists($filepath)) {
                    unlink($filepath);
                }
            }
        }
        
        // Delete all dokumen records
        return $dokumenModel->where('id_detail_pelatihan', $detail_pelatihan_id)->delete();
    }
} 