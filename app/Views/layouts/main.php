<?php $p = profil_pengguna(); $sekolah = config('Sekolah'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= esc($judul ?? 'Dashboard') ?> | Sistem Informasi Akademik</title>
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <?= csrf_meta() ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="<?= base_url('bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="<?= base_url('plugins/datatables/dataTables.bootstrap.css') ?>">
    <link rel="stylesheet" href="<?= base_url('plugins/datepicker/datepicker3.css') ?>">
    <link rel="stylesheet" href="<?= base_url('dist/css/AdminLTE.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('dist/css/siakad.css') ?>">
    <link rel="stylesheet" href="<?= base_url('dist/css/tema.css') ?>">
    <script src="<?= base_url('plugins/jQuery/jQuery-2.1.4.min.js') ?>"></script>
</head>
<body class="hold-transition skin-siakad sidebar-mini fixed">
<div class="wrapper">
    <header class="main-header">
        <?= view('partials/header', ['p' => $p, 'sekolah' => $sekolah]) ?>
    </header>

    <aside class="main-sidebar">
        <?= view('partials/sidebar', ['p' => $p]) ?>
    </aside>

    <div class="content-wrapper">
        <section class="content-header">
            <h1><?= esc($judul ?? 'Dashboard') ?> <?php if (! empty($subjudul)): ?><small><?= esc($subjudul) ?></small><?php endif ?></h1>
        </section>

        <section class="content">
            <?php if ($pesan = session('sukses')): ?>
                <div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><?= esc($pesan) ?></div>
            <?php endif ?>
            <?php if ($pesan = session('error')): ?>
                <div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><?= esc($pesan) ?></div>
            <?php endif ?>
            <?php if ($errors = session('errors')): ?>
                <div class="alert alert-danger"><ul style="margin:0"><?php foreach ((array) $errors as $e): ?><li><?= esc($e) ?></li><?php endforeach ?></ul></div>
            <?php endif ?>

            <div class="row">
                <?= $this->renderSection('content') ?>
            </div>
        </section>
    </div>

    <footer class="main-footer no-print">
        <span class="pull-right hidden-xs"><?= hari_ini() ?>, <?= tgl_raport(date('Y-m-d')) ?></span>
        <strong>Sistem Informasi Akademik <?= esc($sekolah->nama) ?></strong>
    </footer>
</div>

<script src="<?= base_url('bootstrap/js/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('plugins/datatables/dataTables.bootstrap.min.js') ?>"></script>
<script src="<?= base_url('plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
<script src="<?= base_url('plugins/slimScroll/jquery.slimscroll.min.js') ?>"></script>
<script src="<?= base_url('plugins/fastclick/fastclick.min.js') ?>"></script>
<script src="<?= base_url('dist/js/app.min.js') ?>"></script>
<script>
    $(function () {
        $('.datatable').DataTable({ language: { search: 'Cari:', lengthMenu: 'Tampilkan _MENU_ data', info: 'Menampilkan _START_ - _END_ dari _TOTAL_ data', infoEmpty: 'Tidak ada data', zeroRecords: 'Data tidak ditemukan', paginate: { previous: 'Sebelumnya', next: 'Berikutnya' } } });
        $('.datepicker').datepicker({ autoclose: true });
    });
</script>
<script>
    // Pencarian cepat menu di topbar: ketik nama halaman, Enter untuk membuka.
    (function () {
        var $input = $('#cariMenu'), $hasil = $('#hasilCariMenu'), item = [];
        $('#menuUtama a[href]').each(function () {
            var href = $(this).attr('href');
            if (href && href !== '#') { item.push({ teks: $.trim($(this).text()), grup: $(this).data('grup') || '', href: href }); }
        });
        $input.on('input focus', function () {
            var q = $.trim(this.value).toLowerCase();
            if (!q) { $hasil.hide(); return; }
            var cocok = item.filter(function (i) { return (i.teks + ' ' + i.grup).toLowerCase().indexOf(q) !== -1; }).slice(0, 8);
            $hasil.html(cocok.length ? cocok.map(function (i, n) {
                return '<a href="' + i.href + '"' + (n === 0 ? ' class="dipilih"' : '') + '>' + $('<span>').text(i.teks).html() + (i.grup ? ' <small>' + $('<span>').text(i.grup).html() + '</small>' : '') + '</a>';
            }).join('') : '<a href="#"><small>Tidak ada menu yang cocok</small></a>').show();
        }).on('keydown', function (e) {
            if (e.key === 'Enter') { var a = $hasil.find('a.dipilih').attr('href'); if (a && a !== '#') { location.href = a; } }
            if (e.key === 'Escape') { $hasil.hide(); this.blur(); }
        });
        $(document).on('click', function (e) { if (!$(e.target).closest('.topbar-cari').length) { $hasil.hide(); } });
    })();
</script>
<?= $this->renderSection('scripts') ?>
</body>
</html>
