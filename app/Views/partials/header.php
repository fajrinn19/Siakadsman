<a href="<?= site_url('/') ?>" class="logo">
    <span class="logo-mini"><span class="logo-ikon"><i class="fa fa-graduation-cap"></i></span></span>
    <span class="logo-lg"><span class="logo-ikon"><i class="fa fa-graduation-cap"></i></span>SIAKAD</span>
</a>
<nav class="navbar navbar-static-top" role="navigation">
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"><span class="sr-only">Buka/tutup menu</span></a>

    <a href="<?= esc($p['profil'], 'attr') ?>" class="topbar-pengguna" title="Profil saya">
        <img src="<?= esc($p['foto'], 'attr') ?>" alt="Foto">
        <span class="nama"><?= esc($p['nama']) ?><span class="peran"><?= esc($p['label']) ?> &middot; <?= esc($sekolah->namaPendek) ?></span></span>
    </a>

    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <li class="topbar-cari">
                <i class="fa fa-search"></i>
                <input type="search" id="cariMenu" placeholder="Cari menu..." autocomplete="off" aria-label="Cari menu">
                <div class="hasil-cari" id="hasilCariMenu"></div>
            </li>
            <li><a href="<?= site_url('forum') ?>" title="Forum diskusi"><i class="fa fa-bell-o fa-lg"></i></a></li>
            <li><a href="<?= esc($p['profil'], 'attr') ?>" title="Pengaturan profil"><i class="fa fa-cog fa-lg"></i></a></li>
        </ul>
    </div>
</nav>
