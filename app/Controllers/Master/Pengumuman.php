<?php

namespace App\Controllers\Master;

use App\Models\PengumumanModel;

class Pengumuman extends CrudController
{
    protected string $modelClass = PengumumanModel::class;
    protected string $judul      = 'Pengumuman';
    protected string $segmen     = 'pengumuman';
    protected bool $adaDetail    = true;

    private const UNTUK = ['semua' => 'Semua pengguna', 'guru' => 'Guru', 'siswa' => 'Siswa', 'ortu' => 'Orang tua'];

    protected function kolom(): array
    {
        return [
            'judul'           => 'Judul',
            'untuk'           => ['label' => 'Untuk', 'format' => static fn ($r) => esc(self::UNTUK[$r['untuk']] ?? $r['untuk'])],
            'tanggal_mulai'   => ['label' => 'Tampil', 'format' => static fn ($r) => tgl_indo($r['tanggal_mulai']) . ' s/d ' . tgl_indo($r['tanggal_selesai'])],
            'status'          => ['label' => 'Status', 'format' => static fn ($r) => $r['tanggal_selesai'] < date('Y-m-d')
                ? '<span class="chip chip-redup">Berakhir</span>' : ($r['tanggal_mulai'] > date('Y-m-d') ? '<span class="chip chip-tunggu">Terjadwal</span>' : '<span class="chip chip-aktif">Tayang</span>')],
        ];
    }

    protected function field(): array
    {
        return [
            ['name' => 'judul', 'label' => 'Judul', 'rules' => 'required|max_length[200]'],
            ['name' => 'isi', 'label' => 'Isi Pengumuman', 'type' => 'textarea', 'rows' => 6, 'rules' => 'required'],
            ['name' => 'untuk', 'label' => 'Ditujukan Untuk', 'type' => 'select', 'options' => self::UNTUK],
            ['name' => 'tanggal_mulai', 'label' => 'Tampil Mulai', 'type' => 'date', 'rules' => 'required|valid_date[Y-m-d]', 'default' => date('Y-m-d')],
            ['name' => 'tanggal_selesai', 'label' => 'Tampil Sampai', 'type' => 'date', 'rules' => 'required|valid_date[Y-m-d]', 'default' => date('Y-m-d', strtotime('+7 days'))],
        ];
    }

    protected function validasiTambahan(array $data, ?array $lama): ?string
    {
        return $data['tanggal_selesai'] < $data['tanggal_mulai'] ? 'Tanggal selesai tidak boleh sebelum tanggal mulai.' : null;
    }

    protected function siapkan(array $data, ?array $lama): array
    {
        return $data + ['user_akses' => (string) session('id'), 'waktu' => date('Y-m-d H:i:s')];
    }
}
