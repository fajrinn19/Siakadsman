<?php

namespace App\Libraries;

use App\Models\SmsModel;
use App\Models\SmsOutboxModel;
use Config\Notifikasi as Cfg;

/**
 * Kirim antrean pesan rb_sms lewat WhatsApp (Fonnte). Pesan terkirim dipindah ke rb_sms_outbox.
 */
class Notifikasi
{
    public static function aktif(): bool
    {
        return trim(config(Cfg::class)->token) !== '';
    }

    /** @return array{terkirim: int, gagal: int, pesan: list<string>} */
    public static function prosesAntrean(): array
    {
        $cfg   = config(Cfg::class);
        $hasil = ['terkirim' => 0, 'gagal' => 0, 'pesan' => []];
        if (! self::aktif()) {
            $hasil['pesan'][] = 'Token gateway belum diisi (notifikasi.token di .env).';

            return $hasil;
        }

        $client = service('curlrequest', ['timeout' => 20, 'http_errors' => false]);
        foreach (model(SmsModel::class)->orderBy('id_sms', 'ASC')->findAll($cfg->batas) as $sms) {
            $nomor = self::normalkan($sms['nohp'], $cfg->kodeNegara);
            try {
                $res  = $client->post($cfg->url, [
                    'headers'     => ['Authorization' => $cfg->token],
                    'form_params' => ['target' => $nomor, 'message' => $sms['pesan']],
                ]);
                $json = json_decode($res->getBody(), true);
                $ok   = $res->getStatusCode() === 200 && ! empty($json['status']);
            } catch (\Throwable $e) {
                $ok   = false;
                $json = ['reason' => $e->getMessage()];
            }

            if ($ok) {
                model(SmsOutboxModel::class)->insert(['nohp' => $sms['nohp'], 'pesan' => $sms['pesan'], 'waktu' => date('Y-m-d H:i:s')]);
                model(SmsModel::class)->delete($sms['id_sms']);
                $hasil['terkirim']++;
            } else {
                $hasil['gagal']++;
                $hasil['pesan'][] = "{$sms['nohp']}: " . ($json['reason'] ?? 'gagal dikirim');
            }
        }

        return $hasil;
    }

    /** 0812xxxx → 62812xxxx; buang spasi/tanda baca. */
    public static function normalkan(string $nomor, string $kodeNegara = '62'): string
    {
        $n = preg_replace('/\D+/', '', $nomor);

        return str_starts_with($n, '0') ? $kodeNegara . substr($n, 1) : $n;
    }
}
