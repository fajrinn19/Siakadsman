<?php

namespace App\Models;

use CodeIgniter\Model;

class NilaiPengetahuanModel extends Model
{
    protected $table            = 'rb_nilai_pengetahuan';
    protected $primaryKey       = 'id_nilai_pengetahuan';
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
        'deskripsi',
        'user_akses',
        'waktu',
    ];
}
