<?php

namespace App\Controllers;

use App\Models\AbsensiGuruModel;
use App\Models\JadwalPelajaranModel;
use App\Models\KehadiranModel;
use App\Models\KelasModel;
use App\Models\TahunAkademikModel;
use CodeIgniter\HTTP\RedirectResponse;

/** Admin mencatat kehadiran guru per jadwal mengajar pada tanggal tertentu. */
class AbsensiGuru extends BaseController
{
    public function index(): string
    {
        $tahun   = (string) $this->request->getGet('tahun');
        $kelas   = (string) $this->request->getGet('kelas');
        $tanggal = $this->tanggal((string) $this->request->getGet('tanggal'));
        $lengkap = $tahun !== '' && $kelas !== '';
        $jadwal  = $lengkap ? model(JadwalPelajaranModel::class)->daftar(['tahun' => $tahun, 'kelas' => $kelas, 'kurikulum' => $this->kurikulumAktif()]) : [];
        $absen   = [];

        if ($jadwal !== []) {
            $absen = array_column(
                model(AbsensiGuruModel::class)->whereIn('kodejdwl', array_column($jadwal, 'kodejdwl'))->where('tanggal', $tanggal)->findAll(),
                'kode_kehadiran',
                'kodejdwl'
            );
        }

        return view('absensi/guru', [
            'judul'     => 'Absensi Guru',
            'tahun'     => $tahun,
            'kelas'     => $kelas,
            'tanggal'   => $tanggal,
            'lengkap'   => $lengkap,
            'jadwal'    => $jadwal,
            'absen'     => $absen,
            'tahunOpsi' => pilihan(model(TahunAkademikModel::class)->semua(), 'id_tahun_akademik', 'nama_tahun', '- Pilih Tahun Akademik -'),
            'kelasOpsi' => model(KelasModel::class)->opsi(),
            'kehadiran' => pilihan(model(KehadiranModel::class)->orderBy('kode_kehadiran')->findAll(), 'kode_kehadiran', 'nama_kehadiran', '-- Pilih --'),
        ]);
    }

    public function simpan(): RedirectResponse
    {
        $this->wajibBolehUbah();

        $tanggal = $this->tanggal((string) $this->request->getPost('tanggal'));
        $tahun   = (string) $this->request->getPost('tahun');
        $kelas   = (string) $this->request->getPost('kelas');
        $isian   = (array) $this->request->getPost('kehadiran');
        $model   = model(AbsensiGuruModel::class);
        $valid   = array_column(model(KehadiranModel::class)->findAll(), 'kode_kehadiran', 'kode_kehadiran');

        foreach ($isian as $kodejdwl => $kode) {
            $jadwal = model(JadwalPelajaranModel::class)->find((int) $kodejdwl);
            if ($jadwal === null || ! isset($valid[$kode])) {
                continue;
            }
            $lama = $model->where(['kodejdwl' => $jadwal['kodejdwl'], 'nip' => $jadwal['nip'], 'tanggal' => $tanggal])->first();
            if ($lama !== null) {
                $model->update($lama['id_absensi_guru'], ['kode_kehadiran' => $kode]);
            } else {
                $model->insert([
                    'kodejdwl'       => $jadwal['kodejdwl'],
                    'nip'            => $jadwal['nip'],
                    'kode_kehadiran' => $kode,
                    'tanggal'        => $tanggal,
                    'waktu_input'    => date('Y-m-d H:i:s'),
                ]);
            }
        }

        return $this->kembali(site_url('absensi-guru') . '?' . http_build_query(compact('tahun', 'kelas', 'tanggal')), 'Absensi guru berhasil disimpan.');
    }

    private function tanggal(string $t): string
    {
        return preg_match('/^\d{4}-\d{2}-\d{2}$/', $t) === 1 ? $t : date('Y-m-d');
    }
}
