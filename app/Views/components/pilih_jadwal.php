<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="col-xs-12">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><?= esc($judul) ?></h3>
            <form class="pull-right filter-form" method="get" action="<?= esc($url, 'attr') ?>">
                <?= form_dropdown('tahun', $tahunOpsi, $tahun) ?>
                <?php if ($pilihKelas): ?>
                    <?= form_dropdown('kelas', $kelasOpsi, $kelas) ?>
                <?php endif ?>
                <button type="submit" class="btn btn-success btn-sm">Lihat</button>
            </form>
        </div>
        <div class="box-body table-responsive">
            <?php if (! $lengkap): ?>
                <div class="pesan-kosong">Silakan pilih tahun akademik<?= $pilihKelas ? ' dan kelas' : '' ?> terlebih dahulu...</div>
            <?php else: ?>
                <table class="table table-bordered table-striped datatable">
                    <thead>
                    <tr>
                        <th style="width:20px">No</th>
                        <th>Mata Pelajaran</th>
                        <th>Kelas</th>
                        <th>Guru</th>
                        <th>Hari</th>
                        <th>Mulai</th>
                        <th>Selesai</th>
                        <th>Ruangan</th>
                        <th>Semester</th>
                        <?php foreach (array_keys($ekstra) as $label): ?><th><?= esc($label) ?></th><?php endforeach ?>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($baris as $i => $r): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= esc($r['namamatapelajaran']) ?></td>
                            <td><?= esc($r['nama_kelas']) ?></td>
                            <td><?= esc($r['nama_guru']) ?></td>
                            <td><?= esc($r['hari']) ?></td>
                            <td><?= esc(substr($r['jam_mulai'], 0, 5)) ?></td>
                            <td><?= esc(substr($r['jam_selesai'], 0, 5)) ?></td>
                            <td><?= esc($r['nama_ruangan']) ?></td>
                            <td><?= esc($r['id_tahun_akademik']) ?></td>
                            <?php foreach ($ekstra as $fn): ?><td><?= $fn($r) ?></td><?php endforeach ?>
                            <td class="aksi"><?= $aksi($r) ?></td>
                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
            <?php endif ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
