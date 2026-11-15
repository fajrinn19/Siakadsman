<?php

namespace App\Controllers\Master;

use App\Models\GedungModel;

class Gedung extends CrudController
{
    protected string $modelClass = GedungModel::class;
    protected string $judul      = 'Data Gedung';
    protected string $segmen     = 'gedung';

    protected function kolom(): array
    {
        return [
            'kode_gedung'   => 'Kode Gedung',
            'nama_gedung'   => 'Nama Gedung',
            'jumlah_lantai' => ['label' => 'Jumlah Lantai', 'format' => static fn ($r) => esc($r['jumlah_lantai']) . ' Lantai'],
            'panjang'       => ['label' => 'Panjang', 'format' => static fn ($r) => esc($r['panjang']) . ' m'],
            'tinggi'        => ['label' => 'Tinggi', 'format' => static fn ($r) => esc($r['tinggi']) . ' m'],
            'lebar'         => ['label' => 'Lebar', 'format' => static fn ($r) => esc($r['lebar']) . ' m'],
            'keterangan'    => 'Keterangan',
            'aktif'         => ['label' => 'Aktif', 'format' => static fn ($r) => $r['aktif'] === 'Y' ? 'Ya' : 'Tidak'],
        ];
    }

    protected function field(): array
    {
        return [
            ['name' => 'kode_gedung', 'label' => 'Kode Gedung', 'rules' => 'required|max_length[10]'],
            ['name' => 'nama_gedung', 'label' => 'Nama Gedung', 'rules' => 'required|max_length[100]'],
            ['name' => 'jumlah_lantai', 'label' => 'Jumlah Lantai'],
            ['name' => 'panjang', 'label' => 'Panjang (m)'],
            ['name' => 'tinggi', 'label' => 'Tinggi (m)'],
            ['name' => 'lebar', 'label' => 'Lebar (m)'],
            ['name' => 'keterangan', 'label' => 'Keterangan'],
            ['name' => 'aktif', 'label' => 'Aktif', 'type' => 'radio', 'options' => ['Y' => 'Ya', 'N' => 'Tidak']],
        ];
    }

    protected function sebelumHapus(string $id): ?string
    {
        return $this->db->table('rb_ruangan')->where('kode_gedung', $id)->countAllResults() > 0
            ? 'Gedung tidak dapat dihapus karena masih dipakai oleh data ruangan.' : null;
    }
}
