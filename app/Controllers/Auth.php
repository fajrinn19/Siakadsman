<?php

namespace App\Controllers;

use App\Libraries\Password;
use App\Models\GuruModel;
use App\Models\LoginAttemptModel;
use App\Models\SiswaModel;
use App\Models\UserAktivitasModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;
use Config\Sekolah;

/**
 * Login, logout, dan captcha.
 *
 * Satu form login untuk tiga jenis akun: admin/kepala (rb_users.username),
 * guru (rb_guru.nip), dan siswa (rb_siswa.nisn).
 */
class Auth extends BaseController
{
    public function login(): string|RedirectResponse
    {
        if (session()->has('level')) {
            return redirect()->to(site_url('/'));
        }

        $cfg      = config(Sekolah::class);
        $ip       = $this->request->getIPAddress();
        $attempts = model(LoginAttemptModel::class);
        $gagal    = $attempts->jumlahGagal($ip, $cfg->lamaBlokirMenit);

        return view('auth/login', [
            'captcha'    => $this->captchaBaru(),
            'diblokir'   => $gagal >= $cfg->maksPercobaanLogin,
            'sisaDetik'  => $attempts->sisaDetikBlokir($ip, $cfg->lamaBlokirMenit),
            'sisaCoba'   => max(0, $cfg->maksPercobaanLogin - $gagal),
            'percobaan'  => $gagal,
            'sekolah'    => $cfg,
        ]);
    }

    public function attempt(): RedirectResponse
    {
        $cfg      = config(Sekolah::class);
        $ip       = $this->request->getIPAddress();
        $attempts = model(LoginAttemptModel::class);
        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        if ($attempts->jumlahGagal($ip, $cfg->lamaBlokirMenit) >= $cfg->maksPercobaanLogin) {
            return redirect()->to(site_url('login'))->with('error', 'Anda telah melebihi batas percobaan login. Silakan coba lagi nanti.');
        }

        $captcha = strtoupper(trim((string) $this->request->getPost('captcha')));
        if ($captcha === '' || ! hash_equals((string) session('captcha_code'), $captcha)) {
            return $this->loginGagal($ip, $username, 'Kode CAPTCHA salah!');
        }

        $akun = $this->cariAkun($username, $password);
        if ($akun === null) {
            return $this->loginGagal($ip, $username, 'Maaf, Username atau Password salah!');
        }

        $attempts->bersihkan($ip);
        session()->remove('captcha_code');
        session()->regenerate(true);
        session()->set($akun['sesi']);
        $this->catatAktivitas($akun['sesi']['id'], $akun['sesi']['level']);

        return redirect()->to(site_url('/'));
    }

    public function logout(): RedirectResponse
    {
        session()->destroy();

        return redirect()->to(site_url('login'))->with('sukses', 'Sukses keluar dari sistem.');
    }

    /** Dipanggil via AJAX dari halaman login untuk mengganti kode captcha. */
    public function captcha(): string
    {
        return $this->captchaBaru();
    }

    private function captchaBaru(): string
    {
        $kode = substr(strtoupper(bin2hex(random_bytes(4))), 0, 6);
        session()->set('captcha_code', $kode);

        return $kode;
    }

    private function loginGagal(string $ip, string $username, string $pesan): RedirectResponse
    {
        $cfg      = config(Sekolah::class);
        $attempts = model(LoginAttemptModel::class);
        $attempts->catat($ip, $username);
        $sisa = max(0, $cfg->maksPercobaanLogin - $attempts->jumlahGagal($ip, $cfg->lamaBlokirMenit));

        return redirect()->to(site_url('login'))->withInput()->with('error', "{$pesan} Sisa percobaan: {$sisa}");
    }

    /**
     * Cari akun yang cocok dan siapkan data sesinya. Password lama otomatis di-upgrade.
     *
     * @return array{sesi: array<string, string>}|null
     */
    private function cariAkun(string $username, string $password): ?array
    {
        if ($username === '' || $password === '') {
            return null;
        }

        $users = model(UserModel::class);
        foreach ($users->where('username', $username)->where('aktif !=', 'N')->findAll() as $u) {
            if (Password::cocok($password, $u['password'], true)) {
                if (Password::perluRehash($u['password'])) {
                    $users->update($u['id_user'], ['password' => Password::hash($password)]);
                }

                return ['sesi' => ['id' => (string) $u['id_user'], 'namalengkap' => $u['nama_lengkap'], 'level' => $u['level']]];
            }
        }

        $guruModel = model(GuruModel::class);
        $guru      = $guruModel->find($username);
        if ($guru !== null && Password::cocok($password, $guru['password'])) {
            if (Password::perluRehash($guru['password'])) {
                $guruModel->update($guru['nip'], ['password' => Password::hash($password)]);
            }

            return ['sesi' => ['id' => $guru['nip'], 'namalengkap' => $guru['nama_guru'], 'level' => 'guru']];
        }

        $siswaModel = model(SiswaModel::class);
        $siswa      = $siswaModel->cariNisn($username);
        if ($siswa !== null && Password::cocok($password, $siswa['password'])) {
            if (Password::perluRehash($siswa['password'])) {
                $siswaModel->update($siswa['id_siswa'], ['password' => Password::hash($password)]);
            }

            return ['sesi' => [
                'id'          => $siswa['nisn'],
                'namalengkap' => $siswa['nama'],
                'kode_kelas'  => $siswa['kode_kelas'],
                'angkatan'    => (string) $siswa['angkatan'],
                'level'       => 'siswa',
            ]];
        }

        return null;
    }

    private function catatAktivitas(string $id, string $level): void
    {
        $agent = $this->request->getUserAgent();

        model(UserAktivitasModel::class)->insert([
            'identitas'  => $id,
            'ip_address' => $this->request->getIPAddress(),
            'browser'    => mb_substr($agent->getBrowser() . ' ' . $agent->getVersion(), 0, 50),
            'os'         => mb_substr($agent->getPlatform(), 0, 50),
            // Kolom status hanya mengenal siswa/guru/superuser; kepala dicatat sebagai superuser.
            'status'     => in_array($level, ['siswa', 'guru'], true) ? $level : 'superuser',
            'jam'        => date('H:i:s'),
            'tanggal'    => date('Y-m-d'),
        ]);
    }
}
