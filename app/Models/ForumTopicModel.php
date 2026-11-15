<?php

namespace App\Models;

use CodeIgniter\Model;

class ForumTopicModel extends Model
{
    protected $table            = 'rb_forum_topic';
    protected $primaryKey       = 'id_forum_topic';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'kodejdwl',
        'judul_topic',
        'isi_topic',
        'waktu',
    ];
}
