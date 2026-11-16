<?php /** Widget pengumuman berlaku & agenda terdekat. @var list<array> $pengumuman @var list<array> $agenda */ ?>
<div class="row">
    <div class="col-lg-7">
        <div class="box">
            <div class="box-header"><h3 class="box-title"><i class="fa fa-bullhorn"></i> Pengumuman</h3>
                <a href="<?= site_url('info/pengumuman') ?>" class="pull-right" style="font-size:12px">Lihat semua</a></div>
            <div class="box-body">
                <?php foreach ($pengumuman as $p): ?>
                    <div style="border-left:3px solid var(--toska); padding:2px 0 2px 10px; margin-bottom:12px">
                        <b><?= esc($p['judul']) ?></b> <small class="text-muted">&middot; <?= tgl_indo($p['tanggal_mulai']) ?></small>
                        <div class="text-muted" style="font-size:12.5px"><?= esc(character_limiter(strip_tags($p['isi']), 140)) ?></div>
                    </div>
                <?php endforeach ?>
                <?php if ($pengumuman === []): ?><p class="text-muted">Tidak ada pengumuman saat ini.</p><?php endif ?>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="box">
            <div class="box-header"><h3 class="box-title"><i class="fa fa-calendar"></i> Agenda Terdekat</h3>
                <a href="<?= site_url('info/kalender') ?>" class="pull-right" style="font-size:12px">Kalender</a></div>
            <div class="box-body">
                <?php foreach ($agenda as $a): ?>
                    <div style="display:flex; gap:10px; margin-bottom:10px; align-items:center">
                        <div style="background:var(--toska-muda); color:var(--utama); border-radius:10px; width:46px; text-align:center; padding:4px 0; line-height:1.1">
                            <b style="font-size:16px"><?= (int) substr($a['tanggal_mulai'], 8, 2) ?></b><br><small><?= nama_bulan((int) substr($a['tanggal_mulai'], 5, 2), true) ?></small>
                        </div>
                        <div><b style="font-size:13px"><?= esc($a['judul']) ?></b><br><small class="text-muted"><?= esc($a['jenis']) ?></small></div>
                    </div>
                <?php endforeach ?>
                <?php if ($agenda === []): ?><p class="text-muted">Belum ada agenda mendatang.</p><?php endif ?>
            </div>
        </div>
    </div>
</div>
