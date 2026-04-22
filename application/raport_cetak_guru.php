<?php
// Cek session guru
if($_SESSION['level'] != 'guru' && $_SESSION['level'] != 'superuser' && $_SESSION['level'] != 'admin'){
    echo "<script>alert('Akses ditolak!'); window.location='index.php';</script>";
    exit;
}

// Pastikan koneksi menggunakan mysqli
include "../config/koneksi.php";

// Ambil data guru yang login
$query_guru = mysqli_query($koneksi, "SELECT * FROM rb_guru WHERE nip='$_SESSION[id]'");
$guru = mysqli_fetch_array($query_guru);

// Ambil tahun akademik aktif
$query_ta = mysqli_query($koneksi, "SELECT * FROM rb_tahun_akademik WHERE status='Aktif' ORDER BY id_tahun_akademik DESC");
$ta_aktif = mysqli_fetch_array($query_ta);
$tahun_aktif = $ta_aktif['id_tahun_akademik'];

// Ambil daftar semua tahun akademik
$tahun_akademik = mysqli_query($koneksi, "SELECT * FROM rb_tahun_akademik ORDER BY id_tahun_akademik DESC");

// Ambil daftar kelas yang diajar oleh guru tersebut
$kelas_diajar = mysqli_query($koneksi, "SELECT DISTINCT a.kode_kelas, b.nama_kelas, b.tingkat_kelas 
                              FROM rb_jadwal_pelajaran a 
                              JOIN rb_kelas b ON a.kode_kelas=b.kode_kelas 
                              WHERE a.nip='$guru[nip]' 
                              ORDER BY b.tingkat_kelas ASC, b.nama_kelas ASC");
?>

<div class="col-md-12">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-print"></i> Cetak Raport - Guru</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        
        <div class="box-body">
            <!-- Filter Form -->
            <form style='margin-bottom:20px' class='form-inline' action='' method='GET'>
                <input type="hidden" name='view' value='raportcetakguru'>
                <div class="form-group">
                    <label>Tahun Akademik:</label>
                    <select name='tahun' class="form-control" style='margin-left:5px'>
                        <option value=''>- Pilih Tahun Akademik -</option>
                        <?php 
                        $tahun = mysqli_query($koneksi, "SELECT * FROM rb_tahun_akademik ORDER BY id_tahun_akademik DESC");
                        while ($k = mysqli_fetch_array($tahun)){
                            $selected = ($_GET['tahun'] == $k['id_tahun_akademik']) ? 'selected' : '';
                            echo "<option value='$k[id_tahun_akademik]' $selected>$k[nama_tahun]</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label style='margin-left:10px'>Filter Kelas:</label>
                    <select name='id' class="form-control" style='margin-left:5px'>
                        <option value=''>- Pilih Kelas -</option>
                        <?php 
                        $kelas_filter = mysqli_query($koneksi, "SELECT * FROM rb_kelas ORDER BY tingkat_kelas ASC, nama_kelas ASC");
                        while ($k = mysqli_fetch_array($kelas_filter)){
                            $selected = ($_GET['id'] == $k['kode_kelas']) ? 'selected' : '';
                            echo "<option value='$k[kode_kelas]' $selected>$k[kode_kelas] - $k[nama_kelas]</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-success btn-sm" style='margin-left:10px'><i class="fa fa-search"></i> Lihat</button>
            </form>

            <!-- Tabel Daftar Siswa -->
            <div class="box-body table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIPD</th>
                            <th>NISN</th>
                            <th>Nama Siswa</th>
                            <th>Jenis Kelamin</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $data_ada = false;
                    if(isset($_GET['id']) && isset($_GET['tahun']) && $_GET['id'] != '' && $_GET['tahun'] != ''){
                        $tampil = mysqli_query($koneksi, "SELECT a.*, b.jenis_kelamin 
                                                          FROM rb_siswa a
                                                          JOIN rb_jenis_kelamin b ON a.id_jenis_kelamin=b.id_jenis_kelamin 
                                                          WHERE a.kode_kelas='$_GET[id]' 
                                                          ORDER BY a.nama ASC");
                        
                        if(mysqli_num_rows($tampil) > 0){
                            $data_ada = true;
                            $no = 1;
                            while($r = mysqli_fetch_array($tampil)){
                                ?>
                                <tr>
                                    <td width="40px"><?php echo $no; ?></td>
                                    <td><?php echo $r['nipd']; ?></td>
                                    <td><?php echo $r['nisn']; ?></td>
                                    <td><?php echo $r['nama']; ?></td>
                                    <td><?php echo $r['jenis_kelamin']; ?></td>
                                    <td width="500px">
                                        <center>
                                            <a target='_BLANK' class='btn btn-success btn-xs' href='print_raport/print-hal.php?id=<?php echo $r['nisn']; ?>&kelas=<?php echo $r['kode_kelas']; ?>&tahun=<?php echo $_GET['tahun']; ?>'>
                                                <i class='glyphicon glyphicon-print'></i> Cover
                                            </a>
                                            <a target='_BLANK' class='btn btn-success btn-xs' href='print_raport/print-hal1.php?id=<?php echo $r['nisn']; ?>&kelas=<?php echo $r['kode_kelas']; ?>&tahun=<?php echo $_GET['tahun']; ?>'>
                                                <i class='glyphicon glyphicon-print'></i> Hal 1
                                            </a>
                                            <a target='_BLANK' class='btn btn-success btn-xs' href='print_raport/print-hal2.php?id=<?php echo $r['nisn']; ?>&kelas=<?php echo $r['kode_kelas']; ?>&tahun=<?php echo $_GET['tahun']; ?>'>
                                                <i class='glyphicon glyphicon-print'></i> Hal 2
                                            </a>
                                            <a target='_BLANK' class='btn btn-success btn-xs' href='print_raport/print-hal3.php?id=<?php echo $r['nisn']; ?>&kelas=<?php echo $r['kode_kelas']; ?>&tahun=<?php echo $_GET['tahun']; ?>'>
                                                <i class='glyphicon glyphicon-print'></i> Hal 3
                                            </a>
                                            <a target='_BLANK' class='btn btn-success btn-xs' href='print_raport/print-hal4.php?id=<?php echo $r['nisn']; ?>&kelas=<?php echo $r['kode_kelas']; ?>&tahun=<?php echo $_GET['tahun']; ?>'>
                                                <i class='glyphicon glyphicon-print'></i> Hal 4
                                            </a>
                                            <a target='_BLANK' class='btn btn-success btn-xs' href='print_raport/print-hal5.php?id=<?php echo $r['nisn']; ?>&kelas=<?php echo $r['kode_kelas']; ?>&tahun=<?php echo $_GET['tahun']; ?>'>
                                                <i class='glyphicon glyphicon-print'></i> Hal 5
                                            </a>
                                            <a target='_BLANK' class='btn btn-success btn-xs' href='print_raport/print-hal6.php?id=<?php echo $r['nisn']; ?>&kelas=<?php echo $r['kode_kelas']; ?>&tahun=<?php echo $_GET['tahun']; ?>'>
                                                <i class='glyphicon glyphicon-print'></i> Hal 6
                                            </a>
                                        </center>
                                    </td>
                                </tr>
                                <?php
                                $no++;
                            }
                        }
                    }
                    
                    // Jika tidak ada data, tampilkan baris dengan colspan yang benar
                    if(!$data_ada){
                        echo "<tr><td colspan='6' style='text-align:center; color:red'>Silahkan Memilih Tahun Akademik dan Kelas Terlebih dahulu...</td></tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(function(){
    // Hancurkan instance DataTable jika sudah ada
    if ($.fn.DataTable.isDataTable('#example1')) {
        $('#example1').DataTable().destroy();
    }
    
    // Inisialisasi DataTable
    $('#example1').DataTable({
        "pageLength": 25,
        "language": {
            "emptyTable": "Silahkan pilih Tahun Akademik dan Kelas terlebih dahulu",
            "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            "infoEmpty": "Tidak ada data",
            "search": "Cari:",
            "lengthMenu": "Tampilkan _MENU_ data per halaman",
            "zeroRecords": "Data tidak ditemukan"
        }
    });
});
</script>