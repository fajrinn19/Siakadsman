<?php

namespace App\Commands;

use App\Libraries\Notifikasi;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

/**
 * php spark notifikasi:kirim — kirim antrean pesan WhatsApp. Bisa dijalankan lewat cron, mis. tiap 5 menit.
 */
class KirimNotifikasi extends BaseCommand
{
    protected $group       = 'SIAKAD';
    protected $name        = 'notifikasi:kirim';
    protected $description = 'Kirim antrean notifikasi (rb_sms) lewat gateway WhatsApp.';

    public function run(array $params)
    {
        $h = Notifikasi::prosesAntrean();
        CLI::write("Terkirim: {$h['terkirim']}, gagal: {$h['gagal']}", $h['gagal'] ? 'yellow' : 'green');
        foreach ($h['pesan'] as $p) {
            CLI::write(' - ' . $p);
        }
    }
}
