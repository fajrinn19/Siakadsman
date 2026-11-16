<?php

namespace App\Models;

use CodeIgniter\Model;

class OrtuModel extends Model
{
    protected $table            = 'rb_ortu';
    protected $primaryKey       = 'id_ortu';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nisn', 'username', 'password', 'nama', 'no_hp', 'aktif', 'waktu'];
}
