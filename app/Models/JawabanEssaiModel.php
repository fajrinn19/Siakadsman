<?php

namespace App\Models;

use CodeIgniter\Model;

class JawabanEssaiModel extends Model
{
    protected $table            = 'rb_jawaban_essai';
    protected $primaryKey       = 'id_jawaban_essai';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nisn',
        'id_pertanyaan_essai',
        'jawaban_essai',
        'waktu_tugas',
    ];
}
