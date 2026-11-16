<?php

namespace App\Controllers;

use App\Libraries\Password;
use CodeIgniter\HTTP\RedirectResponse;

/** Ganti password untuk semua jenis pengguna. */
class Akun extends BaseController
{
    /** Tabel & kolom kunci akun per level. */
    private const AKUN = [
        'superuser' => ['rb_users', 'id_user'],
        'kepala'    => ['rb_users', 'id_user'],
        'guru'      => ['rb_guru', 'nip'],
        'siswa'     => ['rb_siswa', 'nisn'],
        'ortu'      => ['rb_ortu', 'id_ortu'],
    ];

    public function password(): string
    {
        return view('akun/password', [
            'judul' => 'Ganti Password',
            'wajib' => (bool) session('wajib_ganti_password'),
        ]);
    }

    public function simpanPassword(): RedirectResponse
    {
        [$tabel, $kunci] = self::AKUN[level()] ?? [null, null];
        if ($tabel === null) {
            return redirect()->to(site_url('/'));
        }

        $aturan = [
            'password_lama' => 'required',
            'password_baru' => 'required|min_length[6]|max_length[72]',
            'konfirmasi'    => 'required|matches[password_baru]',
        ];
        if (! $this->validate($aturan, ['konfirmasi' => ['matches' => 'Konfirmasi password tidak sama.']])) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $akun = $this->db->table($tabel)->where($kunci, session('id'))->get()->getRowArray();
        $lama = (string) $this->request->getPost('password_lama');
        $baru = (string) $this->request->getPost('password_baru');

        if ($akun === null || ! Password::cocok($lama, $akun['password'], $tabel === 'rb_users')) {
            return redirect()->back()->with('error', 'Password lama salah.');
        }
        if (strcasecmp($baru, (string) session('username')) === 0 || $baru === $lama) {
            return redirect()->back()->with('error', 'Password baru tidak boleh sama dengan username/NIP/NISN atau password lama.');
        }

        $this->db->table($tabel)->where($kunci, session('id'))->update(['password' => Password::hash($baru)]);
        session()->remove('wajib_ganti_password');

        return $this->kembali(site_url('/'), 'Password berhasil diganti.');
    }
}
