<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'rb_users';
    protected $primaryKey       = 'id_user';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'username',
        'password',
        'nama_lengkap',
        'email',
        'no_telpon',
        'jabatan',
        'level',
        'aktif',
    ];
}
