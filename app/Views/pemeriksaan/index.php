<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php $masalah = count(array_filter($hasil, static fn ($h) => $h['jumlah'] > 0 && empty($h['info']))); ?>
<div class="col-xs-12">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><i class="fa fa-stethoscope"></i> Pemeriksaan Data</h3>
            <span class="chip <?= $masalah ? 'chip-tunggu' : 'chip-aktif' ?>" style="margin-left:8px"><?= $masalah ? "{$masalah} hal perlu dirapikan" : 'Data sehat' ?></span>
        </div>
        <div class="box-body table-responsive">
            <p class="text-muted">Disarankan <b>membuat cadangan database</b> sebelum menekan tombol Bersihkan; data yang dihapus tidak bisa dikembalikan.</p>
            <table class="table table-hover">
                <thead><tr><th style="width:40px"></th><th>Pemeriksaan</th><th style="width:90px">Jumlah</th><th>Keterangan</th><th style="width:120px"></th></tr></thead>
                <tbody>
                <?php foreach ($hasil as $h): ?>
                    <?php $ok = $h['jumlah'] === 0; ?>
                    <tr>
                        <td><?= $ok ? '<i class="fa fa-check-circle text-green fa-lg"></i>' : (! empty($h['info']) ? '<i class="fa fa-info-circle text-muted fa-lg"></i>' : '<i class="fa fa-exclamation-triangle fa-lg" style="color:var(--kuning)"></i>') ?></td>
                        <td><b><?= esc($h['judul']) ?></b></td>
                        <td><?= number_format($h['jumlah']) ?></td>
                        <td class="text-muted" style="font-size:12.5px"><?= $ok ? 'Aman.' : esc($h['pesan']) ?></td>
                        <td>
                            <?php if (! $ok && ! empty($h['bersihkan']) && level() === 'superuser'): ?>
                                <form method="post" action="<?= site_url('pemeriksaan-data/bersihkan/' . $h['bersihkan']) ?>" onsubmit="return confirm('Hapus <?= (int) $h['jumlah'] ?> baris data ini secara permanen?')">
                                    <?= csrf_field() ?><button class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Bersihkan</button></form>
                            <?php elseif (! $ok && ! empty($h['tautan'])): ?>
                                <a class="btn btn-default btn-xs" href="<?= esc($h['tautan'], 'attr') ?>">Perbaiki</a>
                            <?php endif ?>
                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
