<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="col-md-12">
    <div class="box box-info">
        <div class="box-header with-border"><h3 class="box-title">Jawaban <?= esc($quiz['kategori_quiz_ujian']) ?></h3>
            <a class="btn btn-default btn-sm pull-right" href="<?= site_url('quiz/' . $quiz['kodejdwl']) ?>">Kembali</a></div>
        <div class="box-body">
            <?= view('components/info_jadwal', ['jadwal' => $jadwal, 'tambahan' => [$quiz['kategori_quiz_ujian'] => $quiz['keterangan']]]) ?>
            <table class="table table-bordered table-striped datatable">
                <thead><tr><th>No</th><th>NISN</th><th>Nama Siswa</th><th>Status</th><th>Objektif</th><th>Essai</th><th>Nilai Akhir</th><th></th></tr></thead>
                <tbody>
                <?php foreach ($siswa as $i => $s): ?>
                    <tr>
                        <td><?= $i + 1 ?></td><td class="text-red"><?= esc($s['nisn']) ?></td><td><?= esc($s['nama']) ?></td>
                        <td><?= $s['sudah'] ? '<i class="text-green">Sudah dijawab</i>' : '<i class="text-red">Belum dijawab</i>' ?></td>
                        <td><?= $s['nilai'] ? $s['nilai']['objektif'] : '-' ?></td>
                        <td><?= $s['nilai'] ? ($s['nilai']['essaiDinilai'] ? $s['nilai']['essai'] : '<span class="label label-warning">belum dinilai</span>') : '-' ?></td>
                        <td><b><?= $s['nilai'] ? $s['nilai']['akhir'] : '-' ?></b></td>
                        <td><a class="btn btn-primary btn-xs" href="<?= site_url('quiz/soal/' . $quiz['id_quiz_ujian'] . '/jawaban/' . rawurlencode($s['nisn'])) ?>"><span class="glyphicon glyphicon-search"></span> Lihat Jawaban</a></td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
