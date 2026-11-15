<?php

namespace App\Models;

use CodeIgniter\Model;

class JawabanObjektifModel extends Model
{
    protected $table            = 'rb_jawaban_objektif';
    protected $primaryKey       = 'id_jawaban_objektif';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nisn',
        'id_pertanyaan_objektif',
        'jawaban',
        'waktu_objektif',
    ];
}
