<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
$tgl  = static fn ($t) => tgl_indo($t);
$kiri = [
    'NIP' => $g['nip'], 'Nama Lengkap' => $g['nama_guru'], 'Tempat Lahir' => $g['tempat_lahir'], 'Tanggal Lahir' => $tgl($g['tanggal_lahir']),
    'Jenis Kelamin' => $g['jenis_kelamin'], 'Agama' => $g['nama_agama'], 'No HP' => $g['hp'], 'No Telpon' => $g['telepon'], 'Email' => $g['email'],
    'Alamat' => $g['alamat_jalan'], 'RT/RW' => $g['rt'] . '/' . $g['rw'], 'Dusun' => $g['nama_dusun'], 'Kelurahan' => $g['desa_kelurahan'],
    'Kecamatan' => $g['kecamatan'], 'Kode Pos' => $g['kode_pos'], 'NIK' => $g['nik'], 'NPWP' => $g['npwp'], 'Kewarganegaraan' => $g['kewarganegaraan'],
    'Nama Ibu Kandung' => $g['nama_ibu_kandung'], 'Status Nikah' => $g['status_pernikahan'], 'Nama Suami/Istri' => $g['nama_suami_istri'],
    'NIP Suami/Istri' => $g['nip_suami_istri'], 'Pekerjaan Suami/Istri' => $g['pekerjaan_suami_istri'],
];
$kanan = [
    'NUPTK' => $g['nuptk'], 'NIY / NIGK' => $g['niy_nigk'], 'Jenis PTK' => $g['jenis_ptk'], 'Status Pegawai' => $g['status_kepegawaian'],
    'Status Keaktifan' => $g['nama_status_keaktifan'], 'Golongan' => $g['nama_golongan'], 'Bidang Studi' => $g['pengawas_bidang_studi'],
    'Tugas Tambahan' => $g['tugas_tambahan'], 'SK CPNS' => $g['sk_cpns'], 'Tanggal CPNS' => $tgl($g['tanggal_cpns']),
    'SK Pengangkatan' => $g['sk_pengangkatan'], 'TMT Pengangkatan' => $tgl($g['tmt_pengangkatan']), 'Lembaga Pengangkatan' => $g['lembaga_pengangkatan'],
    'TMT PNS' => $tgl($g['tmt_pns']), 'Sumber Gaji' => $g['sumber_gaji'], 'Keahlian Laboratorium' => $g['keahlian_laboratorium'],
    'Lisensi Kepsek' => $g['lisensi_kepsek'], 'Jml Sekolah Binaan' => $g['jumlah_sekolah_binaan'], 'Diklat Kepengawasan' => $g['diklat_kepengawasan'],
    'Mampu Handle KK' => $g['mampu_handle_kk'], 'Keahlian Braille' => $g['keahlian_breile'], 'Keahlian Bahasa Isyarat' => $g['keahlian_bahasa_isyarat'],
];
?>
<div class="col-md-12">
    <div class="box box-info">
        <div class="box-header with-border"><h3 class="box-title">Detail Data Guru</h3></div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-2 text-center">
                    <img class="img-thumbnail foto-profil" src="<?= foto_guru($g['foto']) ?>" alt="Foto">
                    <?php if ($bolehEdit): ?>
                        <a href="<?= site_url('guru/edit/' . rawurlencode($g['nip'])) ?>" class="btn btn-success btn-block" style="margin-top:8px">Edit Profil</a>
                    <?php endif ?>
                </div>
                <?php foreach ([$kiri, $kanan] as $kolom): ?>
                    <div class="col-md-5">
                        <table class="table table-condensed table-bordered tabel-info"><tbody>
                        <?php foreach ($kolom as $label => $nilai): ?>
                            <tr><th scope="row"><?= esc($label) ?></th><td><?= esc((string) $nilai) ?></td></tr>
                        <?php endforeach ?>
                        </tbody></table>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
        <div class="box-footer"><a href="javascript:history.back()" class="btn btn-default pull-right">Kembali</a></div>
    </div>
</div>
<?= $this->endSection() ?>
