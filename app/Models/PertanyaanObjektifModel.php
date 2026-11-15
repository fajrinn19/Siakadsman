<?php

namespace App\Models;

use CodeIgniter\Model;

class PertanyaanObjektifModel extends Model
{
    protected $table            = 'rb_pertanyaan_objektif';
    protected $primaryKey       = 'id_pertanyaan_objektif';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_quiz_ujian',
        'pertanyaan_objektif',
        'jawab_a',
        'jawab_b',
        'jawab_c',
        'jawab_d',
        'jawab_e',
        'kunci_jawaban',
    ];
}
