<?php

namespace App\Controllers\Raport;

use App\Models\NilaiExtrakulikulerModel;

class Ekstrakurikuler extends CatatanSiswa
{
    protected string $modelClass = NilaiExtrakulikulerModel::class;
    protected string $pk         = 'id_nilai_extrakulikuler';
    protected string $segmen     = 'raport/ekstrakurikuler';
    protected string $judul      = 'Input Ekstrakurikuler Siswa';
    protected array $kolom       = [
        'kegiatan'  => ['label' => 'Kegiatan Ekstrakurikuler', 'lebar' => '240px'],
        'nilai'     => ['label' => 'Nilai', 'lebar' => '80px', 'tipe' => 'number'],
        'deskripsi' => ['label' => 'Deskripsi'],
    ];
}
