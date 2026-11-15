<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Daftar Siswa Kelas <?= esc($kelas['nama_kelas']) ?></title>
    <style>
        th { background-color: #4CAF50; color: white; font-weight: bold; }
        table.data { border-collapse: collapse; width: 100%; margin-top: 20px; }
        table.data th, table.data td { border: 1px solid #000; padding: 6px; text-align: left; }
    </style>
</head>
<body>
<h2 style="text-align:center">DAFTAR SISWA<br>Kelas <?= esc($kelas['nama_kelas']) ?></h2>
<table>
    <tr><td><b>Kode Kelas:</b></td><td><?= esc($kelas['kode_kelas']) ?></td><td><b>Wali Kelas:</b></td><td><?= esc($kelas['nama_guru'] ?: '-') ?></td></tr>
    <tr><td><b>Jurusan:</b></td><td><?= esc($kelas['nama_jurusan'] ?: '-') ?></td><td><b>Ruangan:</b></td><td><?= esc($kelas['nama_ruangan'] ?: '-') ?></td></tr>
    <tr><td><b>Gedung:</b></td><td><?= esc($kelas['nama_gedung'] ?: '-') ?></td><td><b>Status:</b></td><td><?= esc($kelas['aktif']) ?></td></tr>
    <tr><td><b>Tanggal Ekspor:</b></td><td><?= date('d-m-Y H:i:s') ?></td><td></td><td></td></tr>
</table>
<table class="data">
    <tr>
        <th>No</th><th>NISN</th><th>NIPD</th><th>Nama Siswa</th><th>Jenis Kelamin</th>
        <th>Tempat Lahir</th><th>Tanggal Lahir</th><th>Agama</th><th>Alamat</th><th>No. HP</th>
    </tr>
    <?php foreach ($siswa as $i => $s): ?>
        <tr>
            <td><?= $i + 1 ?></td>
            <td style="mso-number-format:'\@'"><?= esc($s['nisn']) ?></td>
            <td style="mso-number-format:'\@'"><?= esc($s['nipd']) ?></td>
            <td><?= esc($s['nama']) ?></td>
            <td><?= esc($s['jenis_kelamin'] ?? '-') ?></td>
            <td><?= esc($s['tempat_lahir'] ?: '-') ?></td>
            <td><?= tgl_valid($s['tanggal_lahir']) ? tgl_view($s['tanggal_lahir']) : '-' ?></td>
            <td><?= esc($s['nama_agama'] ?? '-') ?></td>
            <td><?= esc($s['alamat'] ?: '-') ?></td>
            <td style="mso-number-format:'\@'"><?= esc($s['hp'] ?: '-') ?></td>
        </tr>
    <?php endforeach ?>
    <tr><td colspan="9"><b>Jumlah Siswa:</b></td><td><b><?= count($siswa) ?> Orang</b></td></tr>
</table>
<br><br>
<table width="100%">
    <tr>
        <td width="60%"></td>
        <td style="text-align:center">Mengetahui,<br>Kepala Sekolah<br><br><br><br><u><?= esc($sekolah->kepalaNama) ?></u><br>NIP. <?= esc($sekolah->kepalaNip) ?></td>
    </tr>
</table>
</body>
</html>
