<?php

namespace App\Controllers\Master;

use App\Models\JurusanModel;

class Jurusan extends CrudController
{
    protected string $modelClass = JurusanModel::class;
    protected string $judul      = 'Data Jurusan';
    protected string $segmen     = 'jurusan';
    protected bool $adaDetail    = true;

    protected function kolom(): array
    {
        return [
            'kode_jurusan'      => 'Kode Jurusan',
            'nama_jurusan'      => 'Nama Jurusan',
            'bidang_keahlian'   => 'Bidang Keahlian',
            'kompetensi_umum'   => 'Kompetensi Umum',
            'kompetensi_khusus' => 'Kompetensi Khusus',
        ];
    }

    protected function field(): array
    {
        return [
            ['name' => 'kode_jurusan', 'label' => 'Kode Jurusan', 'rules' => 'required|max_length[10]'],
            ['name' => 'nama_jurusan', 'label' => 'Nama Jurusan', 'rules' => 'required|max_length[255]'],
            ['name' => 'nama_jurusan_en', 'label' => 'Nama Jurusan (English)'],
            ['name' => 'bidang_keahlian', 'label' => 'Bidang Keahlian'],
            ['name' => 'kompetensi_umum', 'label' => 'Kompetensi Umum'],
            ['name' => 'kompetensi_khusus', 'label' => 'Kompetensi Khusus'],
            ['name' => 'pejabat', 'label' => 'Pejabat'],
            ['name' => 'jabatan', 'label' => 'Jabatan'],
            ['name' => 'keterangan', 'label' => 'Keterangan'],
            ['name' => 'aktif', 'label' => 'Aktif', 'type' => 'radio', 'options' => ['Ya' => 'Ya', 'Tidak' => 'Tidak']],
        ];
    }
}
