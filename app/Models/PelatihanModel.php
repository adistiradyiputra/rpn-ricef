<?php

namespace App\Models;

use CodeIgniter\Model;

class PelatihanModel extends Model
{
    protected $table = 'pelatihan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['puslit', 'nama_pelatihan'];
}
