<?php

namespace App\Models;

use CodeIgniter\Model;

class PertanyaanEssaiModel extends Model
{
    protected $table            = 'rb_pertanyaan_essai';
    protected $primaryKey       = 'id_pertanyaan_essai';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_quiz_ujian',
        'pertanyaan_essai',
    ];
}
