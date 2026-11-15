<?php

namespace App\Controllers;

use App\Libraries\Raport;
use App\Models\NilaiSikapModel;
use App\Models\PredikatModel;
use App\Models\SiswaModel;
use CodeIgniter\HTTP\RedirectResponse;

/** Input nilai raport per jadwal: pengetahuan, keterampilan, dan sikap. */
class Nilai extends BaseController
{
    public function index(): string
    {
        return $this->halamanPilihJadwal('Input Nilai Raport Siswa', site_url('nilai'), static function ($r) {
            $k = $r['kodejdwl'];

            return '<a class="btn btn-warning btn-xs" href="' . site_url("nilai/{$k}/sikap") . '">Sikap</a> '
                . '<a class="btn btn-success btn-xs" href="' . site_url("nilai/{$k}/pengetahuan") . '">Pengetahuan</a> '
                . '<a class="btn btn-primary btn-xs" href="' . site_url("nilai/{$k}/keterampilan") . '">Keterampilan</a>';
        });
    }

    public function pengetahuan(int $kodejdwl): string
    {
        return $this->halamanKd('pengetahuan', $kodejdwl);
    }

    public function keterampilan(int $kodejdwl): string
    {
        return $this->halamanKd('keterampilan', $kodejdwl);
    }

    public function simpanPengetahuan(int $kodejdwl): RedirectResponse
    {
        return $this->simpanKd('pengetahuan', $kodejdwl);
    }

    public function simpanKeterampilan(int $kodejdwl): RedirectResponse
    {
        return $this->simpanKd('keterampilan', $kodejdwl);
    }

    public function hapusPengetahuan(int $kodejdwl, int $id): RedirectResponse
    {
        return $this->hapusKd('pengetahuan', $kodejdwl, $id);
    }

    public function hapusKeterampilan(int $kodejdwl, int $id): RedirectResponse
    {
        return $this->hapusKd('keterampilan', $kodejdwl, $id);
    }

    public function sikap(int $kodejdwl): string
    {
        $jadwal = $this->jadwal($kodejdwl);
        $nilai  = [];
        foreach (model(NilaiSikapModel::class)->where('kodejdwl', $kodejdwl)->findAll() as $n) {
            $nilai[$n['status']][$n['nisn']] = $n;
        }

        return view('nilai/sikap', [
            'judul'  => 'Input Nilai Sikap Siswa',
            'jadwal' => $jadwal,
            'siswa'  => model(SiswaModel::class)->perKelas($jadwal['kode_kelas']),
            'nilai'  => $nilai,
        ]);
    }

    public function simpanSikap(int $kodejdwl): RedirectResponse
    {
        $this->wajibBolehUbah();
        $jadwal = $this->jadwal($kodejdwl);
        $status = $this->request->getPost('status') === 'sosial' ? 'sosial' : 'spiritual';
        $siswa  = array_column(model(SiswaModel::class)->perKelas($jadwal['kode_kelas']), 'nisn', 'nisn');
        $model  = model(NilaiSikapModel::class);

        foreach ((array) $this->request->getPost('sikap') as $nisn => $isi) {
            $nisn = (string) $nisn;
            $data = [
                'positif'   => trim((string) ($isi['positif'] ?? '')),
                'negatif'   => trim((string) ($isi['negatif'] ?? '')),
                'deskripsi' => trim((string) ($isi['deskripsi'] ?? '')),
            ];
            if (! isset($siswa[$nisn]) || implode('', $data) === '') {
                continue;
            }
            $lama = $model->where(['kodejdwl' => $kodejdwl, 'nisn' => $nisn, 'status' => $status])->first();
            $lama ? $model->update($lama['id_nilai_sikap'], $data)
                  : $model->insert($data + ['kodejdwl' => $kodejdwl, 'nisn' => $nisn, 'status' => $status, 'user_akses' => (string) session('id'), 'waktu' => date('Y-m-d H:i:s')]);
        }

        return $this->kembali(site_url("nilai/{$kodejdwl}/sikap") . ($status === 'sosial' ? '#sosial' : ''), 'Nilai sikap ' . $status . ' berhasil disimpan.');
    }

    // ------------------------------------------------------------------ Bantuan

    private function halamanKd(string $jenis, int $kodejdwl): string
    {
        $jadwal = $this->jadwal($kodejdwl);
        $siswa  = model(SiswaModel::class)->perKelas($jadwal['kode_kelas']);
        $entri  = Raport::entri($jenis, $kodejdwl);
        $edit   = null;
        if ($idEdit = (int) $this->request->getGet('edit')) {
            $edit = model(Raport::JENIS[$jenis]['model'])->where('kodejdwl', $kodejdwl)->find($idEdit);
        }

        return view('nilai/kd', [
            'judul'   => 'Input Nilai ' . Raport::JENIS[$jenis]['judul'] . ' Siswa',
            'jenis'   => $jenis,
            'cfg'     => Raport::JENIS[$jenis],
            'jadwal'  => $jadwal,
            'siswa'   => $siswa,
            'entri'   => $entri,
            'edit'    => $edit,
            'grade'   => static fn ($n) => model(PredikatModel::class)->grade($n, $jadwal['kode_kelas']),
        ]);
    }

    private function simpanKd(string $jenis, int $kodejdwl): RedirectResponse
    {
        $this->wajibBolehUbah();
        $jadwal = $this->jadwal($kodejdwl);
        $cfg    = Raport::JENIS[$jenis];
        $model  = model($cfg['model']);
        $nisn   = (string) $this->request->getPost('nisn');
        $url    = site_url("nilai/{$kodejdwl}/{$jenis}") . '#s' . $nisn;

        $aturan = ['kd' => 'required|max_length[5]'];
        foreach ($cfg['kolom'] as $k) {
            $aturan[$k] = 'permit_empty|decimal|greater_than_equal_to[0]|less_than_equal_to[100]';
        }
        if (! $this->validate($aturan)) {
            return redirect()->to($url)->with('errors', $this->validator->getErrors());
        }
        if (model(SiswaModel::class)->where(['nisn' => $nisn, 'kode_kelas' => $jadwal['kode_kelas']])->countAllResults() === 0) {
            return $this->gagal($url, 'Siswa tidak terdaftar di kelas ini.');
        }

        $data = ['kd' => trim((string) $this->request->getPost('kd')), 'deskripsi' => trim((string) $this->request->getPost('deskripsi'))];
        foreach ($cfg['kolom'] as $k) {
            $data[$k] = (float) $this->request->getPost($k);
        }

        $id = (int) $this->request->getPost('id');
        if ($id > 0 && $model->where(['kodejdwl' => $kodejdwl, 'nisn' => $nisn])->find($id) !== null) {
            $model->update($id, $data);
        } else {
            $model->insert($data + ['kodejdwl' => $kodejdwl, 'nisn' => $nisn, 'user_akses' => (string) session('id'), 'waktu' => date('Y-m-d H:i:s')]);
        }

        return redirect()->to($url)->with('sukses', 'Nilai berhasil disimpan.');
    }

    private function hapusKd(string $jenis, int $kodejdwl, int $id): RedirectResponse
    {
        $this->wajibBolehUbah();
        $this->jadwal($kodejdwl);
        $model = model(Raport::JENIS[$jenis]['model']);
        $row   = $this->wajibAda($model->where('kodejdwl', $kodejdwl)->find($id));
        $model->delete($id);

        return redirect()->to(site_url("nilai/{$kodejdwl}/{$jenis}") . '#s' . $row['nisn'])->with('sukses', 'Nilai dihapus.');
    }
}
