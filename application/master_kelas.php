<?php 
// Proses Export ke Excel (LANGSUNG DOWNLOAD) - DITARUH DI PALING ATAS
if (isset($_GET['export_excel']) && $_GET['export_excel'] != '') {
    $kode_kelas = $_GET['export_excel'];
    
    // Cek apakah kelas memiliki siswa
    $cek_siswa = mysql_query("SELECT * FROM rb_siswa WHERE kode_kelas='$kode_kelas'");
    $cek_siswa_count = mysql_num_rows($cek_siswa);
    
    if($cek_siswa_count == 0){
        echo "<script>alert('Kelas tidak memiliki siswa, tidak ada data untuk diekspor!'); window.location='index.php?view=kelas';</script>";
        exit;
    }
    
    // Ambil data kelas
    $data_kelas = mysql_fetch_array(mysql_query("SELECT a.*, b.nama_guru, c.nama_jurusan, d.nama_ruangan, e.nama_gedung 
                                                  FROM rb_kelas a 
                                                  LEFT JOIN rb_guru b ON a.nip=b.nip 
                                                  LEFT JOIN rb_jurusan c ON a.kode_jurusan=c.kode_jurusan 
                                                  LEFT JOIN rb_ruangan d ON a.kode_ruangan=d.kode_ruangan 
                                                  LEFT JOIN rb_gedung e ON d.kode_gedung=e.kode_gedung 
                                                  WHERE a.kode_kelas='$kode_kelas'"));
    
    // Header untuk force download Excel
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=Daftar_Siswa_Kelas_" . $data_kelas['nama_kelas'] . "_" . date('Ymd_His') . ".xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    
    // Output konten Excel
    echo "<html>
          <head>
          <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
          <title>Daftar Siswa Kelas " . $data_kelas['nama_kelas'] . "</title>
          <style>
              th { background-color: #4CAF50; color: white; font-weight: bold; }
              .header-title { font-size: 18pt; font-weight: bold; text-align: center; margin-bottom: 10px; }
              .subtitle { font-size: 14pt; text-align: center; margin-bottom: 5px; }
              .info-kelas { margin: 10px 0; font-size: 11pt; border: 1px solid #ddd; padding: 10px; background-color: #f9f9f9; }
              table { border-collapse: collapse; width: 100%; margin-top: 20px; }
              th, td { border: 1px solid #000; padding: 8px; text-align: left; }
              .text-center { text-align: center; }
          </style>
          </head>
          <body>";
    
    echo "<div class='header-title'>DAFTAR SISWA</div>";
    echo "<div class='subtitle'>Kelas " . $data_kelas['nama_kelas'] . "</div>";
    
    echo "<div class='info-kelas'>
          <table width='100%' style='border: none; margin-top: 0;'>
              <tr style='border: none;'>
                  <td style='border: none; width: 20%;'><strong>Kode Kelas:</strong></td>
                  <td style='border: none; width: 30%;'>" . $data_kelas['kode_kelas'] . "</td>
                  <td style='border: none; width: 20%;'><strong>Wali Kelas:</strong></td>
                  <td style='border: none; width: 30%;'>" . ($data_kelas['nama_guru'] ? $data_kelas['nama_guru'] : '-') . "</td>
              </tr>
              <tr style='border: none;'>
                  <td style='border: none;'><strong>Jurusan:</strong></td>
                  <td style='border: none;'>" . ($data_kelas['nama_jurusan'] ? $data_kelas['nama_jurusan'] : '-') . "</td>
                  <td style='border: none;'><strong>Ruangan:</strong></td>
                  <td style='border: none;'>" . ($data_kelas['nama_ruangan'] ? $data_kelas['nama_ruangan'] : '-') . "</td>
              </tr>
              <tr style='border: none;'>
                  <td style='border: none;'><strong>Gedung:</strong></td>
                  <td style='border: none;'>" . ($data_kelas['nama_gedung'] ? $data_kelas['nama_gedung'] : '-') . "</td>
                  <td style='border: none;'><strong>Status:</strong></td>
                  <td style='border: none;'>" . $data_kelas['aktif'] . "</td>
              </tr>
              <tr style='border: none;'>
                  <td style='border: none;'><strong>Tahun Ajaran:</strong></td>
                  <td style='border: none;'>" . date('Y') . "</td>
                  <td style='border: none;'><strong>Tanggal Ekspor:</strong></td>
                  <td style='border: none;'>" . date('d-m-Y H:i:s') . "</td>
              </tr>
          </table>
          </div>";
    
    echo "<table>
          <thead>
               <tr>
                  <th class='text-center' width='40'>No</th>
                  <th>NISN</th>
                  <th>NIS</th>
                  <th>Nama Siswa</th>
                  <th>Jenis Kelamin</th>
                  <th>Tempat Lahir</th>
                  <th>Tanggal Lahir</th>
                  <th>Agama</th>
                  <th>Alamat</th>
                  <th>No. Telepon</th>
               </tr>
          </thead>
          <tbody>";
    
    // Ambil data siswa
    $query_siswa = mysql_query("SELECT * FROM rb_siswa WHERE kode_kelas='$kode_kelas' ORDER BY nama ASC");
    $no = 1;
    $total_siswa = 0;
    while($siswa = mysql_fetch_array($query_siswa)) {
        // Ambil data tambahan jika ada
        $detail = mysql_fetch_array(mysql_query("SELECT * FROM rb_siswa_detail WHERE nisn='$siswa[nisn]'"));
        echo "<tr>
                  <td class='text-center'>$no</td>
                  <td>" . $siswa['nisn'] . "</td>
                  <td>" . $siswa['nis'] . "</td>
                  <td>" . $siswa['nama'] . "</td>
                  <td>" . $siswa['jenis_kelamin'] . "</td>
                  <td>" . ($detail['tempat_lahir'] ? $detail['tempat_lahir'] : '-') . "</td>
                  <td>" . ($detail['tanggal_lahir'] ? date('d-m-Y', strtotime($detail['tanggal_lahir'])) : '-') . "</td>
                  <td>" . $siswa['agama'] . "</td>
                  <td>" . ($detail['alamat'] ? $detail['alamat'] : '-') . "</td>
                  <td>" . ($detail['no_telp'] ? $detail['no_telp'] : '-') . "</td>
              </tr>";
        $no++;
        $total_siswa++;
    }
    
    echo "<tr style='background-color: #f2f2f2; font-weight: bold;'>
              <td colspan='9'><strong>Jumlah Siswa:</strong></td>
              <td><strong>" . $total_siswa . " Orang</strong></td>
           </tr>";
    
    echo "</tbody>
          </table>";
    
    echo "<br><br>
          <table width='100%' style='border: none;'>
              <tr style='border: none;'>
                  <td style='border: none; width: 60%;'> </td>
                  <td style='border: none; text-align: center;'>
                      Mengetahui,<br>
                      Kepala Sekolah<br><br><br><br>
                      <u>(_____________________)</u><br>
                      NIP. ________________
                  </td>
              </tr>
          </table>";
    
    echo "</body></html>";
    exit;
}

// TAMPILAN DATA KELAS
if ($_GET[act]==''){ 
?>
<div class="col-xs-12">  
  <div class="box">
    <div class="box-header">
      <a class="btn btn-warning btn-sm">Data Kelas</a>
      <?php if($_SESSION[level]!='kepala'){ ?>
      <a class='pull-right btn btn-primary btn-sm' href='index.php?view=kelas&act=tambah'>Tambahkan Data</a>
      <?php } ?>
    </div><!-- /.box-header -->
    <div class="box-body">
      <table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th style='width:40px'>No</th>
            <th>Kode Kelas</th>
            <th>Nama Kelas</th>
            <th>Wali Kelas</th>
            <th>Jurusan</th>
            <th>Ruangan</th>
            <th>Gedung</th>
            <th>Jumlah Siswa</th>
            <?php if($_SESSION[level]!='kepala'){ ?>
            <th style='width:120px'>Action</th>
            <?php } ?>
          </tr>
        </thead>
        <tbody>
        <?php 
        $tampil = mysql_query("SELECT * FROM rb_kelas a LEFT JOIN rb_guru b ON a.nip=b.nip 
                                LEFT JOIN rb_jurusan c ON a.kode_jurusan=c.kode_jurusan 
                                LEFT JOIN rb_ruangan d ON a.kode_ruangan=d.kode_ruangan 
                                LEFT JOIN rb_gedung e ON d.kode_gedung=e.kode_gedung 
                                ORDER BY a.kode_kelas DESC");
        $no = 1;
        while($r=mysql_fetch_array($tampil)){
          $hitung = mysql_num_rows(mysql_query("SELECT * FROM rb_siswa where kode_kelas='$r[kode_kelas]'"));
          echo "<tr>
                    <td>$no</td>
                    <td>$r[kode_kelas]</td>
                    <td>$r[nama_kelas]</td>
                    <td>$r[nama_guru]</td>
                    <td>$r[nama_jurusan]</td>
                    <td>$r[nama_ruangan]</td>
                    <td>$r[nama_gedung]</td>
                    <td>$hitung Orang</td>";
          if($_SESSION[level]!='kepala'){
            echo "<td>
                    <center>
                      <!-- Tombol Download Excel -->
                      <a class='btn btn-success btn-xs' title='Download Excel' href='?view=kelas&export_excel=$r[kode_kelas]'>
                        <i class='fa fa-file-excel-o'></i> Excel
                      </a>
                      <!-- Tombol Edit -->
                      <a class='btn btn-primary btn-xs' title='Edit Data' href='?view=kelas&act=edit&id=$r[kode_kelas]'>
                        <span class='glyphicon glyphicon-edit'></span>
                      </a>
                      <!-- Tombol Hapus -->
                      <a class='btn btn-danger btn-xs' title='Delete Data' href='?view=kelas&hapus=$r[kode_kelas]' onclick='return confirm(\"Yakin ingin menghapus kelas $r[nama_kelas]?\")'>
                        <span class='glyphicon glyphicon-remove'></span>
                      </a>
                    </center>
                  </td>";
          }
          echo "</tr>";
          $no++;
        }
        
        // Proses hapus data
        if (isset($_GET['hapus'])){
            // Cek apakah kelas memiliki siswa
            $cek_siswa = mysql_query("SELECT * FROM rb_siswa WHERE kode_kelas='$_GET[hapus]'");
            if(mysql_num_rows($cek_siswa) > 0){
                echo "<script>alert('Kelas tidak dapat dihapus karena masih memiliki siswa!');</script>";
            } else {
                mysql_query("DELETE FROM rb_kelas WHERE kode_kelas='$_GET[hapus]'");
                echo "<script>document.location='index.php?view=kelas';</script>";
            }
        }
        ?>
        </tbody>
      </table>
    </div><!-- /.box-body -->
  </div><!-- /.box -->
</div>

<style>
.btn-xs {
    margin: 2px;
}
.fa-file-excel-o {
    color: #fff;
}
</style>

<?php 
}elseif($_GET[act]=='edit'){
    if (isset($_POST[update])){
        mysql_query("UPDATE rb_kelas SET kode_kelas = '$_POST[a]',
                                         nip = '$_POST[b]',
                                         kode_jurusan = '$_POST[c]',
                                         kode_ruangan = '$_POST[d]',
                                         nama_kelas = '$_POST[e]', 
                                         aktif = '$_POST[f]' where kode_kelas='$_POST[id]'");
        echo "<script>document.location='index.php?view=kelas';</script>";
    }
    $edit = mysql_query("SELECT * FROM rb_kelas a LEFT JOIN rb_guru b ON a.nip=b.nip 
                            LEFT JOIN rb_jurusan c ON a.kode_jurusan=c.kode_jurusan 
                            LEFT JOIN rb_ruangan d ON a.kode_ruangan=d.kode_ruangan 
                            where a.kode_kelas='$_GET[id]'");
    $s = mysql_fetch_array($edit);
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Data Kelas</h3>
                </div>
              <div class='box-body'>
              <form method='POST' class='form-horizontal' action='' enctype='multipart/form-data'>
                <div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value='$s[kode_kelas]'>
                    <tr><th width='120px' scope='row'>Kode Kelas</th>  <td><input type='text' class='form-control' name='a' value='$s[kode_kelas]'>  </td></tr>
                    <tr><th scope='row'>Wali Kelas</th>               <td><select class='form-control' name='b'> 
                                                                          <option value='0' selected>- Pilih Wali Kelas -</option>"; 
                                                                            $wali = mysql_query("SELECT * FROM rb_guru");
                                                                            while($a = mysql_fetch_array($wali)){
                                                                              if ($a[nip] == $s[nip]){
                                                                                echo "<option value='$a[nip]' selected>$a[nama_guru]</option>";
                                                                              }else{
                                                                                echo "<option value='$a[nip]'>$a[nama_guru]</option>";
                                                                              }
                                                                            }
                                                                         echo "</select></td></tr>
                    <tr><th scope='row'>Jurusan</th>                <td><select class='form-control' name='c'> 
                                                                          <option value='0' selected>- Pilih Jurusan -</option>"; 
                                                                            $jur = mysql_query("SELECT * FROM rb_jurusan");
                                                                            while($a = mysql_fetch_array($jur)){
                                                                              if ($a[kode_jurusan] == $s[kode_jurusan]){
                                                                                echo "<option value='$a[kode_jurusan]' selected>$a[nama_jurusan]</option>";
                                                                              }else{
                                                                                echo "<option value='$a[kode_jurusan]'>$a[nama_jurusan]</option>";
                                                                              }
                                                                            }
                                                                         echo "</select></td></tr>
                    <tr><th scope='row'>Ruangan</th>                <td><select class='form-control' name='d'> 
                                                                          <option value='0' selected>- Pilih Ruangan -</option>"; 
                                                                            $rua = mysql_query("SELECT * FROM rb_ruangan a JOIN rb_gedung b ON a.kode_gedung=b.kode_gedung ");
                                                                            while($a = mysql_fetch_array($rua)){
                                                                              if ($a[kode_ruangan] == $s[kode_ruangan]){
                                                                                echo "<option value='$a[kode_ruangan]' selected>$a[nama_gedung] - $a[nama_ruangan]</option>";
                                                                              }else{
                                                                                echo "<option value='$a[kode_ruangan]'>$a[nama_gedung] - $a[nama_ruangan]</option>";
                                                                              }
                                                                            }
                                                                         echo "</select></td></tr>
                    <tr><th scope='row'>Nama Kelas</th>            <td><input type='text' class='form-control' name='e' value='$s[nama_kelas]'></td></tr>
                    <tr><th scope='row'>Aktif</th>                 <td>";
                                                                  if ($s[aktif]=='Ya'){
                                                                      echo "<input type='radio' name='f' value='Ya' checked> Ya
                                                                             <input type='radio' name='f' value='Tidak'> Tidak";
                                                                  }else{
                                                                      echo "<input type='radio' name='f' value='Ya'> Ya
                                                                             <input type='radio' name='f' value='Tidak' checked> Tidak";
                                                                  }
                  echo "</td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='update' class='btn btn-info'>Update</button>
                    <a href='index.php?view=kelas'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
                    
                  </div>
              </form>
            </div>";
}elseif($_GET[act]=='tambah'){
    if (isset($_POST[tambah])){
        mysql_query("INSERT INTO rb_kelas VALUES('$_POST[a]','$_POST[b]','$_POST[c]','$_POST[d]','$_POST[e]','$_POST[f]')");
        echo "<script>document.location='index.php?view=kelas';</script>";
    }

    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Tambah Data Kelas</h3>
                </div>
              <div class='box-body'>
              <form method='POST' class='form-horizontal' action='' enctype='multipart/form-data'>
                <div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <tr><th width='120px' scope='row'>Kode Kelas</th>  <td><input type='text' class='form-control' name='a'>  </td></tr>
                    <tr><th scope='row'>Wali Kelas</th>               <td><select class='form-control' name='b'> 
                                                                          <option value='0' selected>- Pilih Wali Kelas -</option>"; 
                                                                            $wali = mysql_query("SELECT * FROM rb_guru");
                                                                            while($a = mysql_fetch_array($wali)){
                                                                                echo "<option value='$a[nip]'>$a[nama_guru]</option>";
                                                                            }
                                                                         echo "</select></td></tr>
                    <tr><th scope='row'>Jurusan</th>                <td><select class='form-control' name='c'> 
                                                                          <option value='0' selected>- Pilih Jurusan -</option>"; 
                                                                            $jur = mysql_query("SELECT * FROM rb_jurusan");
                                                                            while($a = mysql_fetch_array($jur)){
                                                                                echo "<option value='$a[kode_jurusan]'>$a[nama_jurusan]</option>";
                                                                            }
                                                                         echo "</select></td></tr>
                    <tr><th scope='row'>Ruangan</th>                <td><select class='form-control' name='d'> 
                                                                          <option value='0' selected>- Pilih Ruangan -</option>"; 
                                                                            $rua = mysql_query("SELECT * FROM rb_ruangan a JOIN rb_gedung b ON a.kode_gedung=b.kode_gedung ");
                                                                            while($a = mysql_fetch_array($rua)){
                                                                                echo "<option value='$a[kode_ruangan]'>$a[nama_gedung] - $a[nama_ruangan]</option>";
                                                                            }
                                                                         echo "</select></td></tr>
                    <tr><th scope='row'>Nama Kelas</th>            <td><input type='text' class='form-control' name='e'></td></tr>
                    <tr><th scope='row'>Aktif</th>                 <td><input type='radio' name='f' value='Ya' checked> Ya
                                                                             <input type='radio' name='f' value='Tidak'> Tidak  </td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='tambah' class='btn btn-info'>Tambahkan</button>
                    <a href='index.php?view=kelas'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
                    
                  </div>
              </form>
            </div>";
}
?>