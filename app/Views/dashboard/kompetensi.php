<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="col-xs-12">
    <div class="box">
        <div class="box-header"><h3 class="box-title">Kompetensi Dasar</h3>
            <a class="btn btn-default btn-sm pull-right" href="<?= site_url('/') ?>">Kembali</a></div>
        <div class="box-body">
            <?= view('components/info_jadwal', ['jadwal' => $jadwal]) ?>
            <table class="table table-bordered table-striped">
                <thead><tr><th style="width:20px">No</th><th style="width:140px">Ranah</th><th>Indikator</th></tr></thead>
                <tbody>
                <?php foreach ($baris as $i => $r): ?>
                    <tr><td><?= $i + 1 ?></td><td><?= esc(ucfirst($r['ranah'])) ?></td><td><?= esc($r['kompetensi_dasar']) ?></td></tr>
                <?php endforeach ?>
                <?php if ($baris === []): ?><tr><td colspan="3" class="text-center text-muted">Belum ada kompetensi dasar.</td></tr><?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
