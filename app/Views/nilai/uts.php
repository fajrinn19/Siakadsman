<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="col-md-12">
    <div class="box box-info">
        <div class="box-header with-border"><h3 class="box-title">Input Nilai UTS Siswa</h3>
            <a class="btn btn-default btn-sm pull-right" href="<?= site_url('nilai-uts') ?>">Kembali</a></div>
        <form method="post" action="<?= site_url('nilai-uts/' . $jadwal['kodejdwl']) ?>">
            <?= csrf_field() ?>
            <div class="box-body table-responsive">
                <?= view('components/info_jadwal', ['jadwal' => $jadwal]) ?>
                <table class="table table-condensed tabel-nilai">
                    <thead>
                    <tr><th rowspan="2" style="width:30px">No</th><th rowspan="2" style="width:100px">NISN</th><th rowspan="2">Nama Lengkap</th>
                        <th colspan="2" class="text-center">Pengetahuan</th><th colspan="2" class="text-center">Keterampilan</th></tr>
                    <tr><th class="text-center">Angka</th><th class="text-center">Predikat</th><th class="text-center">Angka</th><th class="text-center">Predikat</th></tr>
                    </thead>
                    <tbody>
                    <?php foreach ($siswa as $i => $s): ?>
                        <?php $n = $nilai[$s['nisn']] ?? null; $nama = 'uts[' . esc($s['nisn'], 'attr') . ']'; ?>
                        <tr>
                            <td><?= $i + 1 ?></td><td><?= esc($s['nisn']) ?></td><td><?= esc($s['nama']) ?></td>
                            <td class="text-center"><input type="number" step="0.01" min="0" max="100" style="width:80px" name="<?= $nama ?>[pengetahuan]" value="<?= $n ? (float) $n['angka_pengetahuan'] : '' ?>" placeholder="-"<?= boleh_ubah() ? '' : ' readonly' ?>></td>
                            <td class="text-center"><?= $n ? esc($grade($n['angka_pengetahuan'])) : '-' ?></td>
                            <td class="text-center"><input type="number" step="0.01" min="0" max="100" style="width:80px" name="<?= $nama ?>[keterampilan]" value="<?= $n ? (float) $n['angka_keterampilan'] : '' ?>" placeholder="-"<?= boleh_ubah() ? '' : ' readonly' ?>></td>
                            <td class="text-center"><?= $n ? esc($grade($n['angka_keterampilan'])) : '-' ?></td>
                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <?php if (boleh_ubah()): ?><div class="box-footer"><button type="submit" class="btn btn-info">Simpan</button></div><?php endif ?>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
