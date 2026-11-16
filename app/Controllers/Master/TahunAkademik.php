<?php

namespace App\Controllers\Master;

use App\Models\TahunAkademikModel;

class TahunAkademik extends CrudController
{
    protected string $modelClass = TahunAkademikModel::class;
    protected string $judul      = 'Data Tahun Akademik';
    protected string $segmen     = 'tahun-akademik';

    protected function kolom(): array
    {
        return [
            'id_tahun_akademik' => 'Kode Tahun Akademik',
            'nama_tahun'        => 'Nama Tahun',
            'keterangan'        => 'Keterangan',
            'aktif'             => 'Aktif',
        ];
    }

    protected function field(): array
    {
        return [
            ['name' => 'id_tahun_akademik', 'label' => 'Kode Tahun Akademik', 'type' => 'number', 'rules' => 'required|is_natural_no_zero',
                'help' => 'Format: tahun + semester, contoh 20231 (Ganjil 2023/2024) atau 20232 (Genap).'],
            ['name' => 'nama_tahun', 'label' => 'Nama Tahun', 'rules' => 'required|max_length[255]', 'placeholder' => 'Semester Ganjil 2023/2024'],
            ['name' => 'keterangan', 'label' => 'Keterangan', 'placeholder' => '2023/2024'],
            ['name' => 'aktif', 'label' => 'Aktif', 'type' => 'radio', 'options' => ['Ya' => 'Ya', 'Tidak' => 'Tidak']],
        ];
    }

    /** Hanya satu tahun akademik yang boleh aktif. */
    protected function setelahSimpan(array $data, string $id): void
    {
        if (($data['aktif'] ?? '') === 'Ya') {
            $this->model()->where('id_tahun_akademik !=', $id)->set('aktif', 'Tidak')->update();
        }
    }
}
