<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php $k = $jadwal['kodejdwl']; ?>
<div class="col-xs-12">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Kompetensi Dasar</h3>
            <?php if (boleh_ubah()): ?>
                <a class="pull-right btn btn-primary btn-sm" href="<?= site_url("kompetensi-dasar/{$k}/tambah") ?>"><i class="fa fa-plus"></i> Tambah Kompetensi Dasar</a>
            <?php endif ?>
        </div>
        <div class="box-body">
            <?= view('components/info_jadwal', ['jadwal' => $jadwal]) ?>
            <table class="table table-bordered table-striped datatable">
                <thead><tr><th style="width:20px">No</th><th style="width:140px">Ranah</th><th>Indikator</th><?php if (boleh_ubah()): ?><th style="width:80px">Aksi</th><?php endif ?></tr></thead>
                <tbody>
                <?php foreach ($baris as $i => $r): ?>
                    <tr>
                        <td><?= $i + 1 ?></td><td><?= esc(ucfirst($r['ranah'])) ?></td><td><?= esc($r['kompetensi_dasar']) ?></td>
                        <?php if (boleh_ubah()): ?>
                            <td class="aksi text-center">
                                <a class="btn btn-success btn-xs" href="<?= site_url("kompetensi-dasar/{$k}/edit/{$r['id_kompetensi_dasar']}") ?>"><span class="glyphicon glyphicon-edit"></span></a>
                                <?= tombol_hapus(site_url("kompetensi-dasar/{$k}/hapus/{$r['id_kompetensi_dasar']}")) ?>
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
