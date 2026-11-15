<?php

/**
 * Helper umum SIAKAD: tanggal Indonesia, sesi pengguna, dan potongan HTML kecil.
 */

if (! function_exists('nama_bulan')) {
    function nama_bulan(int $bulan, bool $singkat = false): string
    {
        $panjang = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $pendek  = [1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        return ($singkat ? $pendek : $panjang)[$bulan] ?? '';
    }
}

if (! function_exists('daftar_hari')) {
    /** @return list<string> */
    function daftar_hari(): array
    {
        return ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
    }
}

if (! function_exists('hari_ini')) {
    function hari_ini(?string $tanggal = null): string
    {
        $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        return $hari[(int) date('w', $tanggal ? strtotime($tanggal) : time())];
    }
}

if (! function_exists('tgl_valid')) {
    function tgl_valid(?string $tgl): bool
    {
        return $tgl !== null && preg_match('/^\d{4}-\d{2}-\d{2}/', $tgl) === 1 && ! str_starts_with($tgl, '0000');
    }
}

if (! function_exists('tgl_indo')) {
    /** 2024-03-05 -> 05 Mar 2024 */
    function tgl_indo(?string $tgl): string
    {
        if (! tgl_valid($tgl)) {
            return '-';
        }

        return substr($tgl, 8, 2) . ' ' . nama_bulan((int) substr($tgl, 5, 2), true) . ' ' . substr($tgl, 0, 4);
    }
}

if (! function_exists('tgl_raport')) {
    /** 2024-03-05 -> 05 Maret 2024 */
    function tgl_raport(?string $tgl): string
    {
        if (! tgl_valid($tgl)) {
            return '-';
        }

        return substr($tgl, 8, 2) . ' ' . nama_bulan((int) substr($tgl, 5, 2)) . ' ' . substr($tgl, 0, 4);
    }
}

if (! function_exists('tgl_view')) {
    /** 2024-03-05 -> 05-03-2024 */
    function tgl_view(?string $tgl): string
    {
        if (! tgl_valid($tgl)) {
            return '';
        }

        return substr($tgl, 8, 2) . '-' . substr($tgl, 5, 2) . '-' . substr($tgl, 0, 4);
    }
}

if (! function_exists('tgl_simpan')) {
    /** 05-03-2024 -> 2024-03-05 */
    function tgl_simpan(?string $tgl): string
    {
        if ($tgl === null || preg_match('/^(\d{2})-(\d{2})-(\d{4})$/', trim($tgl), $m) !== 1) {
            return date('Y-m-d');
        }

        return "{$m[3]}-{$m[2]}-{$m[1]}";
    }
}

if (! function_exists('semester_dari_tahun')) {
    /** Kode tahun akademik berakhiran 1 = Ganjil, selain itu Genap (mis. 20231, 20232). */
    function semester_dari_tahun(string $idTahun): string
    {
        return substr($idTahun, 4, 1) === '1' ? 'Ganjil' : 'Genap';
    }
}

if (! function_exists('pengguna')) {
    /**
     * Data pengguna yang sedang login (dari sesi).
     *
     * @return array{id: string, level: string, nama: string, kode_kelas: string, angkatan: string}|null
     */
    function pengguna(): ?array
    {
        $session = session();
        if (! $session->has('level')) {
            return null;
        }

        return [
            'id'         => (string) $session->get('id'),
            'level'      => (string) $session->get('level'),
            'nama'       => (string) $session->get('namalengkap'),
            'kode_kelas' => (string) $session->get('kode_kelas'),
            'angkatan'   => (string) $session->get('angkatan'),
        ];
    }
}

if (! function_exists('level')) {
    function level(): string
    {
        return (string) session('level');
    }
}

if (! function_exists('punya_peran')) {
    function punya_peran(string ...$peran): bool
    {
        return in_array(level(), $peran, true);
    }
}

if (! function_exists('boleh_ubah')) {
    /** Kepala sekolah hanya boleh melihat data master, tidak mengubah. */
    function boleh_ubah(): bool
    {
        return level() !== 'kepala';
    }
}

if (! function_exists('foto_siswa')) {
    function foto_siswa(?string $foto): string
    {
        $foto = trim((string) $foto);

        return base_url($foto === '' ? 'uploads/foto_siswa/no-image.jpg' : 'uploads/foto_siswa/' . rawurlencode($foto));
    }
}

if (! function_exists('foto_guru')) {
    function foto_guru(?string $foto): string
    {
        $foto = trim((string) $foto);

        return base_url($foto === '' ? 'uploads/foto_siswa/no-image.jpg' : 'uploads/foto_pegawai/' . rawurlencode($foto));
    }
}

if (! function_exists('tombol_hapus')) {
    /**
     * Tombol hapus berupa form POST kecil (dengan token CSRF), menggantikan link GET ?hapus=.
     */
    function tombol_hapus(string $url, string $konfirmasi = 'Apa anda yakin untuk hapus data ini?', string $label = ''): string
    {
        $isi = '<span class="glyphicon glyphicon-remove"></span>' . ($label !== '' ? ' ' . esc($label) : '');

        return '<form action="' . esc($url, 'attr') . '" method="post" class="form-inline-btn" onsubmit="return confirm(\'' . esc($konfirmasi, 'js') . '\')">'
            . csrf_field()
            . '<button type="submit" class="btn btn-danger btn-xs" title="Hapus">' . $isi . '</button></form>';
    }
}

if (! function_exists('pilihan')) {
    /**
     * Ubah hasil query menjadi array opsi untuk form_dropdown().
     *
     * @param list<array<string, mixed>> $baris
     *
     * @return array<string, string>
     */
    function pilihan(array $baris, string $kunci, string|callable $label, ?string $kosong = null): array
    {
        $opsi = $kosong !== null ? ['' => $kosong] : [];
        foreach ($baris as $b) {
            $opsi[(string) $b[$kunci]] = is_callable($label) ? $label($b) : (string) $b[$label];
        }

        return $opsi;
    }
}

if (! function_exists('nilai_angka')) {
    /** Format angka nilai tanpa desimal; kosong jika belum ada nilai. */
    function nilai_angka(float|int|string|null $nilai): string
    {
        if ($nilai === null || $nilai === '') {
            return '';
        }

        return number_format((float) $nilai);
    }
}

if (! function_exists('profil_pengguna')) {
    /**
     * Nama, foto, label level, dan link profil untuk header/sidebar (di-cache per request).
     *
     * @return array{nama: string, foto: string, label: string, profil: string}
     */
    function profil_pengguna(): array
    {
        static $profil = null;
        if ($profil !== null) {
            return $profil;
        }

        $level = level();
        $id    = (string) session('id');
        $db    = db_connect();
        $nama  = (string) session('namalengkap');
        $foto  = base_url('dist/img/user2-160x160.jpg');

        if ($level === 'kepala') {
            $user = $db->table('rb_users')->where('id_user', $id)->get()->getRowArray();
            $guru = $user ? $db->table('rb_guru')->where('nip', $user['username'])->get()->getRowArray() : null;
            $foto = foto_guru($guru['foto'] ?? '');
        } elseif ($level === 'guru') {
            $guru = $db->table('rb_guru')->where('nip', $id)->get()->getRowArray();
            $nama = $guru['nama_guru'] ?? $nama;
            $foto = foto_guru($guru['foto'] ?? '');
        } elseif ($level === 'siswa') {
            $siswa = $db->table('rb_siswa')->where('nisn', $id)->get()->getRowArray();
            $nama  = $siswa['nama'] ?? $nama;
            $foto  = foto_siswa($siswa['foto'] ?? '');
        }

        return $profil = [
            'nama'   => $nama,
            'foto'   => $foto,
            'label'  => config('Menu')->labelLevel[$level] ?? $level,
            'profil' => site_url('profil'),
        ];
    }
}

if (! function_exists('label_mantan')) {
    /** Penanda siswa yang dulu di kelas ini tapi sekarang sudah naik/pindah kelas (lihat riwayat kelas). */
    function label_mantan(array $siswa): string
    {
        return empty($siswa['mantan']) ? ''
            : ' <span class="label label-default" title="Menurut riwayat kelas, siswa ini sekarang di ' . esc($siswa['kode_kelas'], 'attr') . '">sekarang di ' . esc($siswa['kode_kelas']) . '</span>';
    }
}
