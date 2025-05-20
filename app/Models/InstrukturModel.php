<?php

namespace App\Models;

use CodeIgniter\Model;

class InstrukturModel extends Model
{
    protected $table = 'instruktur';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama', 'username', 'password', 'created_at', 'created_by', 'updated_at', 'updated_by'];
    
    protected $useTimestamps = false; // Kita akan mengelola timestamp secara manual
    
    /**
     * Get all instruktur with creator and updater names
     * 
     * @return array
     */
    public function getAllInstruktur()
    {
        $builder = $this->db->table($this->table);
        $builder->select($this->table.'.*');
        $builder->select('creator.username as created_by_name');
        $builder->select('updater.username as updated_by_name');
        $builder->join('users as creator', 'creator.id = '.$this->table.'.created_by', 'left');
        $builder->join('users as updater', 'updater.id = '.$this->table.'.updated_by', 'left');
        $builder->orderBy($this->table.'.id', 'DESC');
        
        return $builder->get()->getResultArray();
    }
    
    /**
     * Get instruktur by ID
     * 
     * @param int $id
     * @return array|null
     */
    public function getInstrukturById($id)
    {
        return $this->find($id);
    }
    
    /**
     * Save instruktur data
     * 
     * @param array $data
     * @return int|bool
     */
    public function saveInstruktur($data)
    {
        // Hash password jika ada
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        
        // Set timezone ke Asia/Jakarta
        date_default_timezone_set('Asia/Jakarta');
        
        // Set timestamp dan user info
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = session()->get('user_id');
        
        return $this->insert($data);
    }
    
    /**
     * Update instruktur data
     * 
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateInstruktur($id, $data)
    {
        // Hash password jika ada dan tidak kosong
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            // Jika password kosong, hapus dari array agar tidak mengupdate password
            unset($data['password']);
        }
        
        // Set timezone ke Asia/Jakarta
        date_default_timezone_set('Asia/Jakarta');
        
        // Set timestamp dan user info
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = session()->get('user_id');
        
        return $this->update($id, $data);
    }
} 