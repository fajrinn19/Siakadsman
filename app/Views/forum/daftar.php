<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="col-md-12">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Daftar Topik Forum Diskusi</h3>
            <a style="margin-left:4px" class="btn btn-default btn-sm pull-right" href="<?= site_url('forum') ?>">Kembali</a>
            <?php if ($kelola): ?><a class="pull-right btn btn-primary btn-sm" href="<?= site_url('forum/' . $jadwal['kodejdwl'] . '/tambah') ?>"><i class="fa fa-plus"></i> Buat Topik Baru</a><?php endif ?>
        </div>
        <div class="box-body">
            <?= view('components/info_jadwal', ['jadwal' => $jadwal]) ?>
            <table class="table table-bordered table-striped">
                <thead><tr><th>No</th><th>Judul Topik</th><th>Balasan</th><th>Waktu</th><th style="width:150px">Aksi</th></tr></thead>
                <tbody>
                <?php foreach ($topik as $i => $t): ?>
                    <tr>
                        <td><?= $i + 1 ?></td><td class="text-red"><?= esc($t['judul_topic']) ?></td><td><?= (int) $t['jumlah_balasan'] ?> balasan</td><td><?= esc($t['waktu']) ?> WIB</td>
                        <td class="aksi">
                            <a class="btn btn-success btn-xs" href="<?= site_url('forum/topik/' . $t['id_forum_topic']) ?>"><span class="glyphicon glyphicon-th-list"></span> Lihat</a>
                            <?php if ($kelola): ?><?= tombol_hapus(site_url('forum/topik/' . $t['id_forum_topic'] . '/hapus'), 'Hapus topik ini beserta semua komentarnya?') ?><?php endif ?>
                        </td>
                    </tr>
                <?php endforeach ?>
                <?php if ($topik === []): ?><tr><td colspan="5" class="text-center text-muted">Belum ada topik diskusi.</td></tr><?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
