<?php /** Cincin persentase SVG. @var int $persen @var string $warna */ $r = 34; $k = 2 * M_PI * $r; ?>
<div class="cincin">
    <svg width="84" height="84" viewBox="0 0 84 84" role="img" aria-label="<?= (int) $persen ?> persen">
        <circle cx="42" cy="42" r="<?= $r ?>" fill="none" stroke="#eef2f1" stroke-width="7"/>
        <circle cx="42" cy="42" r="<?= $r ?>" fill="none" stroke="<?= esc($warna, 'attr') ?>" stroke-width="7" stroke-linecap="round"
                stroke-dasharray="<?= round($k * $persen / 100, 2) ?> <?= round($k, 2) ?>"/>
    </svg>
    <span class="nilai"><?= (int) $persen ?>%</span>
</div>
