<?php

namespace App\Models;

use CodeIgniter\Model;

class KompetensiDasarModel extends Model
{
    protected $table            = 'rb_kompetensi_dasar';
    protected $primaryKey       = 'id_kompetensi_dasar';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'kodejdwl',
        'ranah',
        'kompetensi_dasar',
        'waktu_input',
    ];
}
