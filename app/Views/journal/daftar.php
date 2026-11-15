<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php $k = $jadwal['kodejdwl']; ?>
<div class="col-xs-12">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Journal Kegiatan Belajar Mengajar</h3>
            <a style="margin-left:5px" class="pull-right btn btn-success btn-sm" href="<?= site_url("kompetensi-dasar/{$k}") ?>">Lihat Kompetensi Dasar</a>
            <?php if (boleh_ubah()): ?>
                <a class="pull-right btn btn-primary btn-sm" href="<?= site_url("journal/{$k}/tambah") ?>"><i class="fa fa-plus"></i> Tambah Journal</a>
            <?php endif ?>
        </div>
        <div class="box-body">
            <?= view('components/info_jadwal', ['jadwal' => $jadwal]) ?>
            <table class="table table-bordered table-striped datatable">
                <thead><tr><th style="width:20px">No</th><th>Hari</th><th style="width:100px">Tanggal</th><th style="width:70px">Jam Ke</th><th style="width:220px">Materi</th><th>Keterangan</th><?php if (boleh_ubah()): ?><th style="width:80px">Aksi</th><?php endif ?></tr></thead>
                <tbody>
                <?php foreach ($baris as $i => $r): ?>
                    <tr>
                        <td><?= $i + 1 ?></td><td><?= esc($r['hari']) ?></td><td><?= tgl_indo($r['tanggal']) ?></td><td class="text-center"><?= esc($r['jam_ke']) ?></td>
                        <td><?= nl2br(esc($r['materi'])) ?></td><td><?= nl2br(esc($r['keterangan'])) ?></td>
                        <?php if (boleh_ubah()): ?>
                            <td class="aksi text-center">
                                <a class="btn btn-success btn-xs" href="<?= site_url("journal/{$k}/edit/{$r['id_journal']}") ?>"><span class="glyphicon glyphicon-edit"></span></a>
                                <?= tombol_hapus(site_url("journal/{$k}/hapus/{$r['id_journal']}")) ?>
                            </td>
                        <?php endif ?>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
