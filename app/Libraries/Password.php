<?php

namespace App\Libraries;

/**
 * Verifikasi password yang kompatibel dengan data lama.
 *
 * Data lama menyimpan password admin sebagai sha512(md5(password)) dan password
 * guru/siswa sebagai teks biasa. Setelah login berhasil, password diganti ke
 * password_hash() agar aman (lihat perluRehash()).
 */
class Password
{
    public static function hash(string $plain): string
    {
        return password_hash($plain, PASSWORD_DEFAULT);
    }

    public static function cocok(string $plain, ?string $tersimpan, bool $formatAdminLama = false): bool
    {
        $tersimpan = (string) $tersimpan;
        if ($tersimpan === '' || $plain === '') {
            return false;
        }

        if (self::isModern($tersimpan)) {
            return password_verify($plain, $tersimpan);
        }

        $pembanding = $formatAdminLama ? hash('sha512', md5($plain)) : $plain;

        return hash_equals($tersimpan, $pembanding);
    }

    public static function perluRehash(string $tersimpan): bool
    {
        return ! self::isModern($tersimpan) || password_needs_rehash($tersimpan, PASSWORD_DEFAULT);
    }

    private static function isModern(string $hash): bool
    {
        return (password_get_info($hash)['algo'] ?? null) !== null;
    }
}
