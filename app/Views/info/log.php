<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="col-xs-12">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Log Aktivitas <small>(500 terbaru)</small></h3>
            <form class="pull-right filter-form" method="get" action="<?= site_url('log-aktivitas') ?>">
                <input type="search" name="q" value="<?= esc($q, 'attr') ?>" placeholder="Nama / aksi / URL">
                <input type="date" name="tanggal" value="<?= esc($tanggal, 'attr') ?>">
                <button type="submit" class="btn btn-success btn-sm">Cari</button>
            </form>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-hover table-condensed">
                <thead><tr><th>Waktu</th><th>Pengguna</th><th>Level</th><th>Aksi</th><th>Halaman</th><th>IP</th></tr></thead>
                <tbody>
                <?php foreach ($baris as $l): ?>
                    <tr><td style="white-space:nowrap"><?= esc($l['waktu']) ?></td><td><?= esc($l['nama']) ?> <small class="text-muted"><?= esc($l['id_user']) ?></small></td>
                        <td><?= esc($l['level']) ?></td><td><?= esc($l['aksi']) ?></td><td><code><?= esc($l['url']) ?></code></td><td><?= esc($l['ip']) ?></td></tr>
                <?php endforeach ?>
                <?php if ($baris === []): ?><tr><td colspan="6" class="text-center text-muted">Belum ada aktivitas.</td></tr><?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
