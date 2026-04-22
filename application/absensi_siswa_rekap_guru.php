<?php
// Cek session guru
if ($_SESSION['level'] != 'guru') {
    echo "<script>alert('Akses ditolak! Hanya untuk Guru.'); window.location='index.php';</script>";
    exit;
}

// Ambil data guru berdasarkan session
$guru = mysql_fetch_array(mysql_query("SELECT * FROM rb_guru WHERE nip='$_SESSION[id]'"));

// Ambil daftar mata pelajaran yang diampu oleh guru ini
$query_mapel = mysql_query("SELECT DISTINCT mp.kd_mapel, mp.nama_mapel, mp.kkm, 
                            jp.id_jadwal, jp.kelas, jp.semester, jp.tahun_akademik,
                            k.nama_kelas, jp.kodejdwl
                            FROM rb_matapelajaran mp 
                            JOIN rb_jadwal_pelajaran jp ON mp.kd_mapel = jp.kd_mapel
                            JOIN rb_kelas k ON jp.kelas = k.id_kelas
                            WHERE jp.nip='$_SESSION[id]' 
                            ORDER BY k.nama_kelas, mp.nama_mapel");

// Filter berdasarkan mata pelajaran jika dipilih
$selected_mapel = isset($_GET['mapel']) ? $_GET['mapel'] : '';
$selected_kelas = isset($_GET['kelas']) ? $_GET['kelas'] : '';
$selected_bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$selected_tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
$selected_semester = isset($_GET['semester']) ? $_GET['semester'] : '';

// Array nama bulan
$nama_bulan = array(1=>'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                   'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
?>

<div class="col-md-12">
    <!-- Form Filter -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Filter Rekap Absensi Per Mata Pelajaran</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        
        <div class="box-body">
            <form method="GET" action="" class="form-horizontal">
                <input type="hidden" name="view" value="rekapabsensiguru">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Mata Pelajaran</label>
                            <div class="col-sm-8">
                                <select name="mapel" id="mapel" class="form-control" required onchange="this.form.submit()">
                                    <option value="">-- Pilih Mata Pelajaran --</option>
                                    <?php 
                                    if(mysql_num_rows($query_mapel) > 0){
                                        mysql_data_seek($query_mapel, 0);
                                        while ($m = mysql_fetch_array($query_mapel)) { 
                                            $selected = ($selected_mapel == $m['kd_mapel']) ? 'selected' : '';
                                            echo "<option value='$m[kd_mapel]' data-kodejdwl='$m[kodejdwl]' $selected>$m[nama_mapel] - Kelas $m[nama_kelas] (Semester $m[semester])</option>";
                                        }
                                    } else {
                                        echo "<option value=''>Tidak ada mata pelajaran yang diampu</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Bulan</label>
                            <div class="col-sm-8">
                                <select name="bulan" class="form-control" onchange="this.form.submit()">
                                    <?php
                                    for($i=1; $i<=12; $i++) {
                                        $selected = ($selected_bulan == $i) ? 'selected' : '';
                                        echo "<option value='$i' $selected>$nama_bulan[$i]</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Tahun</label>
                            <div class="col-sm-8">
                                <select name="tahun" class="form-control" onchange="this.form.submit()">
                                    <?php
                                    for($i=date('Y')-2; $i<=date('Y')+2; $i++) {
                                        $selected = ($selected_tahun == $i) ? 'selected' : '';
                                        echo "<option value='$i' $selected>$i</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <a href="index.php?view=rekapabsensiguru" class="btn btn-default pull-right">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <?php 
    if($selected_mapel && mysql_num_rows($query_mapel) > 0): 
        // Ambil data jadwal untuk mata pelajaran yang dipilih
        $jadwal = mysql_fetch_array(mysql_query("SELECT jp.*, k.nama_kelas, mp.nama_mapel, mp.kkm, jp.kodejdwl
                                                  FROM rb_jadwal_pelajaran jp 
                                                  JOIN rb_kelas k ON jp.kelas = k.id_kelas
                                                  JOIN rb_matapelajaran mp ON jp.kd_mapel = mp.kd_mapel
                                                  WHERE jp.kd_mapel='$selected_mapel' AND jp.nip='$_SESSION[id]'"));
        
        if(!$jadwal) {
            echo "<div class='alert alert-danger'>Data jadwal tidak ditemukan!</div>";
        } else {
            // Ambil daftar siswa di kelas tersebut
            $query_siswa = mysql_query("SELECT * FROM rb_siswa 
                                        WHERE id_kelas='$jadwal[kelas]' 
                                        ORDER BY nama ASC");
            
            if(mysql_num_rows($query_siswa) == 0) {
                echo "<div class='alert alert-warning'>Tidak ada siswa di kelas ini!</div>";
            } else {
                // Hitung jumlah hari dalam bulan
                $jml_hari = cal_days_in_month(CAL_GREGORIAN, $selected_bulan, $selected_tahun);
    ?>
    
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">
                <i class="fa fa-calendar-check-o"></i> 
                Rekap Absensi - <?php echo $jadwal['nama_mapel']; ?> 
                Kelas <?php echo $jadwal['nama_kelas']; ?> 
                Semester <?php echo $jadwal['semester']; ?>
                <br><small>Bulan <?php echo $nama_bulan[$selected_bulan]; ?> <?php echo $selected_tahun; ?></small>
            </h3>
            <div class="box-tools pull-right">
                <button onclick="window.print()" class="btn btn-primary btn-sm">
                    <i class="fa fa-print"></i> Cetak
                </button>
            </div>
        </div>
        
        <div class="box-body table-responsive" style="overflow-x: auto;">
            <table class="table table-bordered table-striped table-hover" id="tabel-rekap" style="min-width: 800px;">
                <thead>
                    <tr style="background-color: #3c8dbc; color: white;">
                        <th rowspan="2" style="vertical-align: middle; width: 50px;">No</th>
                        <th rowspan="2" style="vertical-align: middle; width: 100px;">NISN</th>
                        <th rowspan="2" style="vertical-align: middle; width: 200px;">Nama Siswa</th>
                        <th colspan="<?php echo $jml_hari; ?>" class="text-center">Tanggal <?php echo $nama_bulan[$selected_bulan]; ?> <?php echo $selected_tahun; ?></th>
                        <th rowspan="2" style="vertical-align: middle; width: 60px;">Sakit</th>
                        <th rowspan="2" style="vertical-align: middle; width: 60px;">Izin</th>
                        <th rowspan="2" style="vertical-align: middle; width: 60px;">Alpha</th>
                        <th rowspan="2" style="vertical-align: middle; width: 60px;">Hadir</th>
                        <th rowspan="2" style="vertical-align: middle; width: 80px;">% Hadir</th>
                    </tr>
                    <tr style="background-color: #3c8dbc; color: white;">
                        <?php
                        for($i=1; $i<=$jml_hari; $i++) {
                            $tgl = "$selected_tahun-$selected_bulan-$i";
                            $hari = date('N', strtotime($tgl));
                            $nama_hari = '';
                            switch($hari){
                                case 1: $nama_hari = 'Sen'; break;
                                case 2: $nama_hari = 'Sel'; break;
                                case 3: $nama_hari = 'Rab'; break;
                                case 4: $nama_hari = 'Kam'; break;
                                case 5: $nama_hari = 'Jum'; break;
                                case 6: $nama_hari = 'Sab'; break;
                                case 7: $nama_hari = 'Min'; break;
                            }
                            // Abaikan hari Minggu (hari ke-7)
                            if($hari != 7) {
                                echo "<th class='text-center' style='width: 40px;'>$i<br><small>$nama_hari</small></th>";
                            } else {
                                echo "<th class='text-center bg-gray' style='width: 40px;'>$i<br><small>$nama_hari</small></th>";
                            }
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while($siswa = mysql_fetch_array($query_siswa)) {
                        $total_sakit = 0;
                        $total_izin = 0;
                        $total_alpha = 0;
                        $total_hadir = 0;
                        $total_hari_efektif = 0;
                        
                        echo "<tr>";
                        echo "<td class='text-center'>$no</td>";
                        echo "<td>$siswa[nisn]</td>";
                        echo "<td>$siswa[nama]</td>";
                        
                        // Looping untuk setiap tanggal dalam bulan
                        for($i=1; $i<=$jml_hari; $i++) {
                            $tgl = "$selected_tahun-$selected_bulan-$i";
                            $hari = date('N', strtotime($tgl));
                            
                            // Cek absensi siswa berdasarkan kodejdwl dan tanggal
                            $cek_absensi = mysql_query("SELECT * FROM rb_absensi_siswa 
                                                        WHERE nisn='$siswa[nisn]' 
                                                        AND tanggal='$tgl'
                                                        AND kodejdwl='$jadwal[kodejdwl]'");
                            $absensi = mysql_fetch_array($cek_absensi);
                            
                            if($hari != 7) {
                                $total_hari_efektif++;
                                if(mysql_num_rows($cek_absensi) > 0) {
                                    $kode_kehadiran = $absensi['kode_kehadiran'];
                                    if($kode_kehadiran == 'S') {
                                        echo "<td class='text-center' style='background-color:#ffc107;'>S</td>";
                                        $total_sakit++;
                                    } elseif($kode_kehadiran == 'I') {
                                        echo "<td class='text-center' style='background-color:#17a2b8; color:white;'>I</td>";
                                        $total_izin++;
                                    } elseif($kode_kehadiran == 'A') {
                                        echo "<td class='text-center' style='background-color:#dc3545; color:white;'>A</td>";
                                        $total_alpha++;
                                    } elseif($kode_kehadiran == 'H') {
                                        echo "<td class='text-center' style='background-color:#28a745; color:white;'>H</td>";
                                        $total_hadir++;
                                    } else {
                                        echo "<td class='text-center'>-</td>";
                                    }
                                } else {
                                    echo "<td class='text-center'>-</td>";
                                }
                            } else {
                                echo "<td class='text-center bg-gray'>Libur</td>";
                            }
                        }
                        
                        $persen_kehadiran = $total_hari_efektif > 0 ? round(($total_hadir / $total_hari_efektif) * 100, 2) : 0;
                        
                        echo "<td class='text-center'><span class='badge bg-yellow'>$total_sakit</span></td>";
                        echo "<td class='text-center'><span class='badge bg-aqua'>$total_izin</span></td>";
                        echo "<td class='text-center'><span class='badge bg-red'>$total_alpha</span></td>";
                        echo "<td class='text-center'><span class='badge bg-green'>$total_hadir</span></td>";
                        
                        // Warna untuk persentase kehadiran
                        if($persen_kehadiran >= 90) {
                            $warna_persen = 'bg-green';
                        } elseif($persen_kehadiran >= 75) {
                            $warna_persen = 'bg-yellow';
                        } else {
                            $warna_persen = 'bg-red';
                        }
                        echo "<td class='text-center'><span class='badge $warna_persen'>$persen_kehadiran%</span></td>";
                        
                        echo "</tr>";
                        $no++;
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr class="info">
                        <th colspan="3" class="text-right">Total Keseluruhan:</th>
                        <th colspan="<?php echo $jml_hari; ?>"></th>
                        <th id="total-sakit" class="text-center">0</th>
                        <th id="total-izin" class="text-center">0</th>
                        <th id="total-alpha" class="text-center">0</th>
                        <th id="total-hadir" class="text-center">0</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    
    <!-- Box Keterangan -->
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Keterangan</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-3">
                    <span class="badge bg-green">H</span> = Hadir
                </div>
                <div class="col-md-3">
                    <span class="badge bg-yellow">S</span> = Sakit
                </div>
                <div class="col-md-3">
                    <span class="badge bg-aqua">I</span> = Izin
                </div>
                <div class="col-md-3">
                    <span class="badge bg-red">A</span> = Alpha (Tanpa Keterangan)
                </div>
            </div>
            <div class="row" style="margin-top:10px;">
                <div class="col-md-3">
                    <span class="badge bg-gray">Libur</span> = Hari Libur/Minggu
                </div>
                <div class="col-md-3">
                    <span class="badge bg-default">-</span> = Belum Ada Data Absensi
                </div>
            </div>
        </div>
    </div>
    
    <script>
    // Menghitung total keseluruhan menggunakan JavaScript
    $(document).ready(function() {
        var totalSakit = 0, totalIzin = 0, totalAlpha = 0, totalHadir = 0;
        
        $('#tabel-rekap tbody tr').each(function() {
            var cols = $(this).find('td');
            // Mengambil nilai dari kolom setelah kolom tanggal (posisi bervariasi)
            var sakit = parseInt($(this).find('td:eq(' + (cols.length - 5) + ')').text()) || 0;
            var izin = parseInt($(this).find('td:eq(' + (cols.length - 4) + ')').text()) || 0;
            var alpha = parseInt($(this).find('td:eq(' + (cols.length - 3) + ')').text()) || 0;
            var hadir = parseInt($(this).find('td:eq(' + (cols.length - 2) + ')').text()) || 0;
            
            totalSakit += sakit;
            totalIzin += izin;
            totalAlpha += alpha;
            totalHadir += hadir;
        });
        
        $('#total-sakit').text(totalSakit);
        $('#total-izin').text(totalIzin);
        $('#total-alpha').text(totalAlpha);
        $('#total-hadir').text(totalHadir);
    });
    </script>
    
    <?php 
            }
        }
    elseif($selected_mapel && mysql_num_rows($query_mapel) == 0):
    ?>
    <div class="alert alert-warning">
        <i class="fa fa-warning"></i> Anda tidak mengampu mata pelajaran apapun. Silakan hubungi administrator.
    </div>
    <?php 
    elseif(!$selected_mapel):
    ?>
    <div class="alert alert-info">
        <i class="fa fa-info-circle"></i> Silakan pilih mata pelajaran terlebih dahulu untuk melihat rekap absensi.
    </div>
    <?php endif; ?>
</div>

<style>
    @media print {
        .btn, .box-tools, form, .main-header, .main-sidebar, .content-header, .box-primary, .box-info {
            display: none !important;
        }
        .content-wrapper {
            margin-left: 0 !important;
        }
        .box {
            border: none !important;
        }
        .bg-gray {
            background-color: #f0f0f0 !important;
        }
        .box-success {
            margin-top: 0 !important;
        }
        table {
            font-size: 10px !important;
        }
        th, td {
            padding: 2px !important;
        }
    }
    
    .badge {
        font-size: 12px;
        padding: 3px 6px;
    }
    
    .bg-green {
        background-color: #28a745 !important;
        color: white !important;
    }
    
    .bg-yellow {
        background-color: #ffc107 !important;
        color: #000 !important;
    }
    
    .bg-aqua {
        background-color: #17a2b8 !important;
        color: white !important;
    }
    
    .bg-red {
        background-color: #dc3545 !important;
        color: white !important;
    }
    
    .bg-gray {
        background-color: #6c757d !important;
        color: white !important;
    }
    
    table.table-bordered th,
    table.table-bordered td {
        border: 1px solid #ddd;
    }
    
    table.table-striped tbody tr:nth-child(odd) {
        background-color: #f9f9f9;
    }
    
    table.table-hover tbody tr:hover {
        background-color: #f5f5f5;
    }
    
    .table-responsive {
        overflow-x: auto;
    }
</style>