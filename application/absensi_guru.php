<?php 
// Tambahkan kurikulum di awal
$kurikulum = mysql_fetch_array(mysql_query("SELECT * FROM rb_kurikulum where status_kurikulum='Ya'"));

if ($_GET[act]==''){ 
    // Proses filter tanggal
    if (isset($_GET[gettanggal])){
        $filtertgl = $_GET[gettanggal];
    }else{
        if (isset($_POST[tgl])){ $tgl = $_POST[tgl]; }else{ $tgl = date("d"); }
        if (isset($_POST[bln])){ $bln = $_POST[bln]; }else{ $bln = date("m"); }
        if (isset($_POST[thn])){ $thn = $_POST[thn]; }else{ $thn = date("Y"); }
        $lebartgl=strlen($tgl);
        $lebarbln=strlen($bln);

        switch($lebartgl){ 
            case 1: { $tglc="0".$tgl; break; }
            case 2: { $tglc=$tgl; break; }      
        } 

        switch($lebarbln){ 
            case 1: { $blnc="0".$bln; break; }
            case 2: { $blnc=$bln; break; }      
        }
        $filtertgl = $thn."-".$blnc."-".$tglc;
    }
    
    $ex = explode('-',$filtertgl);
    $tahun = $ex[0];
    $bulane = $ex[1];
    $tanggal = $ex[2];
    if (substr($tanggal,0,1) == '0'){ $tgle = substr($tanggal,1,1); }else{ $tgle = substr($tanggal,0,2); }
    if (substr($bulane,0,1) == '0'){ $blnee = substr($bulane,1,1); }else{ $blnee = substr($bulane,0,2); }
?> 
    <div class="col-xs-12">  
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Data Absensi Guru Pada : <b style='color:red'><?php echo tgl_indo("$filtertgl")."</b>"; ?> </h3>
                <form style='margin-right:5px; margin-top:0px' class='pull-right' action='' method='GET'>
                    <input type="hidden" name='view' value='absenguru'>
                    <select name='tahun' style='padding:4px'>
                        <?php 
                            echo "<option value=''>- Pilih Tahun Akademik -</option>";
                            $tahun_q = mysql_query("SELECT * FROM rb_tahun_akademik");
                            while ($k = mysql_fetch_array($tahun_q)){
                                $selected = ($_GET[tahun]==$k[id_tahun_akademik]) ? "selected" : "";
                                echo "<option value='$k[id_tahun_akademik]' $selected>$k[nama_tahun]</option>";
                            }
                        ?>
                    </select>
                    <select name='kelas' style='padding:4px'>
                        <?php 
                            echo "<option value=''>- Pilih Kelas -</option>";
                            $kelas_q = mysql_query("SELECT * FROM rb_kelas");
                            while ($k = mysql_fetch_array($kelas_q)){
                                $selected = ($_GET[kelas]==$k[kode_kelas]) ? "selected" : "";
                                echo "<option value='$k[kode_kelas]' $selected>$k[kode_kelas] - $k[nama_kelas]</option>";
                            }
                        ?>
                    </select>
                    <input type="submit" style='margin-top:-4px' class='btn btn-success btn-sm' value='Lihat'>
                </form>
                <div style="clear:both"></div>

                <?php 
                echo "<div class='col-md-7 pull-right' style='margin:5px -14px 5px 0px'>
                <form action='index.php?view=absenguru' method='POST' style='margin-bottom:5px'>
                        <div class='col-xs-3'><select name='tgl' class='form-control'><option selected>- Tanggal -</option>";
                            for($n=1; $n<=31; $n++){
                                $selected = ($tgle == $n) ? "selected" : "";
                                echo "<option value='$n' $selected>$n</option>";
                            }
                        echo "</select></div> <div class='col-xs-4'><select name='bln' class='form-control'><option selected>- Bulan -</option>";
                            $blnn = array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
                            for($n=1; $n<=12; $n++){
                                $selected = ($blnee == $n) ? "selected" : "";
                                echo "<option value='$n' $selected>$blnn[$n]</option>";
                            }
                        echo "</select></div> <div class='col-xs-3'><select name='thn' class='form-control'><option selected>- Tahun -</option>";
                            $tahunn = date("Y");
                            for($n=2015; $n<=$tahunn+5; $n++){ 
                                $selected = ($tahun == $n) ? "selected" : "";
                                echo "<option value='$n' $selected>$n</option>";
                            } 
                        echo "</select></div> 
                            <input name='lihat' class='btn btn-primary' type='submit' value='Lihat Absen'>
                    </form></div>";
                ?>
            </div><!-- /.box-header -->
            
            <form action='' method="POST">
            <div class="box-body">
                <table id="example" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style='width:20px'>No</th>
                            <th>Jadwal Pelajaran</th>
                            <th>Kelas</th>
                            <th>Guru</th>
                            <th>Hari</th>
                            <th>Mulai</th>
                            <th>Selesai</th>
                            <th>Ruangan</th>
                            <th width='90px'>Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    // PERBAIKAN: Cek apakah filter sudah dipilih
                    if (isset($_GET[kelas]) && isset($_GET[tahun]) && $_GET[kelas] != '' && $_GET[tahun] != ''){
                        $kelas_filter = mysql_real_escape_string($_GET[kelas]);
                        $tahun_filter = mysql_real_escape_string($_GET[tahun]);
                        
                        $tampil = mysql_query("SELECT a.*, e.nama_kelas, b.namamatapelajaran, b.kode_pelajaran, 
                                              b.kode_kurikulum, c.nama_guru, d.nama_ruangan 
                                              FROM rb_jadwal_pelajaran a 
                                              JOIN rb_mata_pelajaran b ON a.kode_pelajaran=b.kode_pelajaran
                                              JOIN rb_guru c ON a.nip=c.nip 
                                              JOIN rb_ruangan d ON a.kode_ruangan=d.kode_ruangan
                                              JOIN rb_kelas e ON a.kode_kelas=e.kode_kelas 
                                              WHERE a.kode_kelas='$kelas_filter' 
                                              AND a.id_tahun_akademik='$tahun_filter' 
                                              AND b.kode_kurikulum='$kurikulum[kode_kurikulum]' 
                                              ORDER BY a.hari DESC");
                        
                        if(mysql_num_rows($tampil) == 0){
                            echo "<tr><td colspan='9' align='center'>Tidak ada jadwal pelajaran untuk kelas dan tahun akademik yang dipilih</td></tr>";
                        }
                        
                        $no = 1;
                        while($r = mysql_fetch_array($tampil)){
                            // Tentukan tanggal absen
                            if (isset($_GET[gettanggal])){
                                $sekarangabsen = $_GET[gettanggal];
                            }else{
                                if (isset($_POST[lihat])){
                                    $sekarangabsen = $thn."-".$blnc."-".$tglc;
                                }else{
                                    $sekarangabsen = date("Y-m-d");
                                }
                            }

                            $cek_absen = mysql_query("SELECT * FROM rb_absensi_guru 
                                                     WHERE kodejdwl='$r[kodejdwl]' AND nip='$r[nip]' AND tanggal='$sekarangabsen'");
                            $a = mysql_fetch_array($cek_absen);
                            
                            echo "<tr>
                                    <td>$no</td>
                                    <td>$r[namamatapelajaran]</td>
                                    <td>$r[nama_kelas]</td>
                                    <td>$r[nama_guru]</td>
                                    <td>$r[hari]</td>
                                    <td>$r[jam_mulai]</td>
                                    <td>$r[jam_selesai]</td>
                                    <td>$r[nama_ruangan]</td>
                                    <input type='hidden' value='$r[nip]' name='nip[$no]'>
                                    <input type='hidden' value='$r[kode_pelajaran]' name='kode_pelajaran[$no]'>
                                    <input type='hidden' value='$r[kode_kelas]' name='kode_kelas[$no]'>
                                    <td><select style='width:100px;' name='a[$no]' class='form-control'>";
                                    
                                        $kehadiran = mysql_query("SELECT * FROM rb_kehadiran ORDER BY kode_kehadiran");
                                        while ($k = mysql_fetch_array($kehadiran)){
                                            $selected = ($a['kode_kehadiran'] == $k['kode_kehadiran']) ? "selected" : "";
                                            echo "<option value='$k[kode_kehadiran]' $selected>$k[nama_kehadiran]</option>";
                                        }
                                        
                                    echo "</select></td>
                                    <input type='hidden' name='jdwl[$no]' value='$r[kodejdwl]'>
                                </tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='9' align='center' style='padding:60px; color:red'>Silahkan Memilih Tahun Akademik dan Kelas terlebih dahulu...</td></tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
            
            <?php if (isset($_GET[kelas]) && isset($_GET[tahun]) && $_GET[kelas] != '' && $_GET[tahun] != ''){ ?>
            <div class='box-footer'>
                <input type='hidden' name='filtertgl' value='<?php echo $filtertgl; ?>'>
                <input type='hidden' name='tahun_akademik' value='<?php echo $_GET[tahun]; ?>'>
                <input type='hidden' name='kelas' value='<?php echo $_GET[kelas]; ?>'>
                <button type='submit' name='simpan' class='btn btn-info pull-right'>Simpan Absensi</button>
            </div>
            <?php } ?>
            </form>
        </div><!-- /.box -->
    </div>

<?php 
    // PROSES SIMPAN ABSENSI
    if (isset($_POST['simpan'])){
        $jml_data = count($_POST['nip']);
        $nip = $_POST['nip'];
        $kode_pelajaran = $_POST['kode_pelajaran'];
        $kode_kelas = $_POST['kode_kelas'];
        $jdwl = $_POST['jdwl'];
        $a = $_POST['a'];
        
        $tglabsen = $_POST['filtertgl'];
        $error_count = 0;
        
        for ($i=1; $i <= $jml_data; $i++){
            // Validasi data
            if(empty($nip[$i]) || empty($jdwl[$i]) || empty($a[$i])){
                continue;
            }
            
            // Escape data untuk keamanan
            $nip_clean = mysql_real_escape_string($nip[$i]);
            $jdwl_clean = mysql_real_escape_string($jdwl[$i]);
            $a_clean = mysql_real_escape_string($a[$i]);
            $tglabsen_clean = mysql_real_escape_string($tglabsen);
            
            $cek = mysql_query("SELECT * FROM rb_absensi_guru 
                               WHERE kodejdwl='$jdwl_clean' 
                               AND nip='$nip_clean' 
                               AND tanggal='$tglabsen_clean'");
            $total = mysql_num_rows($cek);
            
            if ($total >= 1){
                $query = mysql_query("UPDATE rb_absensi_guru 
                                     SET kode_kehadiran = '$a_clean' 
                                     WHERE nip='$nip_clean' 
                                     AND kodejdwl='$jdwl_clean' 
                                     AND tanggal='$tglabsen_clean'");
                if(!$query) $error_count++;
            } else {
                $query = mysql_query("INSERT INTO rb_absensi_guru 
                                     VALUES ('',
                                             '$jdwl_clean',
                                             '$nip_clean',
                                             '$a_clean',
                                             '$tglabsen_clean',
                                             '".date('Y-m-d H:i:s')."')");
                if(!$query) $error_count++;
            }
        }
        
        // Redirect dengan menyimpan parameter filter
        if($error_count == 0){
            $redirect_url = "index.php?view=absenguru&tahun=".urlencode($_POST['tahun_akademik'])."&kelas=".urlencode($_POST['kelas']);
            echo "<script>alert('Absensi berhasil disimpan!'); document.location='$redirect_url';</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan saat menyimpan absensi!');</script>";
        }
    }
}
?>