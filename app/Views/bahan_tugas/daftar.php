<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
use App\Controllers\BahanTugas;

$k = $jadwal['kodejdwl'];
?>
<div class="col-md-12">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Daftar Bahan dan Tugas</h3>
            <a style="margin-left:4px" class="btn btn-default btn-sm pull-right" href="<?= site_url('bahan-tugas') ?>">Kembali</a>
            <?php if ($kelola): ?>
                <a class="pull-right btn btn-primary btn-sm" href="<?= site_url("bahan-tugas/{$k}/tambah") ?>"><i class="fa fa-plus"></i> Tambah</a>
            <?php endif ?>
        </div>
        <div class="box-body">
            <?= view('components/info_jadwal', ['jadwal' => $jadwal]) ?>
            <table class="table table-bordered table-striped">
                <thead><tr><th>No</th><th>Judul</th><th>Kategori</th><th>Waktu Mulai</th><th>Batas Waktu</th><th>Keterangan</th><th style="width:230px">Aksi</th></tr></thead>
                <tbody>
                <?php foreach ($baris as $i => $r): ?>
                    <?php $tugas = (int) $r['id_kategori_elearning'] === 2; $habis = BahanTugas::waktuHabis($r); ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td class="text-red"><?= esc($r['nama_file']) ?></td>
                        <td><?= esc($r['nama_kategori_elearning']) ?></td>
                        <td><?= tgl_valid($r['tanggal_tugas']) ? esc(substr($r['tanggal_tugas'], 0, 16)) . ' WIB' : '-' ?></td>
                        <td><?= tgl_valid($r['tanggal_selesai']) ? esc(substr($r['tanggal_selesai'], 0, 16)) . ' WIB' : '-' ?></td>
                        <td><?= esc($r['keterangan']) ?></td>
                        <td class="aksi">
                            <?php if ($r['file_upload'] !== ''): ?>
                                <a class="btn btn-info btn-xs" href="<?= site_url('unduh/bahan/' . $r['id_elearning']) ?>"><span class="glyphicon glyphicon-download"></span> Unduh</a>
                            <?php endif ?>
                            <?php if (level() === 'siswa' && $tugas): ?>
                                <?php if (isset($terkirim[$r['id_elearning']])): ?>
                                    <span class="label label-success">Terkirim <?= esc(substr($terkirim[$r['id_elearning']], 0, 16)) ?></span>
                                <?php elseif ($habis): ?>
                                    <span class="label label-danger">Waktu habis</span>
                                <?php else: ?>
                                    <a class="btn btn-success btn-xs" href="<?= site_url("bahan-tugas/{$k}/kirim/{$r['id_elearning']}") ?>"><span class="glyphicon glyphicon-upload"></span> Kirim Tugas</a>
                                <?php endif ?>
                            <?php endif ?>
                            <?php if ($kelola || level() === 'kepala'): ?>
                                <?php if ($tugas): ?>
                                    <a class="btn btn-success btn-xs" href="<?= site_url("bahan-tugas/{$k}/jawaban/{$r['id_elearning']}") ?>"><span class="glyphicon glyphicon-list"></span> Jawaban</a>
                                <?php endif ?>
                            <?php endif ?>
                            <?php if ($kelola): ?>
                                <a class="btn btn-warning btn-xs" href="<?= site_url("bahan-tugas/{$k}/edit/{$r['id_elearning']}") ?>"><span class="glyphicon glyphicon-edit"></span></a>
                                <?= tombol_hapus(site_url("bahan-tugas/{$k}/hapus/{$r['id_elearning']}")) ?>
                            <?php endif ?>
                        </td>
                    </tr>
                <?php endforeach ?>
                <?php if ($baris === []): ?><tr><td colspan="7" class="text-center text-muted">Belum ada bahan atau tugas.</td></tr><?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
