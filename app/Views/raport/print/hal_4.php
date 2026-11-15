<?= $this->extend('layouts/cetak') ?>
<?= $this->section('content') ?>
<?= view('raport/print/_kop', $this->data) ?>
<b>B. PENGETAHUAN DAN KETERAMPILAN</b>
<?= view('raport/_tabel_nilai', ['kelompok' => $kelompok, 'kkm' => $sekolah->kkm]) ?>
<br>
<?= view('raport/print/_predikat', ['predikat' => $predikat, 'sekolah' => $sekolah]) ?>
<?= view('raport/_ttd', ['sekolah' => $sekolah, 'wali' => $wali]) ?>
<?= $this->endSection() ?>
