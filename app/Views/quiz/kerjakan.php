<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php $id = $quiz['id_quiz_ujian']; ?>
<div class="col-xs-12">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><?= esc($quiz['kategori_quiz_ujian']) ?><br><small><?= esc($quiz['nama_kelas']) ?> - <?= esc($quiz['keterangan']) ?></small></h3>
            <a class="btn btn-default btn-sm pull-right" href="<?= site_url('quiz/' . $quiz['kodejdwl']) ?>">Kembali</a>
        </div>
        <div class="box-body">
            <?php if ($habis): ?>
                <div class="alert alert-warning">Waktu pengerjaan sudah habis (<?= esc(substr($quiz['batas_waktu'], 0, 16)) ?> WIB). Jawaban tidak bisa diubah lagi.</div>
            <?php else: ?>
                <div class="alert alert-info">Batas waktu: <b><?= esc(substr($quiz['batas_waktu'], 0, 16)) ?> WIB</b>. Sisa waktu: <b id="sisaWaktu" data-batas="<?= strtotime($quiz['batas_waktu']) ?>"></b></div>
            <?php endif ?>

            <h4>A. Soal Essai</h4>
            <table class="table table-bordered">
                <?php foreach ($essai as $i => $e): ?>
                    <tr><td style="width:30px"><?= $i + 1 ?></td>
                        <td><?= nl2br(esc($e['pertanyaan_essai'])) ?><pre style="margin-top:5px"><b>Jawaban:</b> <?= esc($e['jawaban'] ?: '-') ?></pre></td>
                        <td style="width:80px"><?php if (! $habis): ?><a class="btn btn-success btn-xs" href="<?= site_url("quiz/soal/{$id}/essai/{$e['id_pertanyaan_essai']}") ?>"><span class="glyphicon glyphicon-pencil"></span> Jawab</a><?php endif ?></td></tr>
                <?php endforeach ?>
                <?php if ($essai === []): ?><tr><td class="text-muted text-center">Tidak ada soal essai.</td></tr><?php endif ?>
            </table>

            <h4>B. Soal Pilihan Ganda</h4>
            <form method="post" action="<?= site_url("quiz/soal/{$id}/kerjakan") ?>">
                <?= csrf_field() ?>
                <table class="table table-bordered">
                    <?php foreach ($objektif as $i => $o): ?>
                        <tr><td style="width:30px"><?= $i + 1 ?></td>
                            <td><?= nl2br(esc($o['pertanyaan_objektif'])) ?>
                                <?= view('quiz/_pilihan', ['soal' => $o, 'nama' => $habis ? null : 'jawaban[' . $o['id_pertanyaan_objektif'] . ']']) ?></td></tr>
                    <?php endforeach ?>
                    <?php if ($objektif === []): ?><tr><td class="text-muted text-center">Tidak ada soal pilihan ganda.</td></tr><?php endif ?>
                </table>
                <?php if (! $habis && $objektif !== []): ?>
                    <button type="submit" class="btn btn-info pull-right">Simpan Jawaban Pilihan Ganda</button>
                <?php endif ?>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
    (function () {
        var el = document.getElementById('sisaWaktu');
        if (!el) { return; }
        var batas = parseInt(el.getAttribute('data-batas'), 10) * 1000;
        (function tick() {
            var s = Math.max(0, Math.floor((batas - Date.now()) / 1000));
            el.textContent = Math.floor(s / 3600) + ' jam ' + Math.floor(s % 3600 / 60) + ' menit ' + (s % 60) + ' detik';
            if (s > 0) { setTimeout(tick, 1000); }
        })();
    })();
</script>
<?= $this->endSection() ?>
