<?= $this->extend('layouts/cetak') ?>
<?= $this->section('content') ?>
<?= view('raport/print/_kop', $this->data) ?>
<h3 style="text-align:center">LAPORAN HASIL UJIAN TENGAH SEMESTER</h3>
<?= view('raport/_tabel_nilai', ['kelompok' => $kelompok, 'kkm' => $sekolah->kkm]) ?>
<br>
<?= view('raport/print/_predikat', ['predikat' => $predikat, 'sekolah' => $sekolah]) ?>
<?= view('raport/_ttd', ['sekolah' => $sekolah, 'wali' => $wali]) ?>
<?= $this->endSection() ?>
