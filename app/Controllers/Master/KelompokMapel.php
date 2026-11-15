<?php

namespace App\Controllers\Master;

use App\Models\KelompokMataPelajaranModel;

class KelompokMapel extends CrudController
{
    protected string $modelClass = KelompokMataPelajaranModel::class;
    protected string $judul      = 'Data Kelompok Mata Pelajaran';
    protected string $segmen     = 'kelompok-mapel';

    protected function kolom(): array
    {
        return [
            'jenis_kelompok_mata_pelajaran' => 'Jenis',
            'nama_kelompok_mata_pelajaran'  => 'Nama Kelompok',
        ];
    }

    protected function field(): array
    {
        return [
            ['name' => 'jenis_kelompok_mata_pelajaran', 'label' => 'Jenis', 'rules' => 'required|max_length[50]'],
            ['name' => 'nama_kelompok_mata_pelajaran', 'label' => 'Nama Kelompok', 'rules' => 'required|max_length[255]'],
        ];
    }
}
