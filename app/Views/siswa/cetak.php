<?= $this->extend('layouts/cetak') ?>
<?= $this->section('content') ?>
<h2 style="text-align:center">Data Siswa<?= $kelas ? ' Kelas ' . esc($kelas['nama_kelas']) : '' ?><?= $angkatan !== '' ? '<br>Angkatan ' . esc($angkatan) : '' ?></h2>
<table class="garis" width="100%">
    <tr><th>No</th><th>NIPD</th><th>NISN</th><th>Nama Siswa</th><th>Jenis Kelamin</th><th>Jurusan</th></tr>
    <?php foreach ($baris as $i => $r): ?>
        <tr>
            <td><?= $i + 1 ?></td><td><?= esc($r['nipd']) ?></td><td><?= esc($r['nisn']) ?></td>
            <td><?= esc($r['nama']) ?></td><td><?= esc($r['jenis_kelamin']) ?></td><td><?= esc($r['nama_jurusan']) ?></td>
        </tr>
    <?php endforeach ?>
</table>
<br>
<?= view('raport/_ttd', ['sekolah' => $sekolah, 'wali' => $kelas ? ['nama' => $kelas['nama_guru'], 'nip' => $kelas['nip']] : null]) ?>
<?= $this->endSection() ?>
