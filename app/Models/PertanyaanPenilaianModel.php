<?php

namespace App\Models;

use CodeIgniter\Model;

class PertanyaanPenilaianModel extends Model
{
    protected $table            = 'rb_pertanyaan_penilaian';
    protected $primaryKey       = 'id_pertanyaan_penilaian';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'pertanyaan',
        'status',
        'waktu_input',
    ];
}
