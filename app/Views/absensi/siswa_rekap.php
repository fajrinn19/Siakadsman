<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="col-md-12">
    <div class="box box-info">
        <div class="box-header with-border"><h3 class="box-title">Rekap Absensi Siswa</h3>
            <a class="btn btn-info btn-sm pull-right" href="<?= site_url('absensi-siswa/rekap/' . $jadwal['kodejdwl'] . '/bulanan') ?>"><i class="fa fa-calendar"></i> Rekap Bulanan</a></div>
        <div class="box-body">
            <?= view('components/info_jadwal', ['jadwal' => $jadwal, 'tambahan' => ['Jumlah Pertemuan' => $pertemuan . ' kali']]) ?>
            <table class="table table-bordered table-striped datatable">
                <thead><tr><th>No</th><th>NISN</th><th>Nama Siswa</th><th>Jenis Kelamin</th><th>Pertemuan</th><th>Hadir</th><th>Sakit</th><th>Izin</th><th>Alpa</th><th>% Kehadiran</th></tr></thead>
                <tbody>
                <?php foreach ($siswa as $i => $s): ?>
                    <?php $h = $hitung[$s['nisn']] ?? []; $hadir = $h['H'] ?? 0; ?>
                    <tr>
                        <td><?= $i + 1 ?></td><td><?= esc($s['nisn']) ?></td><td><?= esc($s['nama']) ?></td><td><?= esc($s['jenis_kelamin']) ?></td>
                        <td class="text-center"><?= $pertemuan ?></td>
                        <td class="text-center"><?= $hadir ?></td>
                        <td class="text-center"><?= $h['S'] ?? 0 ?></td>
                        <td class="text-center"><?= $h['I'] ?? 0 ?></td>
                        <td class="text-center"><?= $h['A'] ?? 0 ?></td>
                        <td class="text-right"><?= $pertemuan > 0 ? number_format($hadir / $pertemuan * 100, 2) : '0.00' ?> %</td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
        <div class="box-footer"><a href="javascript:history.back()" class="btn btn-default">Kembali</a></div>
    </div>
</div>
<?= $this->endSection() ?>
