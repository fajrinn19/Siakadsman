<?php

namespace App\Models;

use CodeIgniter\Model;

class KelompokMataPelajaranModel extends Model
{
    protected $table            = 'rb_kelompok_mata_pelajaran';
    protected $primaryKey       = 'id_kelompok_mata_pelajaran';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'jenis_kelompok_mata_pelajaran',
        'nama_kelompok_mata_pelajaran',
    ];
}
