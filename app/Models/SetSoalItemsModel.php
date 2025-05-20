<?php

namespace App\Models;

use CodeIgniter\Model;

class SetSoalItemsModel extends Model
{
    protected $table = 'set_soal_items';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_set_soal', 'id_soal'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    public function getItemsBySetSoalId($id_set_soal)
    {
        return $this->where('id_set_soal', $id_set_soal)->findAll();
    }
    
    public function saveSetSoalItems($id_set_soal, $items)
    {
        try {
            // Begin transaction
            $this->db->transBegin();
            
            // Delete existing items
            $this->where('id_set_soal', $id_set_soal)->delete();
            
            // Insert new items
            foreach ($items as $item) {
                $this->insert([
                    'id_set_soal' => $id_set_soal,
                    'id_soal' => $item['id_soal'],
                ]);
            }
            
            // Commit if all successful
            if ($this->db->transStatus() === false) {
                $this->db->transRollback();
                return false;
            } else {
                $this->db->transCommit();
                return true;
            }
        } catch (\Exception $e) {
            $this->db->transRollback();
            log_message('error', 'SaveSetSoalItems error: ' . $e->getMessage());
            return false;
        }
    }
} 