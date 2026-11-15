<?php

namespace App\Controllers;

use App\Models\NilaiUtsModel;
use App\Models\PredikatModel;
use App\Models\SiswaModel;
use CodeIgniter\HTTP\RedirectResponse;

/** Input nilai UTS (angka pengetahuan & keterampilan) per jadwal. */
class NilaiUts extends BaseController
{
    public function index(): string
    {
        return $this->halamanPilihJadwal('Input Nilai UTS', site_url('nilai-uts'), static fn ($r) =>
            '<a class="btn btn-success btn-xs" href="' . site_url('nilai-uts/' . $r['kodejdwl']) . '"><span class="glyphicon glyphicon-th-list"></span> Input Nilai</a>');
    }

    public function form(int $kodejdwl): string
    {
        $jadwal = $this->jadwal($kodejdwl);

        return view('nilai/uts', [
            'judul'  => 'Input Nilai UTS Siswa',
            'jadwal' => $jadwal,
            'siswa'  => model(SiswaModel::class)->perKelas($jadwal['kode_kelas']),
            'nilai'  => array_column(model(NilaiUtsModel::class)->where('kodejdwl', $kodejdwl)->findAll(), null, 'nisn'),
            'grade'  => static fn ($n) => model(PredikatModel::class)->grade($n, $jadwal['kode_kelas']),
        ]);
    }

    public function simpan(int $kodejdwl): RedirectResponse
    {
        $this->wajibBolehUbah();
        $jadwal = $this->jadwal($kodejdwl);
        $siswa  = array_column(model(SiswaModel::class)->perKelas($jadwal['kode_kelas']), 'nisn', 'nisn');
        $model  = model(NilaiUtsModel::class);
        $angka  = static fn ($v) => $v === '' || $v === null ? null : max(0, min(100, (float) $v));

        foreach ((array) $this->request->getPost('uts') as $nisn => $isi) {
            $p = $angka($isi['pengetahuan'] ?? '');
            $k = $angka($isi['keterampilan'] ?? '');
            if (! isset($siswa[$nisn]) || ($p === null && $k === null)) {
                continue;
            }
            $data = ['angka_pengetahuan' => $p ?? 0, 'angka_keterampilan' => $k ?? 0];
            $lama = $model->where(['kodejdwl' => $kodejdwl, 'nisn' => (string) $nisn])->first();
            $lama ? $model->update($lama['id_nilai_uts'], $data)
                  : $model->insert($data + ['kodejdwl' => $kodejdwl, 'nisn' => (string) $nisn, 'deskripsi_pengetahuan' => '', 'deskripsi_keterampilan' => '', 'waktu_input_uts' => date('Y-m-d H:i:s')]);
        }

        return $this->kembali(site_url("nilai-uts/{$kodejdwl}"), 'Nilai UTS berhasil disimpan.');
    }
}
