<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="col-md-8">
    <div class="box">
        <div class="box-header with-border"><h3 class="box-title"><i class="fa fa-file-excel-o"></i> Impor Data Siswa dari Excel</h3></div>
        <form method="post" action="<?= site_url('siswa/impor') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="box-body">
                <ol>
                    <li>Unduh <a href="<?= site_url('siswa/impor/template') ?>"><b>template Excel</b></a>, lalu isi satu siswa per baris (jangan ubah judul kolom).</li>
                    <li><b>nisn</b> dan <b>nama</b> wajib. <b>kode_kelas</b> harus sama dengan kode di Data Kelas. <b>jenis_kelamin</b>: L/P. <b>tanggal_lahir</b>: YYYY-MM-DD.</li>
                    <li>Kolom <b>password</b> boleh kosong: password awal = NISN dan siswa wajib menggantinya saat login pertama.</li>
                </ol>
                <div class="form-group"><label>File (.xlsx, .xls, .csv — maks. 5 MB)</label><input type="file" name="file" accept=".xlsx,.xls,.csv" required></div>
                <div class="checkbox"><label><input type="checkbox" name="perbarui" value="1"> Perbarui data siswa yang NISN-nya sudah ada (jika tidak dicentang, baris itu dilewati)</label></div>
            </div>
            <div class="box-footer"><button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Impor</button>
                <a href="<?= site_url('siswa') ?>" class="btn btn-default pull-right">Kembali</a></div>
        </form>
    </div>
</div>
<?php if ($hasil): ?>
    <div class="col-md-4">
        <div class="box">
            <div class="box-header"><h3 class="box-title">Hasil Impor Terakhir</h3></div>
            <div class="box-body">
                <p><span class="chip chip-aktif"><?= $hasil['baru'] ?> baru</span> <span class="chip chip-aktif"><?= $hasil['diperbarui'] ?> diperbarui</span>
                    <span class="chip chip-redup"><?= $hasil['dilewati'] ?> dilewati</span> <span class="chip chip-tunggu"><?= count($hasil['error']) ?> error</span></p>
                <?php if ($hasil['error'] !== []): ?>
                    <ul class="text-red" style="padding-left:18px; font-size:12.5px"><?php foreach ($hasil['error'] as $e): ?><li><?= esc($e) ?></li><?php endforeach ?></ul>
                <?php endif ?>
            </div>
        </div>
    </div>
<?php endif ?>
<?= $this->endSection() ?>
