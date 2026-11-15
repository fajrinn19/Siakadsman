<?php

namespace App\Controllers\Master;

use App\Libraries\Password;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

/**
 * Akun administrator (rb_users level superuser).
 * Kepala sekolah boleh membuka halaman ini hanya untuk mengubah akunnya sendiri.
 */
class Admin extends CrudController
{
    protected string $modelClass = UserModel::class;
    protected string $judul      = 'Data Administrator';
    protected string $segmen     = 'admin';

    public function index(): string|RedirectResponse
    {
        if (level() !== 'superuser') {
            return redirect()->to(site_url('admin/edit/' . session('id')));
        }

        return parent::index();
    }

    protected function daftar(array $filter): array
    {
        return $this->model()->where('level', 'superuser')->orderBy('id_user', 'DESC')->findAll();
    }

    protected function kolom(): array
    {
        return [
            'username'     => 'Username',
            'nama_lengkap' => 'Nama Lengkap',
            'email'        => 'Email',
            'no_telpon'    => 'No Telpon',
            'jabatan'      => 'Jabatan',
            'level'        => 'Level',
        ];
    }

    protected function field(): array
    {
        return [
            ['name' => 'username', 'label' => 'Username', 'rules' => 'required|max_length[100]'],
            ['name' => 'password', 'label' => 'Password', 'type' => 'password', 'rules' => 'required|min_length[5]'],
            ['name' => 'nama_lengkap', 'label' => 'Nama Lengkap', 'rules' => 'required|max_length[100]'],
            ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'rules' => 'permit_empty|valid_email'],
            ['name' => 'no_telpon', 'label' => 'No Telpon'],
            ['name' => 'jabatan', 'label' => 'Jabatan'],
        ];
    }

    protected function siapkan(array $data, ?array $lama): array
    {
        if (isset($data['password'])) {
            $data['password'] = Password::hash($data['password']);
        }
        if ($lama === null) {
            $data['level'] = 'superuser';
            $data['aktif'] = 'Y';
        }

        return $data;
    }

    protected function bolehTambah(): bool
    {
        return level() === 'superuser';
    }

    protected function bolehUbahBaris(array $row): bool
    {
        return level() === 'superuser' || (string) $row['id_user'] === (string) session('id');
    }

    protected function bolehHapusBaris(array $row): bool
    {
        // Jangan biarkan admin menghapus akunnya sendiri.
        return level() === 'superuser' && (string) $row['id_user'] !== (string) session('id');
    }

    protected function urlDaftar(?array $row = null): string
    {
        return level() === 'superuser' ? site_url('admin') : site_url('/');
    }
}
