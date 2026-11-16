<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="col-xs-12"><?= view('ortu/_tugas', ['tugas' => $tugas, 'judulBox' => 'Semua Tugas Semester Ini']) ?></div>
<?= $this->endSection() ?>
