<?php

namespace App\Models;

use CodeIgniter\Model;

class JawabanPesertaModel extends Model
{
    protected $table = 'jawaban_peserta';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_peserta', 'id_set_soal', 'id_soal', 'id_pilihan_jawaban', 
        'jawaban_text', 'is_benar', 'nilai_soal', 'waktu_mulai', 'waktu_selesai'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    public function getJawabanPeserta($id_peserta, $id_set_soal)
    {
        return $this->where('id_peserta', $id_peserta)
                    ->where('id_set_soal', $id_set_soal)
                    ->findAll();
    }
    
    public function saveJawaban($data)
    {
        // Cek apakah jawaban sudah ada
        $existing = $this->where('id_peserta', $data['id_peserta'])
                         ->where('id_set_soal', $data['id_set_soal'])
                         ->where('id_soal', $data['id_soal'])
                         ->first();
        
        if ($existing) {
            return $this->update($existing['id'], $data);
        } else {
            return $this->insert($data);
        }
    }
    
    public function hitungNilaiMentah($id_peserta, $id_set_soal)
    {
        $setsoalModel = new SetSoalModel();
        $setsoalItemsModel = new SetSoalItemsModel();
        
        // Get all items in the set
        $items = $setsoalItemsModel->where('id_set_soal', $id_set_soal)->findAll();
        $totalSoal = count($items);
        
        if ($totalSoal == 0) {
            return 0; // Prevent division by zero
        }
        
        // Get all answered questions
        $jawaban = $this->where('id_peserta', $id_peserta)
                        ->where('id_set_soal', $id_set_soal)
                        ->findAll();
        
        // Count correct answers
        $correctAnswers = 0;
        foreach ($jawaban as $j) {
            if ($j['is_benar'] == 1) {
                $correctAnswers++;
            }
        }
        
        // Calculate score (100 divided by number of questions * correct answers)
        $nilaiMentah = ($correctAnswers / $totalSoal) * 100;
        
        return round($nilaiMentah, 2);
    }
    
    public function countAnsweredQuestions($id_peserta, $id_set_soal)
    {
        return $this->where('id_peserta', $id_peserta)
                    ->where('id_set_soal', $id_set_soal)
                    ->countAllResults();
    }
} 