<?php

namespace App\Controllers\Master;

/**
 * Akun login kepala sekolah (rb_users dengan level selain superuser).
 * Username kepala sekolah = NIP guru yang bersangkutan.
 */
class KepalaSekolah extends Admin
{
    protected string $judul  = 'Data Kepala Sekolah';
    protected string $segmen = 'kepala-sekolah';

    public function index(): string|\CodeIgniter\HTTP\RedirectResponse
    {
        return CrudController::index();
    }

    protected function daftar(array $filter): array
    {
        return $this->model()->where('level !=', 'superuser')->orderBy('id_user', 'DESC')->findAll();
    }

    protected function cari(string $id): ?array
    {
        return $this->model()->where('level !=', 'superuser')->find($id);
    }

    protected function kolom(): array
    {
        return ['username' => 'NIP'] + parent::kolom();
    }

    protected function aksiTambahan(array $row): string
    {
        if (model(\App\Models\GuruModel::class)->find($row['username']) === null) {
            return '';
        }

        return '<a class="btn btn-info btn-xs" title="Lihat data guru" href="' . site_url('guru/detail/' . rawurlencode($row['username'])) . '"><span class="glyphicon glyphicon-search"></span></a>';
    }

    protected function bolehTambah(): bool
    {
        return false;
    }

    protected function bolehHapusBaris(array $row): bool
    {
        return false;
    }

    protected function urlDaftar(?array $row = null): string
    {
        return site_url($this->segmen);
    }
}
