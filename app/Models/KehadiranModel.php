<?php

namespace App\Models;

use CodeIgniter\Model;

class KehadiranModel extends Model
{
    protected $table            = 'rb_kehadiran';
    protected $primaryKey       = 'kode_kehadiran';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'kode_kehadiran',
        'nama_kehadiran',
        'nilai',
        'bobot',
    ];
}
