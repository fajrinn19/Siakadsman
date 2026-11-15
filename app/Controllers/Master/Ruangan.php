<?php

namespace App\Controllers\Master;

use App\Models\GedungModel;
use App\Models\RuanganModel;

class Ruangan extends CrudController
{
    protected string $modelClass = RuanganModel::class;
    protected string $judul      = 'Data Ruangan';
    protected string $segmen     = 'ruangan';

    protected function daftar(array $filter): array
    {
        return $this->model()->select('rb_ruangan.*, g.nama_gedung')
            ->join('rb_gedung g', 'rb_ruangan.kode_gedung = g.kode_gedung', 'left')
            ->orderBy('rb_ruangan.kode_ruangan', 'DESC')->findAll();
    }

    protected function kolom(): array
    {
        return [
            'kode_ruangan'      => 'Kode Ruangan',
            'nama_gedung'       => 'Nama Gedung',
            'nama_ruangan'      => 'Nama Ruangan',
            'kapasitas_belajar' => ['label' => 'Kapasitas Belajar', 'format' => static fn ($r) => (int) $r['kapasitas_belajar'] . ' Orang'],
            'kapasitas_ujian'   => ['label' => 'Kapasitas Ujian', 'format' => static fn ($r) => (int) $r['kapasitas_ujian'] . ' Orang'],
        ];
    }

    protected function field(): array
    {
        return [
            ['name' => 'kode_ruangan', 'label' => 'Kode Ruangan', 'rules' => 'required|max_length[10]'],
            ['name' => 'kode_gedung', 'label' => 'Gedung', 'type' => 'select', 'rules' => 'required',
                'options' => static fn () => pilihan(model(GedungModel::class)->findAll(), 'kode_gedung', 'nama_gedung', '- Pilih Gedung -')],
            ['name' => 'nama_ruangan', 'label' => 'Nama Ruangan', 'rules' => 'required|max_length[100]'],
            ['name' => 'kapasitas_belajar', 'label' => 'Kapasitas Belajar', 'type' => 'number', 'rules' => 'permit_empty|is_natural'],
            ['name' => 'kapasitas_ujian', 'label' => 'Kapasitas Ujian', 'type' => 'number', 'rules' => 'permit_empty|is_natural'],
            ['name' => 'keterangan', 'label' => 'Keterangan'],
            ['name' => 'aktif', 'label' => 'Aktif', 'type' => 'radio', 'options' => ['Ya' => 'Ya', 'Tidak' => 'Tidak']],
        ];
    }

    protected function siapkan(array $data, ?array $lama): array
    {
        $data['kapasitas_belajar'] = (int) $data['kapasitas_belajar'];
        $data['kapasitas_ujian']   = (int) $data['kapasitas_ujian'];

        return $data;
    }
}
