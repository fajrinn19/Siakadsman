<?php

namespace App\Controllers;

use App\Libraries\Notifikasi;
use App\Models\SmsModel;
use App\Models\SmsOutboxModel;
use CodeIgniter\HTTP\RedirectResponse;

/** Admin melihat antrean & riwayat notifikasi WhatsApp, dan mengirimnya manual. */
class AntreanNotifikasi extends BaseController
{
    public function index(): string
    {
        return view('notifikasi/index', [
            'judul'    => 'Notifikasi WhatsApp',
            'aktif'    => Notifikasi::aktif(),
            'antrean'  => model(SmsModel::class)->orderBy('id_sms', 'DESC')->findAll(200),
            'terkirim' => model(SmsOutboxModel::class)->orderBy('id_outbox', 'DESC')->findAll(100),
        ]);
    }

    public function kirim(): RedirectResponse
    {
        $this->wajibBolehUbah();
        $h = Notifikasi::prosesAntrean();
        $pesan = "Terkirim {$h['terkirim']}, gagal {$h['gagal']}." . ($h['pesan'] ? ' ' . implode(' | ', array_slice($h['pesan'], 0, 3)) : '');

        return redirect()->to(site_url('notifikasi'))->with($h['gagal'] || ! Notifikasi::aktif() ? 'error' : 'sukses', $pesan);
    }

    public function hapus(int $id): RedirectResponse
    {
        $this->wajibBolehUbah();
        model(SmsModel::class)->delete($id);

        return redirect()->to(site_url('notifikasi'))->with('sukses', 'Pesan dihapus dari antrean.');
    }
}
