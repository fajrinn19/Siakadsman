<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="col-xs-12">
    <div class="box">
        <div class="box-header"><h3 class="box-title"><?= esc($judul) ?></h3>
            <?php if ($teman): ?><a class="btn btn-default btn-sm pull-right" href="<?= site_url('penilaian/teman') ?>">Kembali</a><?php endif ?></div>
        <form method="post" action="<?= esc($action, 'attr') ?>">
            <?= csrf_field() ?>
            <div class="box-body">
                <?php if ($teman): ?>
                    <table class="table table-condensed tabel-info">
                        <tr><th>NISN Teman</th><td><?= esc($teman['nisn']) ?></td></tr>
                        <tr><th>Nama Teman</th><td><?= esc($teman['nama']) ?></td></tr>
                    </table>
                <?php endif ?>
                <table class="table table-bordered">
                    <?php foreach ($pertanyaan as $i => $p): ?>
                        <tr><td style="width:30px"><?= $i + 1 ?></td>
                            <td><b><?= esc($p['pertanyaan']) ?></b>
                                <textarea style="margin-top:5px" class="form-control" rows="2" name="jawaban[<?= (int) $p['id_pertanyaan_penilaian'] ?>]" placeholder="Tulis jawaban di sini..."><?= esc($p['jawaban']) ?></textarea></td></tr>
                    <?php endforeach ?>
                    <?php if ($pertanyaan === []): ?><tr><td class="text-center text-muted">Belum ada pertanyaan.</td></tr><?php endif ?>
                </table>
            </div>
            <?php if ($pertanyaan !== []): ?>
                <div class="box-footer"><button type="submit" class="btn btn-primary">Simpan Semua Jawaban</button></div>
            <?php endif ?>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
