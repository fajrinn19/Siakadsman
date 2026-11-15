<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
use App\Models\QuizUjianModel;

$k = $jadwal['kodejdwl'];
?>
<div class="col-md-12">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Daftar Quiz dan Ujian Online</h3>
            <a style="margin-left:4px" class="btn btn-default btn-sm pull-right" href="<?= site_url('quiz') ?>">Kembali</a>
            <?php if ($kelola): ?>
                <a class="pull-right btn btn-primary btn-sm" href="<?= site_url("quiz/{$k}/tambah") ?>"><i class="fa fa-plus"></i> Tambah Quiz</a>
            <?php endif ?>
        </div>
        <div class="box-body">
            <?= view('components/info_jadwal', ['jadwal' => $jadwal]) ?>
            <table class="table table-bordered table-striped">
                <thead><tr><th>No</th><th>Kategori</th><th>Keterangan</th><th>Batas Waktu</th><th style="width:260px">Aksi</th></tr></thead>
                <tbody>
                <?php foreach ($baris as $i => $r): ?>
                    <?php $habis = QuizUjianModel::waktuHabis($r); ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td class="text-red"><?= esc($r['kategori_quiz_ujian']) ?></td>
                        <td><?= esc($r['keterangan']) ?></td>
                        <td><?= esc(substr($r['batas_waktu'], 0, 16)) ?> WIB <?= $habis ? '<span class="label label-default">selesai</span>' : '<span class="label label-success">berlangsung</span>' ?></td>
                        <td class="aksi">
                            <?php if (level() === 'siswa'): ?>
                                <a class="btn btn-<?= $habis ? 'default' : 'primary' ?> btn-xs" href="<?= site_url("quiz/soal/{$r['id_quiz_ujian']}/kerjakan") ?>">
                                    <span class="glyphicon glyphicon-pencil"></span> <?= $habis ? 'Lihat Jawaban' : 'Kerjakan' ?></a>
                            <?php else: ?>
                                <a class="btn btn-primary btn-xs" href="<?= site_url("quiz/soal/{$r['id_quiz_ujian']}") ?>"><span class="glyphicon glyphicon-search"></span> Soal</a>
                                <a class="btn btn-success btn-xs" href="<?= site_url("quiz/soal/{$r['id_quiz_ujian']}/jawaban") ?>"><span class="glyphicon glyphicon-th-list"></span> Jawaban Siswa</a>
                                <?php if ($kelola): ?>
                                    <?= tombol_hapus(site_url("quiz/{$k}/hapus/{$r['id_quiz_ujian']}"), 'Hapus quiz ini beserta semua soal dan jawaban siswa?') ?>
                                <?php endif ?>
                            <?php endif ?>
                        </td>
                    </tr>
                <?php endforeach ?>
                <?php if ($baris === []): ?><tr><td colspan="5" class="text-center text-muted">Belum ada quiz atau ujian.</td></tr><?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
