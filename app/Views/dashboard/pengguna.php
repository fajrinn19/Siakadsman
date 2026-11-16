<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="col-lg-3 col-md-4">
    <div class="kartu-ringkasan">
        <h3><?= $guru ? 'Ringkasan Mengajar' : 'Ringkasan Belajar' ?></h3>
        <div style="display:flex; align-items:center">
            <span class="angka-besar"><?= count($semua) ?></span>
            <span class="label-besar">Jadwal<br>Pelajaran</span>
            <span class="ikon-bulat"><span title="Hari ini"><b style="font-size:13px"><?= count($hariIni) ?></b></span></span>
        </div>
        <div class="baris-statistik" style="margin-bottom:0">
            <?php foreach ($statistik as $label => $nilai): ?><span><b><?= number_format($nilai) ?></b> <?= esc($label) ?></span><?php endforeach ?>
        </div>
    </div>
    <?php foreach ($mini as $m): ?>
        <a href="<?= $m['url'] ? site_url($m['url']) : '#jadwalSaya' ?>" class="kartu kartu-mini">
            <span class="ikon"><i class="fa <?= esc($m['ikon']) ?>"></i></span>
            <div class="judul-kecil">Semester ini</div>
            <div class="judul"><?= esc($m['label']) ?></div>
            <div class="angka"><?= number_format($m['total']) ?></div>
            <div class="kaki"><span>Total data</span><span>Lihat <i class="fa fa-angle-right"></i></span></div>
        </a>
    <?php endforeach ?>
</div>

<div class="col-lg-9 col-md-8">
    <?= view('dashboard/_info', ['pengumuman' => $pengumuman, 'agenda' => $agenda]) ?>

    <?= view('dashboard/_jadwal_hari_ini', ['jadwal' => $hariIni]) ?>

    <div class="box" id="jadwalSaya">
        <div class="box-header">
            <h3 class="box-title"><?= $guru ? 'Jadwal Mengajar Anda' : 'Jadwal Pelajaran Kelas Anda' ?></h3>
            <form class="pull-right filter-form" method="get" action="<?= site_url('/') ?>">
                <?= form_dropdown('tahun', $tahunOpsi, $tahun, ['onchange' => 'this.form.submit()', 'aria-label' => 'Tahun akademik']) ?>
            </form>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-hover datatable">
                <thead><tr><th style="width:30px">No</th><th>Kode</th><th>Mata Pelajaran</th><th>Kelas</th><th>Guru</th><th>Hari</th><th>Jam</th><th>Ruangan</th><?php if (! $guru): ?><th></th><?php endif ?></tr></thead>
                <tbody>
                <?php foreach ($semua as $i => $r): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= esc($r['kode_pelajaran']) ?></td>
                        <td><b><?= esc($r['namamatapelajaran']) ?></b></td>
                        <td><?= esc($r['nama_kelas']) ?></td>
                        <td><?= esc($r['nama_guru']) ?></td>
                        <td><?= esc($r['hari']) ?></td>
                        <td><?= esc(substr($r['jam_mulai'], 0, 5)) ?> - <?= esc(substr($r['jam_selesai'], 0, 5)) ?></td>
                        <td><?= esc($r['nama_ruangan']) ?></td>
                        <?php if (! $guru): ?>
                            <td><a class="btn btn-default btn-xs" href="<?= site_url('kompetensi-saya/' . $r['kodejdwl']) ?>"><i class="fa fa-tags"></i> Kompetensi</a></td>
                        <?php endif ?>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
