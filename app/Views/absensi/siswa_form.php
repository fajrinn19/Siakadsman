<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="col-md-12">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Absensi Siswa Tanggal: <b class="text-red"><?= tgl_indo($tanggal) ?></b> (<?= hari_ini($tanggal) ?>)</h3>
            <form class="pull-right filter-form" method="get" action="<?= site_url('absensi-siswa/' . $jadwal['kodejdwl']) ?>">
                <input type="date" name="tanggal" value="<?= esc($tanggal, 'attr') ?>">
                <button type="submit" class="btn btn-primary btn-sm">Lihat Absen</button>
            </form>
        </div>
        <div class="box-body">
            <?= view('components/info_jadwal', ['jadwal' => $jadwal, 'tambahan' => ['Hari / Jam' => $jadwal['hari'] . ', ' . substr($jadwal['jam_mulai'], 0, 5) . ' - ' . substr($jadwal['jam_selesai'], 0, 5)]]) ?>
            <form method="post" action="<?= site_url('absensi-siswa/' . $jadwal['kodejdwl']) ?>">
                <?= csrf_field() ?>
                <input type="hidden" name="tanggal" value="<?= esc($tanggal, 'attr') ?>">
                <p>
                    <span class="label absen-belum" style="color:#333">&nbsp;Merah&nbsp;</span> = belum diisi,
                    <span class="label absen-sudah" style="color:#333">&nbsp;Hijau&nbsp;</span> = sudah diisi.
                    <?php if (boleh_ubah()): ?>
                        <button type="button" class="btn btn-default btn-xs" id="semuaHadir">Tandai semua Hadir</button>
                    <?php endif ?>
                </p>
                <table class="table table-bordered table-condensed">
                    <thead><tr><th>No</th><th>NIPD</th><th>NISN</th><th>Nama Siswa</th><th>Jenis Kelamin</th><th style="width:150px">Kehadiran</th></tr></thead>
                    <tbody>
                    <?php foreach ($siswa as $i => $s): ?>
                        <?php $kode = $absen[$s['nisn']] ?? ''; ?>
                        <tr class="<?= $kode === '' ? 'absen-belum' : 'absen-sudah' ?>">
                            <td><?= $i + 1 ?></td><td><?= esc($s['nipd']) ?></td><td><?= esc($s['nisn']) ?></td>
                            <td><?= esc($s['nama']) ?></td><td><?= esc($s['jenis_kelamin']) ?></td>
                            <td><?= form_dropdown('kehadiran[' . $s['nisn'] . ']', $kehadiran, $kode, ['class' => 'form-control input-sm status-absen'] + (boleh_ubah() ? [] : ['disabled' => 'disabled'])) ?></td>
                        </tr>
                    <?php endforeach ?>
                    <?php if ($siswa === []): ?><tr><td colspan="6" class="text-center text-muted">Belum ada siswa di kelas ini.</td></tr><?php endif ?>
                    </tbody>
                </table>
                <div class="box-footer">
                    <a href="javascript:history.back()" class="btn btn-default">Kembali</a>
                    <?php if (boleh_ubah() && $siswa !== []): ?>
                        <button type="submit" class="btn btn-info pull-right">Simpan Absensi</button>
                    <?php endif ?>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
    $('.status-absen').on('change', function () {
        $(this).closest('tr').toggleClass('absen-belum', this.value === '').toggleClass('absen-sudah', this.value !== '');
    });
    $('#semuaHadir').on('click', function () { $('.status-absen').val('H').trigger('change'); });
</script>
<?= $this->endSection() ?>
