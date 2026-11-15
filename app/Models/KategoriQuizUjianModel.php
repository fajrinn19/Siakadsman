<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriQuizUjianModel extends Model
{
    protected $table            = 'rb_kategori_quiz_ujian';
    protected $primaryKey       = 'id_kategori_quiz_ujian';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'kategori_quiz_ujian',
    ];
}
