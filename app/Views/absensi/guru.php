<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="col-xs-12">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Absensi Guru Tanggal: <b class="text-red"><?= tgl_indo($tanggal) ?></b></h3>
            <form class="pull-right filter-form" method="get" action="<?= site_url('absensi-guru') ?>">
                <?= form_dropdown('tahun', $tahunOpsi, $tahun) ?>
                <?= form_dropdown('kelas', $kelasOpsi, $kelas) ?>
                <input type="date" name="tanggal" value="<?= esc($tanggal, 'attr') ?>">
                <button type="submit" class="btn btn-success btn-sm">Lihat</button>
            </form>
        </div>
        <div class="box-body table-responsive">
            <?php if (! $lengkap): ?>
                <div class="pesan-kosong">Silakan pilih tahun akademik dan kelas terlebih dahulu...</div>
            <?php else: ?>
                <form method="post" action="<?= site_url('absensi-guru') ?>">
                    <?= csrf_field() ?>
                    <?= form_hidden(['tahun' => $tahun, 'kelas' => $kelas, 'tanggal' => $tanggal]) ?>
                    <table class="table table-bordered table-striped">
                        <thead><tr><th style="width:20px">No</th><th>Mata Pelajaran</th><th>Kelas</th><th>Guru</th><th>Hari</th><th>Mulai</th><th>Selesai</th><th>Ruangan</th><th style="width:140px">Kehadiran</th></tr></thead>
                        <tbody>
                        <?php foreach ($jadwal as $i => $r): ?>
                            <tr>
                                <td><?= $i + 1 ?></td><td><?= esc($r['namamatapelajaran']) ?></td><td><?= esc($r['nama_kelas']) ?></td><td><?= esc($r['nama_guru']) ?></td>
                                <td><?= esc($r['hari']) ?></td><td><?= esc(substr($r['jam_mulai'], 0, 5)) ?></td><td><?= esc(substr($r['jam_selesai'], 0, 5)) ?></td><td><?= esc($r['nama_ruangan']) ?></td>
                                <td><?= form_dropdown('kehadiran[' . $r['kodejdwl'] . ']', $kehadiran, $absen[$r['kodejdwl']] ?? '', ['class' => 'form-control input-sm'] + (boleh_ubah() ? [] : ['disabled' => 'disabled'])) ?></td>
                            </tr>
                        <?php endforeach ?>
                        <?php if ($jadwal === []): ?><tr><td colspan="9" class="text-center text-muted">Tidak ada jadwal untuk kelas dan tahun akademik ini.</td></tr><?php endif ?>
                        </tbody>
                    </table>
                    <?php if (boleh_ubah() && $jadwal !== []): ?>
                        <button type="submit" class="btn btn-info pull-right">Simpan Absensi</button>
                    <?php endif ?>
                </form>
            <?php endif ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
