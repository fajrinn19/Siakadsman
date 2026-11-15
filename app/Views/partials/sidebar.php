<?php
$sekarang = trim(uri_string(), '/');
$aktif    = static function (string $url) use ($sekarang): bool {
    $url = trim($url, '/');

    return $url === '' ? $sekarang === '' : ($sekarang === $url || str_starts_with($sekarang, $url . '/'));
};
?>
<section class="sidebar">
    <ul class="sidebar-menu" id="menuUtama">
        <?php foreach (config('Menu')->untuk(level()) as $item): ?>
            <?php if (isset($item['children'])): ?>
                <?php $buka = array_filter($item['children'], static fn ($c) => $aktif($c['url'])) !== []; ?>
                <li class="treeview<?= $buka ? ' active' : '' ?>">
                    <a href="#"><i class="fa <?= esc($item['icon'], 'attr') ?>"></i> <span><?= esc($item['label']) ?></span><i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <?php foreach ($item['children'] as $c): ?>
                            <li class="<?= $aktif($c['url']) ? 'active' : '' ?>"><a href="<?= site_url($c['url']) ?>" data-grup="<?= esc($item['label'], 'attr') ?>"><i class="fa fa-circle"></i> <?= esc($c['label']) ?></a></li>
                        <?php endforeach ?>
                    </ul>
                </li>
            <?php else: ?>
                <li class="<?= $aktif($item['url']) ? 'active' : '' ?>"><a href="<?= site_url($item['url']) ?>"><i class="fa <?= esc($item['icon'], 'attr') ?>"></i> <span><?= esc($item['label']) ?></span></a></li>
            <?php endif ?>
        <?php endforeach ?>
        <li class="pemisah"></li>
        <li class="<?= $aktif('profil') ? 'active' : '' ?>"><a href="<?= site_url('profil') ?>"><i class="fa fa-cog"></i> <span>Profil Saya</span></a></li>
        <li><a href="<?= site_url('logout') ?>"><i class="fa fa-sign-out"></i> <span>Logout</span></a></li>
    </ul>
</section>
