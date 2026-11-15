<?php /** Ringkasan jadwal (kelas, mapel, guru) di atas halaman per-jadwal. @var array $jadwal */ ?>
<table class="table table-condensed table-hover tabel-info" style="margin-bottom:10px">
    <tbody>
    <tr><th scope="row">Kelas</th><td><?= esc($jadwal['kode_kelas']) ?> - <?= esc($jadwal['nama_kelas']) ?></td></tr>
    <tr><th scope="row">Mata Pelajaran</th><td><?= esc($jadwal['namamatapelajaran']) ?></td></tr>
    <tr><th scope="row">Guru</th><td><?= esc($jadwal['nama_guru']) ?></td></tr>
    <?php foreach ($tambahan ?? [] as $label => $nilai): ?>
        <tr><th scope="row"><?= esc($label) ?></th><td><?= esc($nilai) ?></td></tr>
    <?php endforeach ?>
    </tbody>
</table>
