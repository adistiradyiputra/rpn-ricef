<?php
namespace App\Models;

use CodeIgniter\Model;

class OrganizationModel extends Model
{
    protected $table = 'organisasi';
    protected $primaryKey = 'id';
    protected $allowedFields = ['parent_id', 'name', 'position', 'photo', 'created_at', 'updated_at'];
    protected $useTimestamps = true; // Enable auto-timestamp for created_at and updated_at

    // Tambahkan metode khusus jika diperlukan, misalnya mengambil seluruh data dalam format tree
    public function getAllNodes()
    {
        return $this->orderBy('parent_id', 'ASC')->findAll();
    }
}