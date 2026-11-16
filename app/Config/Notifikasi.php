<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Gateway WhatsApp untuk mengirim antrean notifikasi (tabel rb_sms).
 *
 * Isi di .env:
 *   notifikasi.token = 'TOKEN_FONNTE_ANDA'
 */
class Notifikasi extends BaseConfig
{
    /** Token API Fonnte (https://fonnte.com). Kosong = pengiriman nonaktif. */
    public string $token = '';

    public string $url = 'https://api.fonnte.com/send';

    /** Kode negara untuk nomor yang diawali 0. */
    public string $kodeNegara = '62';

    /** Maksimal pesan per sekali proses. */
    public int $batas = 50;
}
