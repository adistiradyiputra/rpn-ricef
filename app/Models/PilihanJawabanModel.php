<?php

namespace App\Models;

use CodeIgniter\Model;

class PilihanJawabanModel extends Model
{
    protected $table = 'pilihan_jawaban';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_soal', 'teks_pilihan', 'is_benar', 'urutan'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    public function getJawabanBenar($id_soal)
    {
        return $this->where('id_soal', $id_soal)
                    ->where('is_benar', 1)
                    ->first();
    }
    
    public function savePilihanJawaban($id_soal, $pilihan)
    {
        // Hapus pilihan jawaban yang ada
        $this->where('id_soal', $id_soal)->delete();
        
        // Simpan pilihan jawaban baru
        $urutan = 1;
        foreach ($pilihan as $p) {
            $this->insert([
                'id_soal' => $id_soal,
                'teks_pilihan' => $p['teks'],
                'is_benar' => $p['is_benar'] ?? 0,
                'urutan' => $urutan++
            ]);
        }
        
        return true;
    }
} 