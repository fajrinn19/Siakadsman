<?php

namespace App\Controllers;

use App\Models\KalenderModel;
use App\Models\LogAktivitasModel;
use App\Models\PengumumanModel;

/** Halaman informasi untuk semua pengguna: pengumuman & kalender akademik, serta log aktivitas (admin). */
class Info extends BaseController
{
    public function pengumuman(): string
    {
        return view('info/pengumuman', [
            'judul' => 'Pengumuman',
            'baris' => model(PengumumanModel::class)->berlaku(level(), 100),
        ]);
    }

    public function kalender(): string
    {
        $tahun = (int) ($this->request->getGet('tahun') ?: date('Y'));
        $baris = model(KalenderModel::class)
            ->where('tanggal_selesai >=', "{$tahun}-01-01")->where('tanggal_mulai <=', "{$tahun}-12-31")
            ->orderBy('tanggal_mulai', 'ASC')->findAll();

        $perBulan = [];
        foreach ($baris as $b) {
            $perBulan[(int) substr($b['tanggal_mulai'], 5, 2)][] = $b;
        }

        return view('info/kalender', ['judul' => 'Kalender Akademik ' . $tahun, 'tahun' => $tahun, 'perBulan' => $perBulan]);
    }

    public function log(): string
    {
        $q    = trim((string) $this->request->getGet('q'));
        $tgl  = (string) $this->request->getGet('tanggal');
        $b    = model(LogAktivitasModel::class);
        if ($q !== '') {
            $b->groupStart()->like('nama', $q)->orLike('aksi', $q)->orLike('url', $q)->orLike('id_user', $q)->groupEnd();
        }
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $tgl)) {
            $b->where('waktu >=', $tgl . ' 00:00:00')->where('waktu <=', $tgl . ' 23:59:59');
        }

        return view('info/log', ['judul' => 'Log Aktivitas', 'baris' => $b->orderBy('id_log', 'DESC')->findAll(500), 'q' => $q, 'tanggal' => $tgl]);
    }
}
