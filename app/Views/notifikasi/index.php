<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="col-md-7">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><i class="fa fa-whatsapp"></i> Antrean (<?= count($antrean) ?>)</h3>
            <?php if (boleh_ubah() && $antrean !== []): ?>
                <form method="post" action="<?= site_url('notifikasi/kirim') ?>" class="pull-right"><?= csrf_field() ?>
                    <button class="btn btn-primary btn-sm"<?= $aktif ? '' : ' disabled title="Isi token gateway dulu"' ?>><i class="fa fa-paper-plane"></i> Kirim Sekarang</button></form>
            <?php endif ?>
        </div>
        <div class="box-body table-responsive">
            <?php if (! $aktif): ?>
                <div class="alert alert-warning">Gateway belum aktif. Daftar di <b>fonnte.com</b>, hubungkan nomor WhatsApp sekolah, lalu isi
                    <code>notifikasi.token = 'TOKEN'</code> di file <code>.env</code>. Untuk kirim otomatis, jadwalkan cron: <code>php spark notifikasi:kirim</code>.</div>
            <?php endif ?>
            <table class="table table-hover table-condensed">
                <thead><tr><th>No HP</th><th>Pesan</th><th></th></tr></thead>
                <tbody>
                <?php foreach ($antrean as $a): ?>
                    <tr><td style="white-space:nowrap"><?= esc($a['nohp']) ?></td><td style="font-size:12.5px"><?= esc($a['pesan']) ?></td>
                        <td><?php if (boleh_ubah()): ?><?= tombol_hapus(site_url('notifikasi/hapus/' . $a['id_sms']), 'Hapus pesan dari antrean?') ?><?php endif ?></td></tr>
                <?php endforeach ?>
                <?php if ($antrean === []): ?><tr><td colspan="3" class="text-center text-muted">Antrean kosong.</td></tr><?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="col-md-5">
    <div class="box">
        <div class="box-header"><h3 class="box-title">Terkirim (100 terakhir)</h3></div>
        <div class="box-body table-responsive">
            <table class="table table-condensed">
                <?php foreach ($terkirim as $t): ?>
                    <tr><td style="white-space:nowrap; font-size:12px"><?= esc($t['waktu']) ?><br><b><?= esc($t['nohp']) ?></b></td><td style="font-size:12px"><?= esc($t['pesan']) ?></td></tr>
                <?php endforeach ?>
                <?php if ($terkirim === []): ?><tr><td class="text-muted">Belum ada.</td></tr><?php endif ?>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
