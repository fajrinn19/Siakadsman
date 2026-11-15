<?php /** Tabel keterangan KKM & rentang predikat. @var list<array> $predikat */ ?>
<center>
    <table width="90%" border="1" class="garis">
        <tr><th rowspan="2">KKM</th><th colspan="<?= max(1, count($predikat)) ?>">Predikat</th></tr>
        <tr><?php foreach ($predikat as $p): ?><th><?= esc($p['grade']) ?> = <?= esc($p['keterangan']) ?></th><?php endforeach ?></tr>
        <tr><th><?= (int) $sekolah->kkm ?></th><?php foreach ($predikat as $p): ?><th><?= (int) $p['nilai_a'] ?> - <?= (int) $p['nilai_b'] ?></th><?php endforeach ?></tr>
    </table>
</center>
