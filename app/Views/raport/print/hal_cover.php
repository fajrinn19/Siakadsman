<?= $this->extend('layouts/cetak') ?>
<?= $this->section('content') ?>
<h1 style="text-align:center">RAPORT SISWA<br><?= esc($sekolah->jenjang) ?><br><?= esc($sekolah->nama) ?></h1>
<center>
    <img width="170" src="<?= base_url('dist/img/logo-raport.png') ?>" alt="Logo"><br><br><br><br><br><br><br><br>
    Nama Siswa:<br>
    <h3 style="border:1px solid #000; width:82%; padding:6px"><?= esc($s['nama']) ?></h3><br><br>
    NIS / NISN<br>
    <h3 style="border:1px solid #000; width:82%; padding:3px"><?= esc($s['nipd']) ?> / <?= esc($s['nisn']) ?></h3><br><br><br><br><br><br>
    <p style="font-size:22px">KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN<br>REPUBLIK INDONESIA</p>
</center>
<?= $this->endSection() ?>
