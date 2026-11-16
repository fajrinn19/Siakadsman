<?php /** Kerangka halaman publik PPDB (tanpa sidebar). */ ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title><?= esc($judulHalaman) ?> | <?= esc($sekolah->nama) ?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="<?= base_url('bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url('dist/css/siakad.css') ?>">
    <link rel="stylesheet" href="<?= base_url('dist/css/tema.css') ?>">
    <style>.ppdb-header{background:var(--sidebar);color:#fff;padding:22px 0;margin-bottom:24px}.ppdb-header a{color:#cfe3df}.box{margin-bottom:20px}</style>
</head>
<body>
<div class="ppdb-header">
    <div class="container" style="display:flex;align-items:center;gap:12px;justify-content:space-between;flex-wrap:wrap">
        <div style="display:flex;align-items:center;gap:12px">
            <img src="<?= base_url('dist/img/sman14sinjai.png') ?>" alt="Logo" style="width:46px;height:46px;border-radius:50%;background:#fff;padding:3px">
            <div><b style="font-size:18px">PPDB <?= esc($sekolah->nama) ?></b><br><small style="color:#cfe3df">Pendaftaran Peserta Didik Baru <?= date('Y') ?>/<?= date('Y') + 1 ?></small></div>
        </div>
        <div><a href="<?= site_url('ppdb') ?>">Formulir</a> &nbsp;·&nbsp; <a href="<?= site_url('ppdb/status') ?>">Cek Status</a> &nbsp;·&nbsp; <a href="<?= site_url('login') ?>">Login SIAKAD</a></div>
    </div>
</div>
<div class="container">
    <?php if ($pesan = session('sukses')): ?><div class="alert alert-success"><?= esc($pesan) ?></div><?php endif ?>
    <?php if ($pesan = session('error')): ?><div class="alert alert-danger"><?= esc($pesan) ?></div><?php endif ?>
    <?php if ($errors = session('errors')): ?><div class="alert alert-danger"><ul style="margin:0"><?php foreach ((array) $errors as $e): ?><li><?= esc($e) ?></li><?php endforeach ?></ul></div><?php endif ?>
    <?= $isi ?>
    <p class="text-center text-muted" style="margin:20px 0 40px">&copy; <?= date('Y') ?> <?= esc($sekolah->nama) ?></p>
</div>
</body>
</html>
