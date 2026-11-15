<?php

namespace App\Models;

use CodeIgniter\Model;

class ForumKomentarModel extends Model
{
    protected $table            = 'rb_forum_komentar';
    protected $primaryKey       = 'id_forum_komentar';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_forum_topic',
        'nisn_nip',
        'isi_komentar',
        'waktu_komentar',
    ];
}
