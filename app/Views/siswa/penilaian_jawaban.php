<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="col-xs-12">
    <div class="box">
        <div class="box-header"><h3 class="box-title"><?= esc($judul) ?></h3>
            <a href="javascript:history.back()" class="btn btn-default btn-sm pull-right">Kembali</a></div>
        <div class="box-body">
            <table class="table table-condensed table-hover tabel-info">
                <tr><th>NISN<?= $teman ? ' Penilai' : '' ?></th><td><?= esc($s['nisn']) ?></td></tr>
                <tr><th>Nama<?= $teman ? ' Penilai' : '' ?></th><td><?= esc($s['nama']) ?></td></tr>
                <tr><th>Kelas</th><td><?= esc($s['nama_kelas']) ?></td></tr>
                <?php if ($teman): ?>
                    <tr style="background:#f4f4f4"><th>NISN Teman</th><td class="text-primary"><?= esc($teman['nisn']) ?></td></tr>
                    <tr style="background:#f4f4f4"><th>Nama Teman</th><td class="text-primary"><?= esc($teman['nama']) ?></td></tr>
                <?php endif ?>
            </table>
            <table class="table table-bordered table-striped">
                <thead><tr><th style="width:20px">No</th><th>Pertanyaan &amp; Jawaban</th></tr></thead>
                <tbody>
                <?php foreach ($pertanyaan as $i => $p): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= esc($p['pertanyaan']) ?><br><strong>Jawaban:</strong><br>
                            <?= trim($p['jawaban']) === '' ? '<i class="text-red">Belum ada jawaban...</i>' : '<i>' . nl2br(esc($p['jawaban'])) . '</i>' ?></td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
