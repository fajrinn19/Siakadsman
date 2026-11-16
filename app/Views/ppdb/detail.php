<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php use App\Controllers\Ppdb; [$label, $chip] = Ppdb::STATUS[(int) $p['proses']] ?? Ppdb::STATUS[0]; ?>
<div class="col-md-8">
    <div class="box">
        <div class="box-header with-border"><h3 class="box-title"><?= esc($p['nama']) ?> <small><code><?= esc($p['kode_pendaftaran']) ?></code></small></h3>
            <span class="chip <?= $chip ?> pull-right"><?= $label ?></span></div>
        <div class="box-body">
            <?php foreach ($field as $judul => $daftar): ?>
                <h4 style="font-weight:600"><?= esc($judul) ?></h4>
                <table class="table table-condensed tabel-info">
                    <?php foreach ($daftar as $f): ?>
                        <?php $v = match ($f['name']) { 'id_jenis_kelamin' => $p['jenis_kelamin'], 'id_agama' => $p['nama_agama'], 'tanggal_lahir' => tgl_indo($p['tanggal_lahir']), default => $p[$f['name']] ?? '' }; ?>
                        <tr><th><?= esc($f['label']) ?></th><td><?= esc((string) $v) ?></td></tr>
                    <?php endforeach ?>
                </table>
            <?php endforeach ?>
        </div>
        <div class="box-footer"><a href="<?= site_url('ppdb/admin') ?>" class="btn btn-default">Kembali</a></div>
    </div>
</div>
<?php if (boleh_ubah() && (int) $p['proses'] !== 1): ?>
<div class="col-md-4">
    <div class="box">
        <div class="box-header with-border"><h3 class="box-title">Verifikasi</h3></div>
        <form method="post" action="<?= site_url('ppdb/admin/' . $p['id_pendaftaran'] . '/terima') ?>" onsubmit="return confirm('Terima dan tambahkan sebagai siswa?')">
            <?= csrf_field() ?>
            <div class="box-body">
                <div class="form-group"><label>NISN</label><input type="text" name="nisn" class="form-control" value="<?= esc($p['no_induk'], 'attr') ?>" required></div>
                <div class="form-group"><label>Masuk ke kelas</label><?= form_dropdown('kode_kelas', $kelasOpsi, '', ['class' => 'form-control', 'required' => 'required']) ?></div>
                <p class="text-muted" style="font-size:12px">Siswa dibuat dengan password awal = NISN (wajib diganti saat login pertama) dan tercatat "Masuk" di riwayat kelas.</p>
            </div>
            <div class="box-footer"><button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Terima</button></div>
        </form>
        <?php if ((int) $p['proses'] === 0): ?>
            <div class="box-footer"><form method="post" action="<?= site_url('ppdb/admin/' . $p['id_pendaftaran'] . '/tolak') ?>" onsubmit="return confirm('Tandai tidak diterima?')"><?= csrf_field() ?><button class="btn btn-danger btn-sm">Tidak diterima</button></form></div>
        <?php endif ?>
    </div>
</div>
<?php endif ?>
<?= $this->endSection() ?>
