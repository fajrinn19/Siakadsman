<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Model;

/**
 * Controller CRUD generik untuk data master.
 *
 * Turunan cukup mengisi properti dan mendefinisikan kolom() serta field().
 *
 * Format kolom():  ['nama_field' => 'Label']  atau
 *                  ['nama_field' => ['label' => 'Label', 'format' => fn (array $row) => '...html...']]
 *
 * Format field():  [['name' => 'kolom', 'label' => 'Label', 'type' => 'text|textarea|number|time|date|password|radio|select',
 *                    'options' => [...], 'rules' => 'required', 'default' => '', 'placeholder' => '', 'help' => '']]
 */
abstract class CrudController extends BaseController
{
    /** Kelas model, contoh GedungModel::class. */
    protected string $modelClass;

    /** Judul halaman, contoh 'Data Gedung'. */
    protected string $judul;

    /** Segmen URL, contoh 'gedung'. */
    protected string $segmen;

    /** Tampilkan tombol detail di daftar. */
    protected bool $adaDetail = false;

    /** Daftar baru ditampilkan setelah semua filter diisi. */
    protected bool $wajibFilter = false;

    protected Model $model;

    /** @return array<string, string|array{label: string, format?: callable}> */
    abstract protected function kolom(): array;

    /** @return list<array<string, mixed>> */
    abstract protected function field(): array;

    protected function model(): Model
    {
        return $this->model ??= model($this->modelClass);
    }

    /**
     * Query daftar data. Override untuk join / filter.
     *
     * @param array<string, string> $filter
     *
     * @return list<array<string, mixed>>
     */
    protected function daftar(array $filter): array
    {
        return $this->model()->orderBy($this->model()->primaryKey, 'DESC')->findAll();
    }

    /**
     * Definisi filter GET di atas tabel: ['nama' => ['label' => '...', 'options' => [...]]].
     *
     * @return array<string, array{label: string, options: array<string, string>}>
     */
    protected function filter(): array
    {
        return [];
    }

    /** HTML tombol tambahan per baris (selain detail/edit/hapus). */
    protected function aksiTambahan(array $row): string
    {
        return '';
    }

    /** Kembalikan pesan untuk membatalkan penghapusan, atau null jika boleh. */
    protected function sebelumHapus(string $id): ?string
    {
        return null;
    }

    /**
     * Ubah data sebelum disimpan (mis. hash password, nilai tetap).
     *
     * @param array<string, mixed>      $data
     * @param array<string, mixed>|null $lama data sebelum diubah, null saat tambah
     *
     * @return array<string, mixed>
     */
    protected function siapkan(array $data, ?array $lama): array
    {
        return $data;
    }

    /**
     * Baris detail: ['Label' => 'nilai'].
     *
     * @return array<string, string>
     */
    protected function barisDetail(array $row): array
    {
        $baris = [];
        foreach ($this->field() as $f) {
            if (($f['type'] ?? 'text') !== 'password') {
                $baris[$f['label']] = $this->labelNilai($f, $row[$f['name']] ?? '');
            }
        }

        return $baris;
    }

    /**
     * Validasi tambahan di luar aturan field (mis. jadwal bentrok). Kembalikan pesan error atau null.
     *
     * @param array<string, mixed>      $data
     * @param array<string, mixed>|null $lama
     */
    protected function validasiTambahan(array $data, ?array $lama): ?string
    {
        return null;
    }

    /**
     * Dipanggil setelah data tersimpan (mis. menonaktifkan baris lain).
     *
     * @param array<string, mixed> $data
     */
    protected function setelahSimpan(array $data, string $id): void
    {
    }

    protected function bolehTambah(): bool
    {
        return boleh_ubah();
    }

    protected function bolehUbahBaris(array $row): bool
    {
        return boleh_ubah();
    }

    protected function bolehHapusBaris(array $row): bool
    {
        return boleh_ubah();
    }

    /** URL daftar setelah simpan/hapus; $row berisi data baris (berguna untuk mempertahankan filter). */
    protected function urlDaftar(?array $row = null): string
    {
        return site_url($this->segmen);
    }

    // ------------------------------------------------------------------ Aksi

    public function index(): string|RedirectResponse
    {
        $filter = [];
        foreach (array_keys($this->filter()) as $nama) {
            $filter[$nama] = (string) $this->request->getGet($nama);
        }
        $lengkap = ! $this->wajibFilter || ! in_array('', $filter, true);

        return view('crud/index', [
            'judul'   => $this->judul,
            'segmen'  => $this->segmen,
            'kolom'   => $this->kolom(),
            'baris'   => $lengkap ? $this->daftar($filter) : [],
            'lengkap' => $lengkap,
            'filter'  => $this->filter(),
            'nilaiFilter' => $filter,
            'pk'      => $this->model()->primaryKey,
            'ctrl'    => $this,
        ]);
    }

    public function tambah(): string
    {
        $this->wajibBoleh($this->bolehTambah());

        return $this->form(null);
    }

    public function simpan(): RedirectResponse
    {
        $this->wajibBoleh($this->bolehTambah());

        $data = $this->ambilInput(null);
        if ($data === null) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        if (($pesan = $this->validasiTambahan($data, null)) !== null) {
            return redirect()->back()->withInput()->with('error', $pesan);
        }

        $siap = $this->siapkan($data, null);
        $this->model()->insert($siap);
        $this->setelahSimpan($siap, (string) ($siap[$this->model()->primaryKey] ?? $this->model()->getInsertID()));

        return $this->kembali($this->urlDaftar($data), 'Data berhasil ditambahkan.');
    }

    public function detail(string $id): string
    {
        $row = $this->wajibAda($this->cari($id));

        return view('crud/detail', [
            'judul'  => 'Detail ' . $this->judul,
            'baris'  => $this->barisDetail($row),
            'segmen' => $this->segmen,
            'id'     => $id,
            'bolehUbah' => $this->bolehUbahBaris($row),
        ]);
    }

    public function edit(string $id): string
    {
        $row = $this->wajibAda($this->cari($id));
        $this->wajibBoleh($this->bolehUbahBaris($row));

        return $this->form($row);
    }

    public function update(string $id): RedirectResponse
    {
        $lama = $this->wajibAda($this->cari($id));
        $this->wajibBoleh($this->bolehUbahBaris($lama));

        $data = $this->ambilInput($lama);
        if ($data === null) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        if (($pesan = $this->validasiTambahan($data, $lama)) !== null) {
            return redirect()->back()->withInput()->with('error', $pesan);
        }

        $siap = $this->siapkan($data, $lama);
        $this->model()->update($id, $siap);
        $this->setelahSimpan($siap, (string) ($siap[$this->model()->primaryKey] ?? $id));

        return $this->kembali($this->urlDaftar($data + $lama), 'Data berhasil diperbarui.');
    }

    public function hapus(string $id): RedirectResponse
    {
        $row = $this->wajibAda($this->cari($id));
        $this->wajibBoleh($this->bolehHapusBaris($row));

        if (($alasan = $this->sebelumHapus($id)) !== null) {
            return $this->gagal($this->urlDaftar($row), $alasan);
        }

        $this->model()->delete($id);

        return $this->kembali($this->urlDaftar($row), 'Data berhasil dihapus.');
    }

    // ------------------------------------------------------------------ Bantuan untuk view

    /** Render isi satu sel tabel daftar (sudah di-escape kecuali format kustom). */
    public function sel(string $kunci, array|string $def, array $row): string
    {
        if (is_array($def) && isset($def['format'])) {
            return (string) $def['format']($row);
        }

        return esc((string) ($row[$kunci] ?? ''));
    }

    /** Render tombol aksi per baris. */
    public function aksi(array $row): string
    {
        $id = rawurlencode((string) $row[$this->model()->primaryKey]);
        if ($id === '') {
            // Data lama dengan kunci kosong tidak bisa dibuka/diubah lewat URL.
            return '<span class="text-muted" title="Kode kosong, perbaiki langsung di database">-</span>';
        }
        $html = $this->aksiTambahan($row);

        if ($this->adaDetail) {
            $html .= ' <a class="btn btn-primary btn-xs" title="Detail" href="' . site_url("{$this->segmen}/detail/{$id}") . '"><span class="glyphicon glyphicon-search"></span></a>';
        }
        if ($this->bolehUbahBaris($row)) {
            $html .= ' <a class="btn btn-success btn-xs" title="Edit" href="' . site_url("{$this->segmen}/edit/{$id}") . '"><span class="glyphicon glyphicon-edit"></span></a>';
        }
        if ($this->bolehHapusBaris($row)) {
            $html .= ' ' . tombol_hapus(site_url("{$this->segmen}/hapus/{$id}"));
        }

        return $html;
    }

    public function bisaTambah(): bool
    {
        return $this->bolehTambah();
    }

    // ------------------------------------------------------------------ Internal

    protected function cari(string $id): ?array
    {
        return $this->model()->find($id);
    }

    /** @param array<string, mixed>|null $row */
    protected function form(?array $row): string
    {
        $id = $row !== null ? rawurlencode((string) $row[$this->model()->primaryKey]) : null;

        return view('crud/form', [
            'judul'  => ($row === null ? 'Tambah ' : 'Edit ') . $this->judul,
            'field'  => array_map(fn ($f) => ['options' => $this->opsiField($f)] + $f, $this->field()),
            'row'    => $row ?? [],
            'action' => $row === null ? site_url("{$this->segmen}/tambah") : site_url("{$this->segmen}/edit/{$id}"),
            'batal'  => $this->urlDaftar($row),
            'baru'   => $row === null,
        ]);
    }

    /**
     * Validasi & ambil input sesuai field(). Password kosong saat edit = tidak diganti.
     *
     * @return array<string, mixed>|null
     */
    protected function ambilInput(?array $lama): ?array
    {
        $rules = [];
        $data  = [];
        foreach ($this->field() as $f) {
            $tipe = $f['type'] ?? 'text';
            if ($tipe === 'static') {
                continue;
            }
            $nilai = $this->request->getPost($f['name']);
            $nilai = is_string($nilai) ? trim($nilai) : ($nilai ?? '');

            if ($tipe === 'password' && $nilai === '' && $lama !== null) {
                continue;
            }
            if (! empty($f['rules'])) {
                $rules[$f['name']] = ['label' => $f['label'], 'rules' => $f['rules']];
            }
            $data[$f['name']] = $nilai;
        }

        if ($rules !== [] && ! $this->validate($rules)) {
            return null;
        }

        return $data;
    }

    protected function labelNilai(array $f, mixed $nilai): string
    {
        if (in_array($f['type'] ?? 'text', ['select', 'radio'], true)) {
            $opsi = $this->opsiField($f);

            return (string) ($opsi[(string) $nilai] ?? $nilai);
        }

        return (string) $nilai;
    }

    /** @return array<string, string> */
    public function opsiField(array $f): array
    {
        $opsi = $f['options'] ?? [];

        return $opsi instanceof \Closure ? $opsi() : $opsi;
    }

    private function wajibBoleh(bool $boleh): void
    {
        if (! $boleh) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Akses ditolak.');
        }
    }
}
