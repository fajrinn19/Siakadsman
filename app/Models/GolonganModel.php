<?php

namespace App\Models;

use CodeIgniter\Model;

class GolonganModel extends Model
{
    protected $table            = 'rb_golongan';
    protected $primaryKey       = 'id_golongan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nama_golongan',
        'keterangan',
    ];
}
