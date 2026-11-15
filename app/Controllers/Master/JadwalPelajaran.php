<?php

namespace App\Controllers\Master;

use App\Models\GuruModel;
use App\Models\JadwalPelajaranModel;
use App\Models\KelasModel;
use App\Models\MataPelajaranModel;
use App\Models\RuanganModel;
use App\Models\TahunAkademikModel;

class JadwalPelajaran extends CrudController
{
    protected string $modelClass = JadwalPelajaranModel::class;
    protected string $judul      = 'Jadwal Pelajaran';
    protected string $segmen     = 'jadwal-pelajaran';
    protected bool $wajibFilter  = true;

    protected function filter(): array
    {
        return [
            'tahun' => ['label' => 'Tahun Akademik', 'options' => pilihan(model(TahunAkademikModel::class)->semua(), 'id_tahun_akademik', 'nama_tahun')],
            'kelas' => ['label' => 'Kelas', 'options' => model(KelasModel::class)->opsi(null)],
        ];
    }

    protected function daftar(array $filter): array
    {
        return model(JadwalPelajaranModel::class)->daftar([
            'kelas'     => $filter['kelas'],
            'tahun'     => $filter['tahun'],
            'kurikulum' => $this->kurikulumAktif(),
        ]);
    }

    protected function kolom(): array
    {
        return [
            'namamatapelajaran' => 'Mata Pelajaran',
            'nama_kelas'        => 'Kelas',
            'nama_guru'         => 'Guru',
            'hari'              => 'Hari',
            'jam_mulai'         => 'Mulai',
            'jam_selesai'       => 'Selesai',
            'nama_ruangan'      => 'Ruangan',
        ];
    }

    protected function aksiTambahan(array $row): string
    {
        return boleh_ubah()
            ? '<a class="btn btn-xs btn-warning" href="' . site_url('absensi-siswa/' . $row['kodejdwl']) . '">Absensi</a>'
            : '';
    }

    protected function field(): array
    {
        return [
            ['name' => 'id_tahun_akademik', 'label' => 'Tahun Akademik', 'type' => 'select', 'rules' => 'required',
                'default' => (string) $this->request->getGet('tahun'),
                'options' => static fn () => pilihan(model(TahunAkademikModel::class)->semua(), 'id_tahun_akademik', 'nama_tahun', '- Pilih Tahun Akademik -')],
            ['name' => 'kode_kelas', 'label' => 'Kelas', 'type' => 'select', 'rules' => 'required',
                'default' => (string) $this->request->getGet('kelas'),
                'options' => static fn () => model(KelasModel::class)->opsi()],
            ['name' => 'kode_pelajaran', 'label' => 'Mata Pelajaran', 'type' => 'select', 'rules' => 'required',
                'options' => fn () => pilihan(model(MataPelajaranModel::class)->where('kode_kurikulum', $this->kurikulumAktif())->orderBy('urutan')->findAll(), 'kode_pelajaran', 'namamatapelajaran', '- Pilih Mata Pelajaran -')],
            ['name' => 'kode_ruangan', 'label' => 'Ruangan', 'type' => 'select', 'rules' => 'required',
                'options' => static fn () => pilihan(
                    model(RuanganModel::class)->select('rb_ruangan.*, g.nama_gedung')->join('rb_gedung g', 'rb_ruangan.kode_gedung = g.kode_gedung', 'left')->findAll(),
                    'kode_ruangan',
                    static fn ($r) => trim(($r['nama_gedung'] ?? '') . ' - ' . $r['nama_ruangan'], ' -'),
                    '- Pilih Ruangan -'
                )],
            ['name' => 'nip', 'label' => 'Guru', 'type' => 'select', 'rules' => 'required', 'options' => static fn () => model(GuruModel::class)->opsi()],
            ['name' => 'paralel', 'label' => 'Jadwal Paralel'],
            ['name' => 'jadwal_serial', 'label' => 'Jadwal Serial'],
            ['name' => 'jam_mulai', 'label' => 'Jam Mulai', 'type' => 'time', 'rules' => 'required', 'default' => '07:30'],
            ['name' => 'jam_selesai', 'label' => 'Jam Selesai', 'type' => 'time', 'rules' => 'required', 'default' => '09:00'],
            ['name' => 'hari', 'label' => 'Hari', 'type' => 'select', 'rules' => 'required',
                'options' => ['' => '- Pilih Hari -'] + array_combine(daftar_hari(), daftar_hari())],
            ['name' => 'aktif', 'label' => 'Aktif', 'type' => 'radio', 'options' => ['Ya' => 'Ya', 'Tidak' => 'Tidak']],
        ];
    }

    /** Setelah simpan/hapus, kembali ke daftar dengan filter kelas & tahun jadwal tersebut. */
    protected function urlDaftar(?array $row = null): string
    {
        $tahun = $row['id_tahun_akademik'] ?? $this->request->getGet('tahun');
        $kelas = $row['kode_kelas'] ?? $this->request->getGet('kelas');

        return site_url($this->segmen) . ($tahun && $kelas ? '?' . http_build_query(['tahun' => $tahun, 'kelas' => $kelas]) : '');
    }
}
