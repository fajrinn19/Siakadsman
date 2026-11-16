<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="col-md-10 col-md-offset-1">
    <?php foreach ($baris as $p): ?>
        <div class="box">
            <div class="box-header"><h3 class="box-title"><i class="fa fa-bullhorn"></i> <?= esc($p['judul']) ?></h3>
                <span class="pull-right text-muted" style="font-size:12px"><?= tgl_indo($p['tanggal_mulai']) ?></span></div>
            <div class="box-body"><?= nl2br(esc($p['isi'])) ?></div>
        </div>
    <?php endforeach ?>
    <?php if ($baris === []): ?><div class="box"><div class="box-body pesan-kosong">Belum ada pengumuman yang berlaku.</div></div><?php endif ?>
</div>
<?= $this->endSection() ?>
