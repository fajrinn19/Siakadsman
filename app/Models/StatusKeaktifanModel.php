<?php

namespace App\Models;

use CodeIgniter\Model;

class StatusKeaktifanModel extends Model
{
    protected $table            = 'rb_status_keaktifan';
    protected $primaryKey       = 'id_status_keaktifan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nama_status_keaktifan',
        'keterangan',
    ];
}
