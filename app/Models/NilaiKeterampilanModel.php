<?php

namespace App\Models;

use CodeIgniter\Model;

class NilaiKeterampilanModel extends Model
{
    protected $table            = 'rb_nilai_keterampilan';
    protected $primaryKey       = 'id_nilai_keterampilan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'kodejdwl',
        'nisn',
        'kd',
        'nilai1',
        'nilai2',
        'nilai3',
        'nilai4',
        'nilai5',
        'nilai6',
        'deskripsi',
        'user_akses',
        'waktu',
    ];
}
