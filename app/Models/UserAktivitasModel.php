<?php

namespace App\Models;

use CodeIgniter\Model;

class UserAktivitasModel extends Model
{
    protected $table            = 'rb_users_aktivitas';
    protected $primaryKey       = 'id_users_aktivitas';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'identitas',
        'ip_address',
        'browser',
        'os',
        'status',
        'jam',
        'tanggal',
    ];
}
