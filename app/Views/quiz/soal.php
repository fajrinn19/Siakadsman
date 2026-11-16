<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php $id = $quiz['id_quiz_ujian']; ?>
<div class="col-xs-12">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Soal <span class="text-info"><?= esc($quiz['kategori_quiz_ujian']) ?></span><br><small><?= esc($quiz['nama_kelas']) ?> - <?= esc($quiz['keterangan']) ?></small></h3>
            <a class="btn btn-default btn-sm pull-right" href="<?= site_url('quiz/' . $quiz['kodejdwl']) ?>">Kembali</a>
        </div>
        <div class="box-body">
            <?= view('components/info_jadwal', ['jadwal' => $jadwal, 'tambahan' => ['Batas Waktu' => substr($quiz['batas_waktu'], 0, 16) . ' WIB']]) ?>

            <?php if ($kelola && count($quizLain) > 1): ?>
                <form method="post" action="<?= site_url("quiz/soal/{$id}/salin") ?>" class="well well-sm form-inline" onsubmit="return confirm('Salin semua soal dari quiz terpilih ke quiz ini?')">
                    <?= csrf_field() ?>
                    <label><i class="fa fa-database"></i> Bank soal:</label>
                    <?= form_dropdown('sumber', $quizLain, '', ['class' => 'form-control input-sm', 'style' => 'max-width:420px', 'required' => 'required', 'aria-label' => 'Quiz sumber']) ?>
                    <button type="submit" class="btn btn-default btn-sm">Salin Soal</button>
                </form>
            <?php endif ?>

            <h4>A. Soal Essai</h4>
            <table class="table table-bordered table-striped">
                <thead><tr><th style="width:30px">No</th><th>Pertanyaan</th><?php if ($kelola): ?><th style="width:50px"></th><?php endif ?></tr></thead>
                <tbody>
                <?php foreach ($essai as $i => $e): ?>
                    <tr><td><?= $i + 1 ?></td><td><?= nl2br(esc($e['pertanyaan_essai'])) ?></td>
                        <?php if ($kelola): ?><td><?= tombol_hapus(site_url("quiz/soal/{$id}/essai/hapus/{$e['id_pertanyaan_essai']}")) ?></td><?php endif ?></tr>
                <?php endforeach ?>
                <?php if ($essai === []): ?><tr><td colspan="3" class="text-muted text-center">Belum ada soal essai.</td></tr><?php endif ?>
                </tbody>
            </table>
            <?php if ($kelola): ?>
                <form method="post" action="<?= site_url("quiz/soal/{$id}/essai") ?>" class="well well-sm">
                    <?= csrf_field() ?>
                    <label>Tambah Soal Essai</label>
                    <textarea rows="3" name="pertanyaan_essai" class="form-control" placeholder="Tuliskan soal essai..." required></textarea>
                    <button type="submit" class="btn btn-primary btn-sm" style="margin-top:5px">Tambahkan</button>
                </form>
            <?php endif ?>

            <h4>B. Soal Pilihan Ganda</h4>
            <table class="table table-bordered table-striped">
                <thead><tr><th style="width:30px">No</th><th>Pertanyaan</th><?php if ($kelola): ?><th style="width:50px"></th><?php endif ?></tr></thead>
                <tbody>
                <?php foreach ($objektif as $i => $o): ?>
                    <tr><td><?= $i + 1 ?></td>
                        <td><?= nl2br(esc($o['pertanyaan_objektif'])) ?>
                            <?= view('quiz/_pilihan', ['soal' => $o, 'nama' => null, 'tampilKunci' => true]) ?></td>
                        <?php if ($kelola): ?><td><?= tombol_hapus(site_url("quiz/soal/{$id}/objektif/hapus/{$o['id_pertanyaan_objektif']}")) ?></td><?php endif ?></tr>
                <?php endforeach ?>
                <?php if ($objektif === []): ?><tr><td colspan="3" class="text-muted text-center">Belum ada soal pilihan ganda.</td></tr><?php endif ?>
                </tbody>
            </table>
            <?php if ($kelola): ?>
                <form method="post" action="<?= site_url("quiz/soal/{$id}/objektif") ?>" class="well well-sm">
                    <?= csrf_field() ?>
                    <label>Tambah Soal Pilihan Ganda</label>
                    <textarea rows="2" name="pertanyaan_objektif" class="form-control" placeholder="Tuliskan soal..." required><?= esc(old('pertanyaan_objektif')) ?></textarea>
                    <div class="row" style="margin-top:5px">
                        <?php foreach (['a', 'b', 'c', 'd', 'e'] as $h): ?>
                            <div class="col-sm-4" style="margin-bottom:5px"><div class="input-group"><span class="input-group-addon"><?= strtoupper($h) ?></span>
                                <input type="text" name="jawab_<?= $h ?>" class="form-control" value="<?= esc(old('jawab_' . $h)) ?>"<?= in_array($h, ['a', 'b'], true) ? ' required' : '' ?>></div></div>
                        <?php endforeach ?>
                        <div class="col-sm-4"><div class="input-group"><span class="input-group-addon">Kunci</span>
                            <?= form_dropdown('kunci_jawaban', ['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D', 'e' => 'E'], old('kunci_jawaban', 'a'), ['class' => 'form-control']) ?></div></div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Tambahkan</button>
                </form>
            <?php endif ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
