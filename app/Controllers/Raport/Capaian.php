<?php

namespace App\Controllers\Raport;

use App\Models\NilaiSikapSemesterModel;
use CodeIgniter\HTTP\RedirectResponse;

/** Capaian hasil belajar: predikat & deskripsi sikap spiritual/sosial per semester. */
class Capaian extends PerKelas
{
    public function index(): string
    {
        $f     = $this->filterKelas();
        $nilai = $f['lengkap'] ? array_column(
            model(NilaiSikapSemesterModel::class)->where(['id_tahun_akademik' => $f['tahun'], 'kode_kelas' => $f['kelas']])->findAll(),
            null,
            'nisn'
        ) : [];

        return view('raport/capaian', ['judul' => 'Input Capaian Hasil Belajar (Sikap Semester)', 'nilai' => $nilai] + $f);
    }

    public function simpan(): RedirectResponse
    {
        $this->wajibBolehUbah();
        $f     = $this->filterKelas();
        $nisn  = array_column($f['siswa'], 'nisn', 'nisn');
        $model = model(NilaiSikapSemesterModel::class);

        foreach ((array) $this->request->getPost('capaian') as $n => $isi) {
            $data = [
                'spiritual_predikat'  => mb_substr(trim((string) ($isi['spiritual_predikat'] ?? '')), 0, 2),
                'spiritual_deskripsi' => trim((string) ($isi['spiritual_deskripsi'] ?? '')),
                'sosial_predikat'     => mb_substr(trim((string) ($isi['sosial_predikat'] ?? '')), 0, 2),
                'sosial_deskripsi'    => trim((string) ($isi['sosial_deskripsi'] ?? '')),
            ];
            if (! isset($nisn[$n]) || implode('', $data) === '') {
                continue;
            }
            $kunci = ['id_tahun_akademik' => $f['tahun'], 'nisn' => (string) $n, 'kode_kelas' => $f['kelas']];
            $lama  = $model->where($kunci)->first();
            $lama ? $model->update($lama['id_nilai_sikap_semester'], $data)
                  : $model->insert($kunci + $data + ['user_akses' => (string) session('id'), 'waktu_input' => date('Y-m-d H:i:s')]);
        }

        return $this->kembali($this->urlFilter('raport/capaian', $f['tahun'], $f['kelas']), 'Capaian hasil belajar berhasil disimpan.');
    }
}
