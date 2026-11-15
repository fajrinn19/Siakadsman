<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="col-xs-12">
    <div class="box">
        <div class="box-header"><h3 class="box-title"><?= esc($judul) ?></h3>
            <?= view('raport/_filter', ['segmen' => 'raport/capaian', 'tahunOpsi' => $tahunOpsi, 'kelasOpsi' => $kelasOpsi, 'tahun' => $tahun, 'kelas' => $kelas]) ?></div>
        <div class="box-body table-responsive">
            <?php if (! $lengkap): ?>
                <div class="pesan-kosong">Silakan pilih tahun akademik dan kelas terlebih dahulu...</div>
            <?php else: ?>
                <form method="post" action="<?= site_url('raport/capaian') ?>">
                    <?= csrf_field() ?>
                    <?= form_hidden(['tahun' => $tahun, 'kelas' => $kelas]) ?>
                    <table class="table table-bordered table-condensed">
                        <thead>
                        <tr><th rowspan="2">No</th><th rowspan="2">NISN</th><th rowspan="2">Nama Siswa</th><th colspan="2" class="text-center">Sikap Spiritual</th><th colspan="2" class="text-center">Sikap Sosial</th></tr>
                        <tr><th class="text-center">Predikat</th><th class="text-center">Deskripsi</th><th class="text-center">Predikat</th><th class="text-center">Deskripsi</th></tr>
                        </thead>
                        <tbody>
                        <?php foreach ($siswa as $i => $s): ?>
                            <?php $n = $nilai[$s['nisn']] ?? []; $nama = 'capaian[' . esc($s['nisn'], 'attr') . ']'; ?>
                            <tr>
                                <td><?= $i + 1 ?></td><td><?= esc($s['nisn']) ?></td><td><?= esc($s['nama']) . label_mantan($s) ?></td>
                                <td class="text-center"><input type="text" maxlength="2" style="width:60px; text-align:center" name="<?= $nama ?>[spiritual_predikat]" value="<?= esc($n['spiritual_predikat'] ?? '', 'attr') ?>"></td>
                                <td><textarea class="form-control" rows="2" name="<?= $nama ?>[spiritual_deskripsi]" placeholder="Tuliskan deskripsi..."><?= esc($n['spiritual_deskripsi'] ?? '') ?></textarea></td>
                                <td class="text-center"><input type="text" maxlength="2" style="width:60px; text-align:center" name="<?= $nama ?>[sosial_predikat]" value="<?= esc($n['sosial_predikat'] ?? '', 'attr') ?>"></td>
                                <td><textarea class="form-control" rows="2" name="<?= $nama ?>[sosial_deskripsi]" placeholder="Tuliskan deskripsi..."><?= esc($n['sosial_deskripsi'] ?? '') ?></textarea></td>
                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                    <?php if (boleh_ubah() && $siswa !== []): ?><button type="submit" class="btn btn-info">Simpan</button><?php endif ?>
                </form>
            <?php endif ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
