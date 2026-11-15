<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="col-md-12">
    <div class="box box-info">
        <div class="box-header with-border"><h3 class="box-title">Jawab Soal Essai</h3></div>
        <form method="post" action="<?= site_url('quiz/soal/' . $quiz['id_quiz_ujian'] . '/essai/' . $soal['id_pertanyaan_essai']) ?>">
            <?= csrf_field() ?>
            <div class="box-body">
                <p><b>Soal:</b><br><?= nl2br(esc($soal['pertanyaan_essai'])) ?></p>
                <textarea rows="6" class="form-control" name="jawaban_essai" autofocus><?= esc($jawab['jawaban_essai'] ?? '') ?></textarea>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-info">Simpan Jawaban</button>
                <a href="<?= site_url('quiz/soal/' . $quiz['id_quiz_ujian'] . '/kerjakan') ?>" class="btn btn-default pull-right">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
