<?php /** Blok tanda tangan: orang tua, kepala sekolah, wali kelas. @var \Config\Sekolah $sekolah @var array|null $wali */ ?>
<table width="100%" class="ttd" style="margin-top:20px">
    <tr>
        <td width="30%"><?= ! empty($tanpaOrtu) ? '' : 'Orang Tua / Wali' ?></td>
        <td width="40%" style="text-align:center">Mengetahui<br>Kepala <?= esc($sekolah->nama) ?></td>
        <td width="30%"><?= esc($sekolah->kota) ?>, <?= tgl_raport(date('Y-m-d')) ?><br>Wali Kelas</td>
    </tr>
    <tr>
        <td><br><br><br><br><?= ! empty($tanpaOrtu) ? '' : '...................................' ?></td>
        <td style="text-align:center"><br><br><br><br><b><?= esc(kepala_sekolah()['nama']) ?><br>NIP: <?= esc(kepala_sekolah()['nip']) ?></b></td>
        <td><br><br><br><br><b><?= esc($wali['nama'] ?? '...................................') ?><br>NIP: <?= esc($wali['nip'] ?? '') ?></b></td>
    </tr>
</table>
