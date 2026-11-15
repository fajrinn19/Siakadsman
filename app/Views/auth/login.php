<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Masuk | SIAKAD <?= esc($sekolah->namaPendek) ?></title>
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="<?= base_url('bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url('dist/css/siakad.css') ?>">
    <link rel="stylesheet" href="<?= base_url('dist/css/tema.css') ?>">
</head>
<body>
<div class="login-siakad">
    <div class="panel-kiri">
        <div class="merek">
            <img src="<?= base_url('dist/img/sman14sinjai.png') ?>" alt="Logo sekolah">
            <span>SIAKAD<br><small style="font-weight:500; color:var(--sidebar-teks); font-size:13px"><?= esc($sekolah->nama) ?></small></span>
        </div>
        <div>
            <h1>Sistem Informasi <span>Akademik</span> dalam satu tempat.</h1>
            <p>Absensi, jurnal mengajar, bahan &amp; tugas, ujian online, hingga cetak raport untuk admin, kepala sekolah, guru, dan siswa.</p>
        </div>
        <small style="color:var(--sidebar-teks)">&copy; <?= date('Y') ?> <?= esc($sekolah->nama) ?></small>
    </div>

    <div class="panel-kanan">
        <div class="kartu-login">
            <h2>Selamat datang 👋</h2>
            <p class="sub">Masuk dengan username, NIP (guru), atau NISN (siswa).</p>

            <?php if ($pesan = session('error')): ?>
                <div class="alert alert-danger"><?= esc($pesan) ?></div>
            <?php elseif ($pesan = session('sukses')): ?>
                <div class="alert alert-success"><?= esc($pesan) ?></div>
            <?php endif ?>

            <?php if ($diblokir): ?>
                <div class="blocked-notice">
                    <i class="fa fa-lock" style="font-size: 30px;"></i>
                    <h4><strong>AKSES DIBLOKIR SEMENTARA</strong></h4>
                    <p>Anda telah melebihi batas percobaan login. Silakan coba lagi dalam:</p>
                    <div class="timer" id="countdownTimer" data-detik="<?= (int) $sisaDetik ?>"></div>
                    <small>Halaman akan dimuat ulang otomatis setelah waktu habis.</small>
                </div>
            <?php else: ?>
                <?php if ($percobaan > 0): ?>
                    <div class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> Sisa percobaan login: <b><?= (int) $sisaCoba ?></b> kali lagi</div>
                <?php endif ?>

                <form action="<?= site_url('login') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="username">Username / NIP / NISN</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?= esc(old('username')) ?>" required autofocus autocomplete="username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required autocomplete="current-password">
                    </div>
                    <div class="form-group">
                        <label for="captcha">Kode Verifikasi</label>
                        <div class="captcha-box">
                            <span id="captchaKode"><?= esc($captcha) ?></span>
                            <span class="refresh-captcha" id="refreshCaptcha" title="Ganti kode" role="button" aria-label="Ganti kode"><i class="fa fa-refresh"></i></span>
                        </div>
                        <input type="text" class="form-control" id="captcha" name="captcha" placeholder="Ketik kode di atas" required maxlength="6" autocomplete="off">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Masuk</button>
                </form>
            <?php endif ?>
        </div>
    </div>
</div>

<script src="<?= base_url('plugins/jQuery/jQuery-2.1.4.min.js') ?>"></script>
<script>
    $('#refreshCaptcha').on('click', function () {
        $.get('<?= site_url('login/captcha') ?>', function (kode) { $('#captchaKode').text(kode); });
    });
    (function () {
        var el = document.getElementById('countdownTimer');
        if (!el) { return; }
        var sisa = parseInt(el.getAttribute('data-detik'), 10);
        (function tick() {
            if (sisa <= 0) { location.reload(); return; }
            el.textContent = Math.floor(sisa / 60) + ' menit ' + (sisa % 60) + ' detik';
            sisa--;
            setTimeout(tick, 1000);
        })();
    })();
</script>
</body>
</html>
