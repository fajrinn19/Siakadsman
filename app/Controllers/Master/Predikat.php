<?php

namespace App\Controllers\Master;

use App\Models\KelasModel;
use App\Models\PredikatModel;

class Predikat extends CrudController
{
    protected string $modelClass = PredikatModel::class;
    protected string $judul      = 'Data Predikat / Rentang Nilai';
    protected string $segmen     = 'predikat';

    protected function kolom(): array
    {
        return [
            'kode_kelas' => ['label' => 'Berlaku Untuk', 'format' => static fn ($r) => $r['kode_kelas'] === '0' ? 'Semua kelas (umum)' : esc($r['kode_kelas'])],
            'nilai_a'    => 'Dari',
            'nilai_b'    => 'Sampai',
            'grade'      => 'Grade',
            'keterangan' => 'Keterangan',
        ];
    }

    protected function field(): array
    {
        return [
            ['name' => 'kode_kelas', 'label' => 'Berlaku Untuk', 'type' => 'select',
                'options' => static fn () => ['0' => 'Semua kelas (umum)'] + model(KelasModel::class)->opsi(''),
                'help' => 'Jika sebuah kelas punya rentang sendiri, rentang umum tidak dipakai untuk kelas itu.'],
            ['name' => 'nilai_a', 'label' => 'Nilai Dari', 'type' => 'number', 'rules' => 'required|is_natural|less_than_equal_to[100]'],
            ['name' => 'nilai_b', 'label' => 'Nilai Sampai', 'type' => 'number', 'rules' => 'required|is_natural|less_than_equal_to[100]'],
            ['name' => 'grade', 'label' => 'Grade', 'rules' => 'required|max_length[5]'],
            ['name' => 'keterangan', 'label' => 'Keterangan', 'placeholder' => 'Sangat Baik'],
        ];
    }

    protected function siapkan(array $data, ?array $lama): array
    {
        $data['kode_kelas'] = $data['kode_kelas'] === '' ? '0' : $data['kode_kelas'];

        return $data;
    }
}
