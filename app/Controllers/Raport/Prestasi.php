<?php

namespace App\Controllers\Raport;

use App\Models\NilaiPrestasiModel;

class Prestasi extends CatatanSiswa
{
    protected string $modelClass = NilaiPrestasiModel::class;
    protected string $pk         = 'id_nilai_prestasi';
    protected string $segmen     = 'raport/prestasi';
    protected string $judul      = 'Input Prestasi Siswa';
    protected array $kolom       = [
        'jenis_kegiatan' => ['label' => 'Jenis Kegiatan', 'lebar' => '270px'],
        'keterangan'     => ['label' => 'Keterangan'],
    ];
}
