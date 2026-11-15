<?php
/** Kartu tabel jadwal hari ini. @var list<array> $jadwal */
$chip = ['berlangsung' => ['chip-aktif', 'Berlangsung'], 'akan' => ['chip-tunggu', 'Akan datang'], 'selesai' => ['chip-redup', 'Selesai']];
?>
<div class="box">
    <div class="box-header">
        <h3 class="box-title">Jadwal Hari Ini <small class="text-muted" style="font-size:12px; font-weight:500">&middot; <?= hari_ini() ?>, <?= tgl_raport(date('Y-m-d')) ?></small></h3>
        <?php if (! empty($tautanSemua)): ?><a class="btn btn-default btn-sm pull-right" href="<?= esc($tautanSemua, 'attr') ?>"><i class="fa fa-calendar"></i> Semua Jadwal</a><?php endif ?>
    </div>
    <div class="box-body table-responsive">
        <table class="table table-hover" style="margin-bottom:0">
            <thead><tr><th style="width:44px">No</th><th>Mata Pelajaran</th><th>Kelas</th><th>Guru</th><th>Jam</th><th>Ruangan</th><th>Status</th><th style="width:60px">Aksi</th></tr></thead>
            <tbody>
            <?php foreach ($jadwal as $i => $j): ?>
                <tr>
                    <td><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></td>
                    <td><b><?= esc($j['namamatapelajaran']) ?></b></td>
                    <td><?= esc($j['nama_kelas']) ?></td>
                    <td><?= esc($j['nama_guru']) ?></td>
                    <td><?= esc(substr($j['jam_mulai'], 0, 5)) ?> - <?= esc(substr($j['jam_selesai'], 0, 5)) ?></td>
                    <td><?= esc($j['nama_ruangan']) ?></td>
                    <td><span class="chip <?= $chip[$j['status']][0] ?>"><?= $chip[$j['status']][1] ?></span></td>
                    <td class="text-center">
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle text-muted" data-toggle="dropdown" title="Aksi"><i class="fa fa-ellipsis-v fa-lg"></i></a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <?php if (level() === 'siswa'): ?>
                                    <li><a href="<?= site_url('bahan-tugas/' . $j['kodejdwl']) ?>"><i class="fa fa-files-o"></i> Bahan &amp; Tugas</a></li>
                                    <li><a href="<?= site_url('quiz/' . $j['kodejdwl']) ?>"><i class="fa fa-pencil-square-o"></i> Quiz</a></li>
                                    <li><a href="<?= site_url('kompetensi-saya/' . $j['kodejdwl']) ?>"><i class="fa fa-tags"></i> Kompetensi Dasar</a></li>
                                <?php else: ?>
                                    <li><a href="<?= site_url('absensi-siswa/' . $j['kodejdwl']) ?>"><i class="fa fa-check-square-o"></i> Absensi Siswa</a></li>
                                    <li><a href="<?= site_url('journal/' . $j['kodejdwl']) ?>"><i class="fa fa-list"></i> Journal KBM</a></li>
                                    <li><a href="<?= site_url('bahan-tugas/' . $j['kodejdwl']) ?>"><i class="fa fa-files-o"></i> Bahan &amp; Tugas</a></li>
                                <?php endif ?>
                                <li><a href="<?= site_url('forum/' . $j['kodejdwl']) ?>"><i class="fa fa-comments-o"></i> Forum</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            <?php endforeach ?>
            <?php if ($jadwal === []): ?>
                <tr><td colspan="8" class="text-center text-muted" style="padding:30px">Tidak ada jadwal pelajaran hari ini.</td></tr>
            <?php endif ?>
            </tbody>
        </table>
    </div>
</div>
