<?php /** Tabel nilai pengetahuan & keterampilan per kelompok mapel. @var list<array> $kelompok @var int $kkm */ ?>
<table class="table table-bordered table-condensed garis" width="100%" border="1" style="border-collapse:collapse">
    <tr>
        <th rowspan="2" style="width:40px">No</th>
        <th rowspan="2">Mata Pelajaran</th>
        <th rowspan="2" class="text-center" style="text-align:center">KKM</th>
        <th colspan="2" class="text-center" style="text-align:center">Pengetahuan</th>
        <th colspan="2" class="text-center" style="text-align:center">Keterampilan</th>
    </tr>
    <tr>
        <th class="text-center" style="text-align:center">Nilai</th><th class="text-center" style="text-align:center">Predikat</th>
        <th class="text-center" style="text-align:center">Nilai</th><th class="text-center" style="text-align:center">Predikat</th>
    </tr>
    <?php foreach ($kelompok as $k): ?>
        <tr><td colspan="7"><b><?= esc($k['kelompok']) ?></b></td></tr>
        <?php foreach ($k['mapel'] as $i => $m): ?>
            <tr>
                <td align="center"><?= $i + 1 ?></td>
                <td><?= esc($m['namamatapelajaran']) ?></td>
                <td align="center"><?= (int) $kkm ?></td>
                <td align="center"><?= nilai_angka($m['pengetahuan']) ?></td>
                <td align="center"><?= esc($m['predikat_pengetahuan']) ?></td>
                <td align="center"><?= nilai_angka($m['keterampilan']) ?></td>
                <td align="center"><?= esc($m['predikat_keterampilan']) ?></td>
            </tr>
        <?php endforeach ?>
    <?php endforeach ?>
</table>
