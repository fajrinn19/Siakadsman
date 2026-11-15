<?php

namespace App\Models;

use CodeIgniter\Model;

class NilaiUtsModel extends Model
{
    protected $table            = 'rb_nilai_uts';
    protected $primaryKey       = 'id_nilai_uts';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'kodejdwl',
        'nisn',
        'angka_pengetahuan',
        'deskripsi_pengetahuan',
        'angka_keterampilan',
        'deskripsi_keterampilan',
        'waktu_input_uts',
    ];
}
