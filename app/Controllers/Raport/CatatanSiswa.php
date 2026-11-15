<?php

namespace App\Controllers\Raport;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Model;

/**
 * Catatan raport per siswa yang bisa lebih dari satu baris per semester
 * (ekstrakurikuler, prestasi). Turunan cukup mengisi konfigurasi.
 */
abstract class CatatanSiswa extends PerKelas
{
    protected string $modelClass;
    protected string $pk;
    protected string $segmen;
    protected string $judul;

    /** @var array<string, array{label: string, lebar?: string, tipe?: string}> kolom isian */
    protected array $kolom;

    public function index(): string
    {
        $f     = $this->filterKelas();
        $entri = [];
        if ($f['lengkap']) {
            foreach ($this->model()->where(['id_tahun_akademik' => $f['tahun'], 'kode_kelas' => $f['kelas']])->orderBy($this->pk, 'ASC')->findAll() as $r) {
                $entri[$r['nisn']][] = $r;
            }
        }
        $edit = ($id = (int) $this->request->getGet('edit')) ? $this->model()->find($id) : null;

        return view('raport/catatan', [
            'judul'  => $this->judul,
            'segmen' => $this->segmen,
            'kolom'  => $this->kolom,
            'pk'     => $this->pk,
            'entri'  => $entri,
            'edit'   => $edit,
        ] + $f);
    }

    public function simpan(): RedirectResponse
    {
        $this->wajibBolehUbah();
        $f    = $this->filterKelas();
        $nisn = (string) $this->request->getPost('nisn');
        $url  = $this->urlFilter($this->segmen, $f['tahun'], $f['kelas'], 's' . $nisn);

        if (! in_array($nisn, array_column($f['siswa'], 'nisn'), true)) {
            return $this->gagal($url, 'Siswa tidak terdaftar di kelas ini.');
        }

        $data = $this->inputPost(array_keys($this->kolom));
        if (trim((string) reset($data)) === '') {
            return $this->gagal($url, $this->kolom[array_key_first($this->kolom)]['label'] . ' wajib diisi.');
        }

        $id = (int) $this->request->getPost('id');
        if ($id > 0 && $this->model()->where(['nisn' => $nisn, 'kode_kelas' => $f['kelas']])->find($id) !== null) {
            $this->model()->update($id, $data);
        } else {
            $this->model()->insert($data + [
                'id_tahun_akademik' => $f['tahun'],
                'nisn'              => $nisn,
                'kode_kelas'        => $f['kelas'],
                'user_akses'        => (string) session('id'),
                'waktu_input'       => date('Y-m-d H:i:s'),
            ]);
        }

        return redirect()->to($url)->with('sukses', 'Data berhasil disimpan.');
    }

    public function hapus(int $id): RedirectResponse
    {
        $this->wajibBolehUbah();
        $row = $this->wajibAda($this->model()->find($id));
        $this->model()->delete($id);

        return redirect()->to($this->urlFilter($this->segmen, $row['id_tahun_akademik'], $row['kode_kelas'], 's' . $row['nisn']))->with('sukses', 'Data dihapus.');
    }

    private function model(): Model
    {
        return model($this->modelClass);
    }
}
