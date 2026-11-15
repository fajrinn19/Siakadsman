<?php

namespace App\Models;

use CodeIgniter\Model;

class NilaiPertanyaanEssaiModel extends Model
{
    protected $table            = 'rb_nilai_pertanyaan_essai';
    protected $primaryKey       = 'id_nilai_pertanyaan_essai';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_quiz_ujian',
        'nisn',
        'nilai_essai',
    ];
}
