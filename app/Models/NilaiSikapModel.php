<?php

namespace App\Models;

use CodeIgniter\Model;

class NilaiSikapModel extends Model
{
    protected $table            = 'rb_nilai_sikap';
    protected $primaryKey       = 'id_nilai_sikap';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'kodejdwl',
        'nisn',
        'positif',
        'negatif',
        'deskripsi',
        'status',
        'user_akses',
        'waktu',
    ];
}
