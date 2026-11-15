<?php

namespace App\Models;

use CodeIgniter\Model;

class ElearningJawabModel extends Model
{
    protected $table            = 'rb_elearning_jawab';
    protected $primaryKey       = 'id_elearning_jawab';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_elearning',
        'nisn',
        'keterangan',
        'file_tugas',
        'waktu',
    ];
}
