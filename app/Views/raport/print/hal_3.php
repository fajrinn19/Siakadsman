<?= $this->extend('layouts/cetak') ?>
<?= $this->section('content') ?>
<?= view('raport/print/_kop', $this->data) ?>
<h2 style="text-align:center">CAPAIAN HASIL BELAJAR</h2>
<b>A. SIKAP</b><br><br>
<?php foreach (['spiritual' => '1. Sikap Spiritual', 'sosial' => '2. Sikap Sosial'] as $k => $label): ?>
    <b><?= $label ?></b>
    <table width="100%" border="1" class="garis">
        <tr><th width="190">Predikat</th><th>Deskripsi</th></tr>
        <tr><th style="padding:60px"><?= esc($sikap[$k . '_predikat'] ?? '') ?></th><td><?= esc($sikap[$k . '_deskripsi'] ?? '') ?></td></tr>
    </table><br>
<?php endforeach ?>
<?= $this->endSection() ?>
