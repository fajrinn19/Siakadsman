<?php

namespace App\Controllers;

use App\Models\PertanyaanPenilaianJawabModel;
use App\Models\PertanyaanPenilaianModel;
use App\Models\SiswaModel;
use CodeIgniter\HTTP\RedirectResponse;

/** Siswa mengisi penilaian diri dan penilaian terhadap teman sekelas. */
class Penilaian extends BaseController
{
    public function diri(): string
    {
        $s = $this->siswa();

        return view('penilaian/form', [
            'judul'      => 'Penilaian Diri',
            'pertanyaan' => Siswa::jawabanPenilaian('diri', $s, null),
            'action'     => site_url('penilaian/diri'),
            'teman'      => null,
        ]);
    }

    public function simpanDiri(): RedirectResponse
    {
        $this->simpan('diri', $this->siswa(), '');

        return $this->kembali(site_url('penilaian/diri'), 'Jawaban penilaian diri berhasil disimpan.');
    }

    public function teman(): string
    {
        $s = $this->siswa();

        return view('siswa/penilaian_teman', [
            'judul'       => 'Teman Sekelas Anda',
            's'           => $s,
            'teman'       => Siswa::temanSekelas($s),
            'url'         => static fn ($t) => site_url('penilaian/teman/' . rawurlencode($t['nisn'])),
            'labelTombol' => 'Isi Penilaian',
        ]);
    }

    public function temanForm(string $nisnTeman): string
    {
        $s     = $this->siswa();
        $teman = $this->teman1($s, $nisnTeman);

        return view('penilaian/form', [
            'judul'      => 'Penilaian Teman',
            'pertanyaan' => Siswa::jawabanPenilaian('teman', $s, $teman['nisn']),
            'action'     => site_url('penilaian/teman/' . rawurlencode($teman['nisn'])),
            'teman'      => $teman,
        ]);
    }

    public function simpanTeman(string $nisnTeman): RedirectResponse
    {
        $s     = $this->siswa();
        $teman = $this->teman1($s, $nisnTeman);
        $this->simpan('teman', $s, $teman['nisn']);

        return $this->kembali(site_url('penilaian/teman/' . rawurlencode($teman['nisn'])), 'Jawaban penilaian teman berhasil disimpan.');
    }

    private function siswa(): array
    {
        return $this->wajibAda(model(SiswaModel::class)->detail((string) session('id')));
    }

    /** Teman harus sekelas & seangkatan. */
    private function teman1(array $s, string $nisn): array
    {
        $teman = array_column(Siswa::temanSekelas($s), null, 'nisn');

        return $this->wajibAda($teman[$nisn] ?? null, 'Teman sekelas tidak ditemukan.');
    }

    private function simpan(string $status, array $s, string $nisnTeman): void
    {
        $valid = array_column(model(PertanyaanPenilaianModel::class)->where('status', $status)->findAll(), 'id_pertanyaan_penilaian', 'id_pertanyaan_penilaian');
        $model = model(PertanyaanPenilaianJawabModel::class);

        foreach ((array) $this->request->getPost('jawaban') as $idPertanyaan => $jawaban) {
            if (! isset($valid[$idPertanyaan])) {
                continue;
            }
            $kunci = [
                'id_pertanyaan_penilaian' => (int) $idPertanyaan,
                'nisn'                    => $s['nisn'],
                'nisn_teman'              => $nisnTeman,
                'status'                  => $status,
                'kode_kelas'              => $s['kode_kelas'],
            ];
            $lama = $model->where($kunci)->first();
            $lama ? $model->update($lama['id_pertanyaan_penilaian_jawab'], ['jawaban' => trim((string) $jawaban)])
                  : $model->insert($kunci + ['jawaban' => trim((string) $jawaban), 'waktu_jawab' => date('Y-m-d H:i:s')]);
        }
    }
}
