<?php

namespace App\Controllers;

use App\Models\AbsensiSiswaModel;
use App\Models\KehadiranModel;
use App\Models\SiswaModel;
use App\Models\SmsModel;
use CodeIgniter\HTTP\RedirectResponse;
use Config\Sekolah;

class AbsensiSiswa extends BaseController
{
    public function index(): string
    {
        return $this->halamanPilihJadwal('Absensi Siswa', site_url('absensi-siswa'), static fn ($r) =>
            '<a class="btn btn-success btn-xs" href="' . site_url('absensi-siswa/' . $r['kodejdwl']) . '"><span class="glyphicon glyphicon-th"></span> Buka Absensi</a>');
    }

    public function form(int $kodejdwl): string
    {
        $jadwal  = $this->jadwal($kodejdwl);
        $tanggal = $this->tanggalDipilih();
        $absen   = array_column(
            model(AbsensiSiswaModel::class)->where(['kodejdwl' => $kodejdwl, 'tanggal' => $tanggal])->findAll(),
            'kode_kehadiran',
            'nisn'
        );

        return view('absensi/siswa_form', [
            'judul'     => 'Absensi Siswa',
            'jadwal'    => $jadwal,
            'tanggal'   => $tanggal,
            'siswa'     => model(SiswaModel::class)->perKelas($jadwal['kode_kelas']),
            'absen'     => $absen,
            'kehadiran' => pilihan(model(KehadiranModel::class)->findAll(), 'kode_kehadiran', 'nama_kehadiran', '-- Pilih --'),
        ]);
    }

    public function simpan(int $kodejdwl): RedirectResponse
    {
        $this->wajibBolehUbah();
        $jadwal  = $this->jadwal($kodejdwl);
        $tanggal = $this->tanggalDipilih((string) $this->request->getPost('tanggal'));
        $isian   = (array) $this->request->getPost('kehadiran');
        $model   = model(AbsensiSiswaModel::class);
        $valid   = array_column(model(KehadiranModel::class)->findAll(), 'nama_kehadiran', 'kode_kehadiran');
        $siswa   = array_column(model(SiswaModel::class)->perKelas($jadwal['kode_kelas']), null, 'nisn');

        $this->db->transStart();
        foreach ($isian as $nisn => $kode) {
            $nisn = (string) $nisn;
            if ($kode === '' || ! isset($valid[$kode], $siswa[$nisn])) {
                continue;
            }
            $lama = $model->where(['kodejdwl' => $kodejdwl, 'nisn' => $nisn, 'tanggal' => $tanggal])->first();
            if ($lama !== null) {
                if ($lama['kode_kehadiran'] === $kode) {
                    continue;
                }
                $model->update($lama['id_absensi_siswa'], ['kode_kehadiran' => $kode]);
            } else {
                $model->insert(['kodejdwl' => $kodejdwl, 'nisn' => $nisn, 'kode_kehadiran' => $kode, 'tanggal' => $tanggal, 'waktu_input' => date('Y-m-d H:i:s')]);
            }
            if ($kode !== 'H') {
                $this->kirimSmsOrangTua($siswa[$nisn], $valid[$kode], $tanggal);
            }
        }
        $this->db->transComplete();

        return $this->kembali(site_url("absensi-siswa/{$kodejdwl}?tanggal={$tanggal}"), 'Absensi tanggal ' . tgl_indo($tanggal) . ' berhasil disimpan.');
    }

    public function rekapPilih(): string
    {
        return $this->halamanPilihJadwal('Rekap Absensi Siswa', site_url('absensi-siswa/rekap'), static fn ($r) =>
            '<a class="btn btn-success btn-xs" href="' . site_url('absensi-siswa/rekap/' . $r['kodejdwl']) . '"><span class="glyphicon glyphicon-th"></span> Rekap</a> '
            . '<a class="btn btn-info btn-xs" href="' . site_url('absensi-siswa/rekap/' . $r['kodejdwl'] . '/bulanan') . '"><span class="glyphicon glyphicon-calendar"></span> Bulanan</a>');
    }

    /** Rekap total kehadiran per siswa untuk satu jadwal. */
    public function rekap(int $kodejdwl): string
    {
        $jadwal    = $this->jadwal($kodejdwl);
        $pertemuan = $this->db->table('rb_absensi_siswa')->select('tanggal')->distinct()->where('kodejdwl', $kodejdwl)->countAllResults();
        $hitung    = [];
        foreach ($this->db->table('rb_absensi_siswa')->select('nisn, kode_kehadiran, COUNT(*) AS total')->where('kodejdwl', $kodejdwl)
            ->groupBy('nisn, kode_kehadiran')->get()->getResultArray() as $h) {
            $hitung[$h['nisn']][$h['kode_kehadiran']] = (int) $h['total'];
        }

        return view('absensi/siswa_rekap', [
            'judul'     => 'Rekap Absensi Siswa',
            'jadwal'    => $jadwal,
            'pertemuan' => $pertemuan,
            'siswa'     => model(SiswaModel::class)->perKelas($jadwal['kode_kelas']),
            'hitung'    => $hitung,
        ]);
    }

    /** Rekap bulanan berbentuk matriks tanggal x siswa. */
    public function rekapBulanan(int $kodejdwl): string
    {
        $jadwal = $this->jadwal($kodejdwl);
        $bulan  = max(1, min(12, (int) ($this->request->getGet('bulan') ?: date('n'))));
        $tahun  = (int) ($this->request->getGet('tahun') ?: date('Y'));
        $hari   = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        $awal   = sprintf('%04d-%02d-01', $tahun, $bulan);
        $akhir  = sprintf('%04d-%02d-%02d', $tahun, $bulan, $hari);

        $absen = [];
        foreach (model(AbsensiSiswaModel::class)->where('kodejdwl', $kodejdwl)->where('tanggal >=', $awal)->where('tanggal <=', $akhir)->findAll() as $a) {
            $absen[$a['nisn']][(int) substr($a['tanggal'], 8, 2)] = $a['kode_kehadiran'];
        }

        return view('absensi/siswa_bulanan', [
            'judul'  => 'Rekap Absensi Bulanan',
            'jadwal' => $jadwal,
            'bulan'  => $bulan,
            'tahun'  => $tahun,
            'hari'   => $hari,
            'siswa'  => model(SiswaModel::class)->perKelas($jadwal['kode_kelas']),
            'absen'  => $absen,
        ]);
    }

    /** Tanggal dari input (Y-m-d), default hari ini. */
    private function tanggalDipilih(?string $input = null): string
    {
        $t = $input ?? (string) $this->request->getGet('tanggal');

        return preg_match('/^\d{4}-\d{2}-\d{2}$/', $t) === 1 && strtotime($t) !== false ? $t : date('Y-m-d');
    }

    /** Antrekan SMS pemberitahuan ke orang tua (tabel rb_sms dibaca oleh gateway SMS). */
    private function kirimSmsOrangTua(array $siswa, string $status, string $tanggal): void
    {
        if (! config(Sekolah::class)->smsAbsensi) {
            return;
        }
        $nohp = trim((string) ($siswa['no_telpon_ayah'] ?: $siswa['no_telpon_ibu']));
        if ($nohp === '') {
            return;
        }

        model(SmsModel::class)->insert([
            'nohp'  => $nohp,
            'pesan' => "Diberitahukan kepada Yth Bpk/Ibu, bahwa anak anda {$siswa['nama']}, {$siswa['nama_kelas']} pada tanggal " . tgl_view($tanggal) . " tercatat: {$status}",
        ]);
    }
}
