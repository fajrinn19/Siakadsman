<section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="<?php echo $foto; ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p><?php echo $nama; ?></p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>

          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header" style='color:#fff; text-transform:uppercase; border-bottom:2px solid #00c0ef'>MENU <?php echo $level; ?></li>
            <li><a href="index.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
            
            <!-- Menu Bahan dan Tugas (untuk guru - menampilkan jadwal mengajar) -->
            <li><a href="index.php?view=bahantugas&act=listbahantugasguru"><i class="fa fa-download"></i> <span>Bahan & Tugas</span></a></li>
            
            <!-- Menu Quiz / Ujian Online (untuk guru - menampilkan jadwal mengajar) -->
            <li><a href="index.php?view=soal&act=detailguru"><i class="fa fa-pencil-square-o"></i> <span>Quiz / Ujian Online</span></a></li>
            
            <!-- Menu Absensi Siswa dengan Submenu -->
            <li class="treeview">
              <a href="#"><i class="fa fa-calendar-check-o"></i> <span>Absensi Siswa</span><i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="index.php?view=absensiswa&act=detailabsenguru"><i class="fa fa-circle-o"></i> Input Absensi</a></li>
                <li><a href="index.php?view=rekapabsensiswa"><i class="fa fa-circle-o"></i> Rekap Absensi Semua Kelas</a></li>
              </ul>
            </li>
            
            <li><a href="index.php?view=forum&act=detailguru"><i class="fa fa-th-list"></i> <span>Forum Diskusi</span></a></li>
            <li><a href="index.php?view=kompetensiguru"><i class="fa fa-tags"></i> <span>Kompetensi Dasar</span></a></li>
            <li><a href="index.php?view=journalguru"><i class="fa fa-list"></i> <span>Journal KBM</span></a></li>
            
            <!-- Menu Laporan Nilai Siswa dengan Submenu -->
            <li class="treeview">
              <a href="#"><i class="fa fa-calendar"></i> <span>Laporan Nilai Siswa</span><i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="index.php?view=raportuts&act=detailguru"><i class="fa fa-circle-o"></i> Input Nilai UTS</a></li>
                <li><a href="index.php?view=raport&act=detailguru"><i class="fa fa-circle-o"></i> Input Nilai Raport</a></li>
                <li><a href="index.php?view=raportcetak"><i class="fa fa-circle-o"></i> Cetak Raport Siswa</a></li>
              </ul>
            </li>
            <!-- <li><a href="index.php?view=dokumentasiguru"><i class="fa fa-book"></i> <span>Documentation</span></a></li> -->
          </ul>
        </section>