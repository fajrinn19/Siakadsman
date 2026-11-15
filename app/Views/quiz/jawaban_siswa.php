<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php $id = $quiz['id_quiz_ujian']; ?>
<div class="col-xs-12">
    <div class="box">
        <div class="box-header"><h3 class="box-title">Jawaban <?= esc($siswa['nama']) ?> (<?= esc($siswa['nisn']) ?>)</h3>
            <a class="btn btn-default btn-sm pull-right" href="<?= site_url("quiz/soal/{$id}/jawaban") ?>">Kembali</a></div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-8">
                    <table class="table table-condensed tabel-info">
                        <tr><th>Nilai Pilihan Ganda</th><td><?= $nilai['objektif'] ?> (<?= $nilai['benar'] ?> benar dari <?= $nilai['total'] ?> soal)</td></tr>
                        <tr><th>Nilai Essai</th><td><?= $nilai['essaiDinilai'] ? $nilai['essai'] : '<span class="label label-warning">belum dinilai</span>' ?></td></tr>
                        <tr><th>Nilai Akhir</th><td><b>(Essai + Pilihan Ganda) : 2 = <?= $nilai['akhir'] ?></b></td></tr>
                    </table>
                </div>
                <?php if (boleh_ubah()): ?>
                    <div class="col-md-4">
                        <form method="post" action="<?= site_url("quiz/soal/{$id}/jawaban/" . rawurlencode($siswa['nisn'])) ?>" class="well well-sm form-inline">
                            <?= csrf_field() ?>
                            <label>Nilai Essai (0-100)</label><br>
                            <input type="number" name="nilai_essai" min="0" max="100" class="form-control" value="<?= $nilai['essaiDinilai'] ? (int) $nilai['essai'] : '' ?>" required>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </form>
                    </div>
                <?php endif ?>
            </div>

            <h4>A. Jawaban Essai</h4>
            <table class="table table-bordered">
                <?php foreach ($essai as $i => $e): ?>
                    <tr><td style="width:30px"><?= $i + 1 ?></td><td><?= nl2br(esc($e['pertanyaan_essai'])) ?><pre style="margin-top:5px"><b>Jawaban:</b> <?= esc($e['jawaban'] ?: '-') ?></pre></td></tr>
                <?php endforeach ?>
            </table>

            <h4>B. Jawaban Pilihan Ganda</h4>
            <table class="table table-bordered">
                <?php foreach ($objektif as $i => $o): ?>
                    <?php $benar = $o['jawaban'] !== '' && $o['jawaban'] === strtolower($o['kunci_jawaban']); ?>
                    <tr><td style="width:30px"><?= $i + 1 ?></td>
                        <td><?= nl2br(esc($o['pertanyaan_objektif'])) ?>
                            <?= view('quiz/_pilihan', ['soal' => $o, 'nama' => null, 'tampilKunci' => true]) ?>
                            <?php if ($o['jawaban'] !== ''): ?>
                                <div class="btn btn-<?= $benar ? 'success' : 'danger' ?> btn-xs btn-block">Jawaban '<?= esc($o['jawaban']) ?>' <?= $benar ? 'Benar' : 'Salah' ?></div>
                            <?php else: ?>
                                <div class="btn btn-default btn-xs btn-block">Tidak dijawab</div>
                            <?php endif ?></td></tr>
                <?php endforeach ?>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
