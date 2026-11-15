<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Pengaturan identitas sekolah yang dipakai di tampilan dan cetakan raport.
 *
 * Semua nilai bisa ditimpa lewat file .env, contoh:
 *   sekolah.kepalaNama = 'Nama Kepala Sekolah'
 */
class Sekolah extends BaseConfig
{
    public string $nama = 'SMA NEGERI 14 SINJAI';

    public string $namaPendek = 'SMA 14 SINJAI';

    public string $jenjang = 'SEKOLAH MENENGAH ATAS';

    public string $kota = 'Sinjai';

    public string $kepalaNama = 'Husniar, S.Pd., M.Pd., Gr';

    public string $kepalaNip = '196209051987031007';

    /** Kriteria Ketuntasan Minimal yang dicetak di raport. */
    public int $kkm = 77;

    /** Antrekan SMS ke orang tua (tabel rb_sms) ketika siswa tidak hadir. */
    public bool $smsAbsensi = true;

    /** Batas percobaan login gagal per IP sebelum diblokir sementara. */
    public int $maksPercobaanLogin = 5;

    /** Lama blokir login (menit). */
    public int $lamaBlokirMenit = 15;
}
