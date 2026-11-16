<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$totalHadir = array_sum(array_column($kehadiran, 'total'));
$bulanSingkat = array_map(static fn ($b) => nama_bulan($b, true), range(1, 12));
?>
<!-- Kolom kiri: ringkasan + kartu mini -->
<div class="col-lg-3 col-md-4">
    <div class="kartu-ringkasan">
        <h3>Ringkasan Akademik</h3>
        <div style="display:flex; align-items:center">
            <span class="angka-besar"><?= number_format($ringkas['siswa_aktif']) ?></span>
            <span class="label-besar">Siswa<br>Aktif</span>
            <span class="ikon-bulat">
                <span title="Siswa"><i class="fa fa-users"></i></span>
                <span title="Guru"><i class="fa fa-user"></i></span>
                <span title="Kelas"><i class="fa fa-building-o"></i></span>
            </span>
        </div>
        <div class="baris-statistik">
            <span><b><?= number_format($ringkas['guru']) ?></b> Guru</span>
            <span><b><?= number_format($ringkas['kelas']) ?></b> Kelas</span>
            <span><b><?= number_format($ringkas['mapel']) ?></b> Mapel</span>
        </div>
        <?php if (in_array(level(), ['superuser', 'kepala'], true)): ?>
            <form class="cari" method="get" action="<?= site_url('siswa') ?>">
                <i class="fa fa-search"></i>
                <input type="search" name="q" placeholder="Cari siswa (nama / NISN)" aria-label="Cari siswa">
            </form>
        <?php endif ?>
    </div>

    <?php foreach ($mini as $i => $m): ?>
        <a href="<?= site_url($m['url']) ?>" class="kartu kartu-mini">
            <span class="ikon"><i class="fa <?= esc($m['ikon']) ?>"></i></span>
            <div class="judul-kecil"><?= esc($m['judul']) ?></div>
            <div class="judul"><?= esc($m['label']) ?></div>
            <span class="status">Aktif</span>
            <div class="spark" id="spark<?= $i ?>" data-warna="<?= esc($m['warna'], 'attr') ?>" data-nilai="<?= esc(json_encode($m['tren']), 'attr') ?>"></div>
            <div class="angka"><?= number_format($m['total']) ?></div>
            <div class="kaki"><span>Total data</span><span><?= $m['terakhir'] !== '' && tgl_valid($m['terakhir']) ? tgl_indo($m['terakhir']) : '-' ?></span></div>
        </a>
    <?php endforeach ?>
</div>

<!-- Kolom kanan -->
<div class="col-lg-9 col-md-8">
    <div class="row">
        <div class="col-lg-6">
            <div class="box" style="min-height:200px">
                <div class="box-header">
                    <h3 class="box-title">Statistik Kehadiran</h3>
                    <a href="<?= site_url('absensi-siswa/rekap') ?>" class="tombol-titik pull-right" title="Rekap absensi"><i class="fa fa-ellipsis-h"></i></a>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-7"><div id="grafikKehadiran" style="height:150px"></div></div>
                        <div class="col-xs-5">
                            <ul class="legenda">
                                <?php foreach ($kehadiran as $k): ?>
                                    <li><span class="titik" style="background:<?= $k['warna'] ?>"></span><?= esc($k['label']) ?>
                                        <small><?= number_format($k['total']) ?> catatan</small></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="box" style="min-height:200px">
                <div class="box-header">
                    <h3 class="box-title">Porsi Kunjungan</h3>
                    <span class="pull-right text-muted" style="font-size:12px">30 hari terakhir</span>
                </div>
                <div class="box-body">
                    <div class="legenda-baris">
                        <?php foreach ($porsi as $p): ?><span><span class="titik" style="background:<?= $p['warna'] ?>"></span><?= esc($p['label']) ?></span><?php endforeach ?>
                    </div>
                    <div class="cincin-wrap">
                        <?php foreach ($porsi as $p): ?>
                            <div class="cincin-item">
                                <?= view('dashboard/_cincin', ['persen' => $p['persen'], 'warna' => $p['warna']]) ?>
                                <div class="ket"><?= number_format($p['jumlah']) ?> login</div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Grafik Kunjungan</h3>
            <form class="pull-right filter-form" method="get" action="<?= site_url('/') ?>">
                <select name="tahun_grafik" onchange="this.form.submit()" aria-label="Tahun">
                    <?php for ($t = (int) date('Y'); $t >= (int) date('Y') - 4; $t--): ?>
                        <option value="<?= $t ?>"<?= $t === $tahunGrafik ? ' selected' : '' ?>>Tahun <?= $t ?></option>
                    <?php endfor ?>
                </select>
            </form>
        </div>
        <div class="box-body">
            <div class="legenda-baris" style="margin-bottom:6px">
                <span><span class="titik" style="background:#0b5246"></span>Siswa</span>
                <span><span class="titik" style="background:#17a589"></span>Guru</span>
                <span><span class="titik" style="background:#cfe3df"></span>Admin</span>
            </div>
            <?php if (array_sum(array_merge(...array_values($grafik))) === 0): ?>
                <p class="text-muted text-center" style="padding:50px 0">Belum ada data kunjungan pada tahun <?= $tahunGrafik ?>.</p>
            <?php else: ?>
                <div id="grafikKunjungan" style="height:260px"></div>
            <?php endif ?>
        </div>
    </div>

    <?= view('dashboard/_info', ['pengumuman' => $pengumuman, 'agenda' => $agenda]) ?>

    <?= view('dashboard/_jadwal_hari_ini', ['jadwal' => $jadwal, 'tautanSemua' => site_url('jadwal-pelajaran')]) ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('plugins/highchart/js/highcharts.js') ?>"></script>
<script>
    Highcharts.setOptions({ chart: { style: { fontFamily: "'Plus Jakarta Sans', sans-serif" } }, credits: { enabled: false } });

    // Sparkline di kartu mini
    $('.spark').each(function () {
        var warna = $(this).data('warna');
        $(this).highcharts({
            chart: { type: 'areaspline', backgroundColor: null, margin: [2, 0, 2, 0] },
            title: { text: '' }, legend: { enabled: false }, tooltip: { enabled: false },
            xAxis: { visible: false }, yAxis: { visible: false, min: 0 },
            plotOptions: { series: { marker: { enabled: false }, lineWidth: 2, enableMouseTracking: false,
                fillColor: { linearGradient: [0, 0, 0, 46], stops: [[0, Highcharts.Color(warna).setOpacity(.35).get('rgba')], [1, 'rgba(255,255,255,0)']] } } },
            series: [{ data: $(this).data('nilai'), color: warna }]
        });
    });

    <?php if ($totalHadir > 0): ?>
    $('#grafikKehadiran').highcharts({
        chart: { type: 'pie', backgroundColor: null, margin: [0, 0, 0, 0] },
        title: { text: '' },
        tooltip: { pointFormat: '<b>{point.y}</b> ({point.percentage:.0f}%)' },
        plotOptions: { pie: { borderWidth: 3, borderColor: '#fff', dataLabels: { enabled: true, distance: -22, format: '{point.percentage:.0f}%', style: { fontSize: '10px', color: '#fff', textShadow: 'none', fontWeight: '600' }, filter: { property: 'percentage', operator: '>', value: 12 } } } },
        series: [{ name: 'Kehadiran', data: <?= json_encode(array_map(static fn ($k) => ['name' => $k['label'], 'y' => $k['total'], 'color' => $k['warna']], $kehadiran)) ?> }]
    });
    <?php else: ?>
    $('#grafikKehadiran').html('<p class="text-muted text-center" style="padding-top:55px">Belum ada data absensi.</p>');
    <?php endif ?>

    if ($('#grafikKunjungan').length) {
        $('#grafikKunjungan').highcharts({
            chart: { type: 'column', backgroundColor: null },
            title: { text: '' }, legend: { enabled: false },
            xAxis: { categories: <?= json_encode($bulanSingkat) ?>, lineColor: '#e8eded', tickLength: 0, labels: { style: { color: '#8a9997' } } },
            yAxis: { title: { text: '' }, allowDecimals: false, gridLineColor: '#eef2f1', labels: { style: { color: '#8a9997' } } },
            tooltip: { shared: true },
            plotOptions: { column: { stacking: 'normal', borderWidth: 0, pointPadding: .12, groupPadding: .12, borderRadius: 3 } },
            series: [
                { name: 'Admin', data: <?= json_encode($grafik['superuser']) ?>, color: '#cfe3df' },
                { name: 'Guru', data: <?= json_encode($grafik['guru']) ?>, color: '#17a589' },
                { name: 'Siswa', data: <?= json_encode($grafik['siswa']) ?>, color: '#0b5246' }
            ]
        });
    }
</script>
<?= $this->endSection() ?>
