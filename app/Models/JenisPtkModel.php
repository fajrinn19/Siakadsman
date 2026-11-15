<?php

namespace App\Models;

use CodeIgniter\Model;

class JenisPtkModel extends Model
{
    protected $table            = 'rb_jenis_ptk';
    protected $primaryKey       = 'id_jenis_ptk';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'jenis_ptk',
        'keterangan',
    ];
}
