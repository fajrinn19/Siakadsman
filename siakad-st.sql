-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 12, 2026 at 10:36 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `siakad-st`
--

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) NOT NULL,
  `attempt_time` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rb_absensi_guru`
--

CREATE TABLE `rb_absensi_guru` (
  `id_absensi_guru` int(5) NOT NULL,
  `kodejdwl` int(10) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `kode_kehadiran` varchar(5) NOT NULL,
  `tanggal` date NOT NULL,
  `waktu_input` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_absensi_guru`
--

INSERT INTO `rb_absensi_guru` (`id_absensi_guru`, `kodejdwl`, `nip`, `kode_kehadiran`, `tanggal`, `waktu_input`) VALUES
(1, 34, '197110292005011003', 'H', '2023-10-10', '2023-10-10 11:07:09'),
(2, 36, '197110292005011003', 'H', '2023-10-12', '2023-10-12 06:10:43'),
(3, 35, '197110292005011003', 'H', '2023-10-12', '2023-10-12 06:10:43'),
(4, 40, '202311111103', 'H', '2023-10-12', '2023-10-12 14:53:02'),
(5, 37, '202311111108', 'H', '2023-10-12', '2023-10-12 14:53:02'),
(6, 38, '202311111105', 'H', '2023-10-12', '2023-10-12 14:53:02'),
(7, 39, '202311111102', 'H', '2023-10-12', '2023-10-12 14:53:02'),
(8, 41, '202311111107', 'H', '2023-10-12', '2023-10-12 14:53:02'),
(9, 42, '202311111106', 'H', '2023-10-12', '2023-10-12 14:53:02'),
(10, 43, '202311111104', 'H', '2023-10-12', '2023-10-12 14:53:02'),
(11, 44, '202311111101', 'I', '2023-10-12', '2023-10-12 14:53:02'),
(12, 40, '202311111103', 'H', '2025-12-12', '2025-12-12 00:53:04'),
(13, 37, '202311111108', 'H', '2025-12-12', '2025-12-12 00:53:04'),
(14, 38, '202311111105', 'H', '2025-12-12', '2025-12-12 00:53:04'),
(15, 39, '202311111102', 'H', '2025-12-12', '2025-12-12 00:53:04'),
(16, 41, '202311111107', 'S', '2025-12-12', '2025-12-12 00:53:04'),
(17, 42, '202311111106', 'H', '2025-12-12', '2025-12-12 00:53:04'),
(18, 43, '202311111104', 'H', '2025-12-12', '2025-12-12 00:53:04'),
(19, 44, '202311111101', 'H', '2025-12-12', '2025-12-12 00:53:04');

-- --------------------------------------------------------

--
-- Table structure for table `rb_absensi_siswa`
--

CREATE TABLE `rb_absensi_siswa` (
  `id_absensi_siswa` int(5) NOT NULL,
  `kodejdwl` int(10) NOT NULL,
  `nisn` varchar(20) NOT NULL,
  `kode_kehadiran` varchar(5) NOT NULL,
  `tanggal` date NOT NULL,
  `waktu_input` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_absensi_siswa`
--

INSERT INTO `rb_absensi_siswa` (`id_absensi_siswa`, `kodejdwl`, `nisn`, `kode_kehadiran`, `tanggal`, `waktu_input`) VALUES
(1, 0, '12345678', 'H', '2023-10-12', '2023-10-12 14:48:46'),
(2, 0, '0151379251', 'H', '2023-10-12', '2023-10-12 14:48:46'),
(3, 0, '0004107204', 'H', '2023-10-12', '2023-10-12 14:48:46'),
(4, 0, '9998218087', 'H', '2023-10-12', '2023-10-12 14:48:46'),
(5, 0, '0007105659', 'H', '2023-10-12', '2023-10-12 14:48:46'),
(6, 0, '0000267795', 'H', '2023-10-12', '2023-10-12 14:48:46'),
(7, 0, '0007011100', 'H', '2023-10-12', '2023-10-12 14:48:46'),
(8, 0, '0000261160', 'I', '2023-10-12', '2023-10-12 14:48:46'),
(9, 0, '9991261263', 'H', '2023-10-12', '2023-10-12 14:48:46'),
(10, 0, '2232322', 'S', '2023-10-12', '2023-10-12 14:48:46'),
(11, 0, '12345678', 'H', '2025-12-12', '2025-12-12 00:13:50'),
(12, 0, '0151379251', 'H', '2025-12-12', '2025-12-12 00:13:50'),
(13, 0, '0004107204', 'H', '2025-12-12', '2025-12-12 00:13:50'),
(14, 0, '9998218087', 'H', '2025-12-12', '2025-12-12 00:13:50'),
(15, 0, '0007105659', 'I', '2025-12-12', '2025-12-12 00:13:50'),
(16, 0, '0000267795', 'H', '2025-12-12', '2025-12-12 00:13:50'),
(17, 0, '0007011100', 'H', '2025-12-12', '2025-12-12 00:13:50'),
(18, 0, '0000261160', 'H', '2025-12-12', '2025-12-12 00:13:50'),
(19, 0, '9991261263', 'H', '2025-12-12', '2025-12-12 00:13:50'),
(20, 0, '2232322', 'H', '2025-12-12', '2025-12-12 00:13:50');

-- --------------------------------------------------------

--
-- Table structure for table `rb_agama`
--

CREATE TABLE `rb_agama` (
  `id_agama` int(5) NOT NULL,
  `nama_agama` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_agama`
--

INSERT INTO `rb_agama` (`id_agama`, `nama_agama`) VALUES
(1, 'Islam'),
(2, 'Kristen'),
(3, 'Hindu'),
(4, 'Budha');

-- --------------------------------------------------------

--
-- Table structure for table `rb_elearning`
--

CREATE TABLE `rb_elearning` (
  `id_elearning` int(10) NOT NULL,
  `id_kategori_elearning` int(5) NOT NULL,
  `kodejdwl` int(5) NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `file_upload` text NOT NULL,
  `tanggal_tugas` datetime NOT NULL,
  `tanggal_selesai` datetime NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_elearning`
--

INSERT INTO `rb_elearning` (`id_elearning`, `id_kategori_elearning`, `kodejdwl`, `nama_file`, `file_upload`, `tanggal_tugas`, `tanggal_selesai`, `keterangan`) VALUES
(13, 1, 7, 'File Upload Materi 1', 'Contoh_Kasus_AHP.docx', '2015-12-09 08:07:15', '0000-00-00 00:00:00', ''),
(22, 2, 7, 'Tugas Untuk Siswa Kelompok yang Malas', 'cover_Pidana_korupsi.docx', '2015-12-09 22:37:51', '2015-12-23 13:07:09', 'Tolong Dikerjakan, Kalau Tidak Maka nilai Raport anda merah..'),
(23, 2, 7, 'Tugas Pertama ', 'Surat-Keterangan-Kepsek.docx', '2015-12-13 15:02:00', '2016-01-22 15:02:00', 'Selesaikan Secepatnya,..!'),
(24, 1, 5, 'Bahan Untuk Tugas Semester 2', 'journal_profile_matching_beasiswa.pdf', '2016-02-23 09:04:22', '2016-12-23 11:04:22', 'Bahan Untuk Tugas Semester 2 ini tolong dipelajari karena akan banyak keluar di ujian semester nanti.'),
(25, 2, 5, 'Tugas Semester 1 Tahun Ajaran 2015/2016', 'Metode-Profile-Matching.pdf', '2015-12-23 09:11:15', '2016-04-25 09:11:15', 'Silahkan Dijawab dan unutk jawaban di upload disini paling lambat sesuai tanggal selesai..'),
(26, 1, 13, 'Bahan Unutk Peljaran Besok', '20160311072304-Tugas_laura.docx', '2016-03-11 07:22:32', '2016-03-11 07:22:32', ''),
(27, 2, 13, 'Tugas Unutk Dikumpul Besok 12 Maret 2016', '20160311072502-Aturan Main Projects.docx', '2016-03-11 07:24:16', '2016-03-13 07:24:16', ''),
(28, 1, 13, 'kjbkjbkbk', '20160311143928-HITUNG NILAI RAPORT.docx', '2016-03-11 14:39:09', '2016-03-11 14:39:09', 'kjbkbk'),
(29, 1, 34, 'Praktek biasa', '20231010105531-26-30.jpg', '2023-10-10 10:54:33', '2023-10-20 10:54:35', 'siap'),
(30, 2, 34, 'test2', '20231010105619-26-30.jpg', '2023-10-10 10:55:48', '2023-10-21 10:55:48', 'acc');

-- --------------------------------------------------------

--
-- Table structure for table `rb_elearning_jawab`
--

CREATE TABLE `rb_elearning_jawab` (
  `id_elearning_jawab` int(5) NOT NULL,
  `id_elearning` int(5) NOT NULL,
  `nisn` varchar(20) NOT NULL,
  `keterangan` text NOT NULL,
  `file_tugas` varchar(255) NOT NULL,
  `waktu` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_elearning_jawab`
--

INSERT INTO `rb_elearning_jawab` (`id_elearning_jawab`, `id_elearning`, `nisn`, `keterangan`, `file_tugas`, `waktu`) VALUES
(3, 25, '9991268756', 'Ini buk Guru tugas dari saya, Tolong diperiksa,..', '20160309112015-Nilai_Siswa_9982679070.pdf', '2016-03-09 11:20:15'),
(4, 27, '9991268756', 'Ini Tugas saya buk..', '20160311072733-Pengembangan Members.txt', '2016-03-11 07:27:33');

-- --------------------------------------------------------

--
-- Table structure for table `rb_forum_komentar`
--

CREATE TABLE `rb_forum_komentar` (
  `id_forum_komentar` int(10) NOT NULL,
  `id_forum_topic` int(10) NOT NULL,
  `nisn_nip` varchar(20) NOT NULL,
  `isi_komentar` text NOT NULL,
  `waktu_komentar` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_forum_komentar`
--

INSERT INTO `rb_forum_komentar` (`id_forum_komentar`, `id_forum_topic`, `nisn_nip`, `isi_komentar`, `waktu_komentar`) VALUES
(1, 3, '9980707189', 'Senangi dulu pelajaran yang diharapkan nilainya bagus. Tanpa menyenangi pelajaran tersebut, maka hasil yang diperoleh melalui belajar tidak akan maksimal. Paling tidak, jangan sampai membenci pelajarannya. Hal ini karena akan tidak mungkin seseorang bisa betah lama-lama belajar materi suatu mata pelajaran yang dibencinya, apalagi untuk memahaminya.', '2015-12-12 05:09:15'),
(7, 1, '9980722436', 'Hallo teman teman, Numpang share lowongan ya. lagi di butuhkan segera nih buat posisi Full Time Web Developer/ Web Programmer.', '2016-02-26 00:34:01'),
(13, 1, '9991268756', 'Kami hanya ingin berdoa, ingin beribadah dan menjalankan ibadat kami. Kami tidak pernah menggangu apalagi berusaha untuk mengganggu umat beragama lain apalagi melakukan kristenisasi. Berpikir untuk itu saja kami tidak pernah.', '2016-03-09 10:38:51'),
(12, 1, '195704111980032004', 'Kami cuma ingin memiliki rumah ibadat agar kami dapat berdoa kepada Tuhan kami dengan khusuk. Dosakah itu? apakah itu terlarang di negara yag berazaskan Pancasila ini? Dimanakah rasa damai dan keadilan itu? Masih adakah toleransi di negara ini?', '2016-03-09 10:36:22'),
(3, 3, '9980722436', 'Milikilah rasa ingin tahu yang besar, karena hanya orang-orang yang memiliki rasa ingin tahu yang besar dalam banyak hal lah yang akan selalu senang dalam belajar, dan selalu ingin mempelajari dan memahami hal-hal baru dan banyak hal yang ia temui.', '2015-12-11 17:09:55'),
(14, 4, '2232322', 'Ok Siap mr Efrizal', '2023-10-11 22:21:33'),
(16, 5, '2', 'cwcwqcqwcqcq', '2025-12-14 21:34:17'),
(17, 5, '1', 'xwcxwcwqcw', '2025-12-14 21:34:47');

-- --------------------------------------------------------

--
-- Table structure for table `rb_forum_topic`
--

CREATE TABLE `rb_forum_topic` (
  `id_forum_topic` int(10) NOT NULL,
  `kodejdwl` int(10) NOT NULL,
  `judul_topic` varchar(255) NOT NULL,
  `isi_topic` text NOT NULL,
  `waktu` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_forum_topic`
--

INSERT INTO `rb_forum_topic` (`id_forum_topic`, `kodejdwl`, `judul_topic`, `isi_topic`, `waktu`) VALUES
(1, 33, 'Cara Unutk Memahami Rumus Pitagoras dengan mudah.', 'Dalam matematika, teorema Pythagoras adalah suatu keterkaitan dalam geometri Euklides antara tiga sisi sebuah segitiga siku-siku. Teorema ini dinamakan menurut nama filsuf dan matematikawan Yunani abad ke-6 SM, Pythagoras. . Pythagoras mendapat kredit karena ialah yang pertama membuktikan kebenaran universal dari teorema ini melalui pembuktian matematis.', '2015-12-11 08:08:18'),
(2, 7, 'Rumus untuk menghitung pendapatan perkapita', 'Pendapatan per kapita adalah jumlah (nilai) barang dan jasa rata-rata yang tersedia bagi setiap penduduk suatu negara pada suatu periode tertentu.\r\n\r\nPendapatan per kapita dapat digunakan untuk membandingkan kesejahteraan atau standar hidup suatu negara dari tahun ke tahun. Dengan melakukan perbandingan seperti itu, kita dapat mengamati apakah kesejahteraan masyarakat pada suatu negara secara rata-rata telah meningkat. Pendapatan per kapita yang meningkat merupakan salah satu tanda bahwa rata-rata kesejahteraan penduduk telah meningkat. Pendapatan per kapita menunjukkan pula apakah pembangunan yang telah dilaksanakan oleh pemerintah telah berhasil, berapa besar keberhasilan tersebut, dan akibat apa yang timbul oleh peningkatan tersebut.', '2015-12-12 13:13:27'),
(3, 7, 'Cara Mendapatkan Nilai Bagus Dan Menjadi Juara Kelas Di Sekolah', 'Bagaimana caranya agar nilai rapor mata pelajaran di sekolah hasilnya baik dan bagus sehingga syukur-syukur bisa menjadi juara kelas ? Ikuti tips di bawah ini yang didasarkan pada sebuah pengalaman nyata bertahun-tahun dari berbagai sumber. \r\n\r\nPerlu untuk digaris-bawahi, tak dibutuhkan otak yang pintar atau jenius untuk mendapatkan nilai yang bagus di sekolah ataupun untuk menjadi seorang juara kelas. Seseorang yang kemampuan otaknya biasa-biasa saja akan bisa memperoleh hasil yang bagus asalkan ia memiliki niat, kemauan, maupun sikap yang tepat dalam mewujudkan ambisinya.', '2015-12-11 16:20:51'),
(4, 36, 'mengatur waktu', 'Pastikan mengatur waktu belajar seoptimal mungkin', '2023-10-11 22:21:08'),
(5, 44, 'ewcvehiwcuiewbc', 'cwencewnciewc', '2025-12-14 21:33:00');

-- --------------------------------------------------------

--
-- Table structure for table `rb_gedung`
--

CREATE TABLE `rb_gedung` (
  `kode_gedung` varchar(10) NOT NULL,
  `nama_gedung` varchar(100) NOT NULL,
  `jumlah_lantai` varchar(20) NOT NULL,
  `panjang` varchar(20) NOT NULL,
  `tinggi` varchar(20) NOT NULL,
  `lebar` varchar(20) NOT NULL,
  `keterangan` text NOT NULL,
  `aktif` enum('Y','N') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_gedung`
--

INSERT INTO `rb_gedung` (`kode_gedung`, `nama_gedung`, `jumlah_lantai`, `panjang`, `tinggi`, `lebar`, `keterangan`, `aktif`) VALUES
('G001', 'Gedung A', '2', '100', '50', '50', '', 'Y'),
('G002', 'Gedung B', '3', '50', '80', '30', '', 'Y'),
('admin', 'Jln. H. Juanda 255', 'A.5', '40', '20', '12 - 01 - 2009', '13333', '');

-- --------------------------------------------------------

--
-- Table structure for table `rb_golongan`
--

CREATE TABLE `rb_golongan` (
  `id_golongan` int(5) NOT NULL,
  `nama_golongan` varchar(150) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_golongan`
--

INSERT INTO `rb_golongan` (`id_golongan`, `nama_golongan`, `keterangan`) VALUES
(1, 'IV/a', 'Golongan IV/a'),
(3, 'III/B', 'Golongan III/B');

-- --------------------------------------------------------

--
-- Table structure for table `rb_guru`
--

CREATE TABLE `rb_guru` (
  `nip` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_guru` varchar(150) NOT NULL,
  `id_jenis_kelamin` int(5) NOT NULL,
  `tempat_lahir` varchar(150) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `nik` varchar(50) NOT NULL,
  `niy_nigk` varchar(50) NOT NULL,
  `nuptk` varchar(50) NOT NULL,
  `id_status_kepegawaian` int(5) NOT NULL,
  `id_jenis_ptk` int(5) NOT NULL,
  `pengawas_bidang_studi` varchar(150) NOT NULL,
  `id_agama` int(5) NOT NULL,
  `alamat_jalan` varchar(255) NOT NULL,
  `rt` varchar(5) NOT NULL,
  `rw` varchar(5) NOT NULL,
  `nama_dusun` varchar(100) NOT NULL,
  `desa_kelurahan` varchar(100) NOT NULL,
  `kecamatan` varchar(100) NOT NULL,
  `kode_pos` int(10) NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `hp` varchar(15) NOT NULL,
  `email` varchar(150) NOT NULL,
  `tugas_tambahan` varchar(100) NOT NULL,
  `id_status_keaktifan` int(5) NOT NULL,
  `sk_cpns` varchar(150) NOT NULL,
  `tanggal_cpns` date NOT NULL,
  `sk_pengangkatan` varchar(150) NOT NULL,
  `tmt_pengangkatan` date NOT NULL,
  `lembaga_pengangkatan` varchar(150) NOT NULL,
  `id_golongan` int(5) NOT NULL,
  `keahlian_laboratorium` varchar(150) NOT NULL,
  `sumber_gaji` varchar(150) NOT NULL,
  `nama_ibu_kandung` varchar(100) NOT NULL,
  `id_status_pernikahan` int(5) NOT NULL,
  `nama_suami_istri` varchar(100) NOT NULL,
  `nip_suami_istri` varchar(30) NOT NULL,
  `pekerjaan_suami_istri` varchar(100) NOT NULL,
  `tmt_pns` date NOT NULL,
  `lisensi_kepsek` varchar(20) NOT NULL,
  `jumlah_sekolah_binaan` int(5) NOT NULL,
  `diklat_kepengawasan` varchar(20) NOT NULL,
  `mampu_handle_kk` varchar(20) NOT NULL,
  `keahlian_breile` varchar(20) NOT NULL,
  `keahlian_bahasa_isyarat` varchar(20) NOT NULL,
  `npwp` varchar(50) NOT NULL,
  `kewarganegaraan` varchar(50) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_guru`
--

INSERT INTO `rb_guru` (`nip`, `password`, `nama_guru`, `id_jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `nik`, `niy_nigk`, `nuptk`, `id_status_kepegawaian`, `id_jenis_ptk`, `pengawas_bidang_studi`, `id_agama`, `alamat_jalan`, `rt`, `rw`, `nama_dusun`, `desa_kelurahan`, `kecamatan`, `kode_pos`, `telepon`, `hp`, `email`, `tugas_tambahan`, `id_status_keaktifan`, `sk_cpns`, `tanggal_cpns`, `sk_pengangkatan`, `tmt_pengangkatan`, `lembaga_pengangkatan`, `id_golongan`, `keahlian_laboratorium`, `sumber_gaji`, `nama_ibu_kandung`, `id_status_pernikahan`, `nama_suami_istri`, `nip_suami_istri`, `pekerjaan_suami_istri`, `tmt_pns`, `lisensi_kepsek`, `jumlah_sekolah_binaan`, `diklat_kepengawasan`, `mampu_handle_kk`, `keahlian_breile`, `keahlian_bahasa_isyarat`, `npwp`, `kewarganegaraan`, `foto`) VALUES
('202311111108', 'guru123', 'Aprilia Retnowulan', 2, 'Semarang', '1957-04-11', '1374025104571989', '', '1743735636300012', 3, 2, 'IPS', 1, 'Jl. Orchid Raya, Melintang', '3', '0', 'cikeas', 'Balai-Balai', 'Kec. Padang Panjang Barat', 12212, '0751461692', '089399393930', 'bisnisku220971@gmail.com', 'Kepala Laboratorium', 1, '56483/C/2/80', '1980-03-01', '56483/C/2/80', '1980-03-01', 'Pemerintah Pusat', 1, '', 'APBD Kabupaten/Kota', 'Hj. Djawana', 1, 'Zainudin, S.PD.I', '', 'Wiraswasta', '1981-05-01', 'TIDAK', 0, 'TIDAK', '0', 'TIDAK', 'TIDAK', '', 'Indonesia', ''),
('202311111105', 'guru123', 'Aisyah Banowati', 2, 'DKI Jakarta', '1958-06-16', '1374025104571989', '', '3948736639300012', 3, 2, 'IPS', 1, 'Jl. Jatinegara Barat 187', '0', '0', '', 'Tarok Dipo', 'merauke utara', 13310, '0751461692', '08159881589', 'saya@robbyprihandaya.com', '', 1, '822/1412/III-BKD-2005', '2005-12-23', '822/1412/III-BKD-2005', '1983-03-01', 'Pemerintah Pusat', 1, '', 'APBD Kabupaten/Kota', 'Djuniar', 1, 'Mufti SH, S.Pd', '', '3/TNI/Polri', '2006-03-01', 'TIDAK', 0, 'TIDAK', '0', 'TIDAK', 'TIDAK', '475928198202000', 'Indonesia', '20231012142524-Ramziya Amjad Bakhitah.jpg'),
('202311111102', 'guru123', 'Efayanti jenny', 2, 'Tambun', '1974-11-13', '1374025104571989', '', '4445752654300023', 3, 2, 'MIPA', 1, 'belimbing 2 tebet', '1010', '', 'Keongmas', 'cikeas', 'cikeas utara', 12220, '0751461692', '081267771344', 'saya@rsmaterbuka.com', '', 1, '8527/A2/kp/2000', '2000-03-01', '001/2/II-Bkd/2001', '2002-02-01', 'Pemerintah Kab/Kota', 1, '', 'APBD Kabupaten/Kota', 'Ratna', 1, 'Defia', '', 'Wiraswasta', '2002-02-01', 'TIDAK', 0, 'TIDAK', '0', 'TIDAK', 'TIDAK', '476470810202000', 'INDONESIA', '20231012142111-peluang2.jpg'),
('202311111103', 'guru123', 'Efrizal Maulana', 1, 'Bukittinggi', '1971-10-29', '1374025104571989', '', '1361749652200013', 3, 2, '', 1, 'belimbing 2 tebet', '1', '6', 'cikeas', 'intan bukit', 'Kec. Aur Birugo Tigo Baleh', 26134, '0751461692', '081267771344', 'saya@smaterbuka.com', '', 1, 'bkd.049/813.3/Kep/Wako-2005', '2005-01-01', '188.45/159/821.13/kpts/bsl/bkd-2006', '2006-03-01', 'Pemerintah Kab/Kota', 1, '', 'APBD Kabupaten/Kota', 'Sariaji', 1, 'Hafnesi', '', 'Karyawan Swasta', '2006-03-01', 'TIDAK', 0, 'TIDAK', '0', 'TIDAK', 'TIDAK', '', 'INDONESIA', ''),
('202311111107', 'guru123', 'Faridawaty', 2, 'Cikarang utara', '1957-12-09', '1374025104571989', '', '2541735636300013', 3, 2, '', 1, 'Perumahan Kubang Duo B.12 Suka bumi', '01', '10', 'cikeas', 'Bukik Batabuah', 'Kec. Candung', 0, '0751461692', '081267771344', 'saya@smaterkini.com', 'Kepala Perpustakaan', 1, '40250/C/2/82', '1982-02-01', '3730/III/KWPK-82', '1982-11-01', 'Pemerintah Pusat', 1, '', 'APBD Kabupaten/Kota', 'Bawai Yahya', 1, 'Adwar. Bac', '', 'Karyawan Swasta', '1983-08-01', 'TIDAK', 0, 'TIDAK', '0', 'TIDAK', 'TIDAK', '475928370202000', 'INDONESIA', ''),
('202311111106', 'guru123', 'Zetri Zainal Abidin', 1, 'Semarang', '1958-01-18', '1374025104571989', '', '5450736639200002', 3, 2, '', 1, 'Jl. Orchid Raya, Melintang', '0', '0', '', 'Batu Taba', 'Kec. Ampek Angkek', 12212, '0751461692', '089399393930', 'bisnisku220971@gmail.com', '', 1, '119/IV.E/KWPK-86', '1985-12-01', '3095/III/KWPK-98', '1989-09-01', 'Pemerintah Pusat', 1, '', 'APBD Kabupaten/Kota', 'Rukiah', 1, 'Meriza', '', 'Lainnya', '1987-02-01', 'TIDAK', 0, 'TIDAK', '0', 'TIDAK', 'TIDAK', '476470786202000', 'Indonesia', '20231012142617-peluang3.jpg'),
('202311111104', 'guru123', 'Chika Solecha', 2, 'Semarang', '1969-11-13', '1374025104571989', '', '7445747649300023', 3, 2, '', 1, 'Jl. Orchid Raya, Melintang', '0', '0', '', 'Gadut', 'Kec. Tilatang Kamang', 12212, '0751461692', '089399393930', 'bisnisku220971@gmail.com', '', 1, '81903/A2/C/1994', '1994-12-01', '3646/IV/Kwpk-1997', '1997-07-01', 'Pemerintah Propinsi', 1, '', 'APBN', 'Rosni', 1, 'Muhammad Syawal', '', '3/TNI/Polri', '1997-07-01', 'TIDAK', 0, 'TIDAK', '0', 'TIDAK', 'TIDAK', '', 'Indonesia', '20231012142426-peluang4.jpg'),
('202311111101', 'guru123', 'Zulvan Ismayawati', 2, 'Bandung', '1977-12-28', '1374025104571989', '', '3560755657300033', 3, 2, 'MIPA', 1, 'Jl. Orchid Raya, Melintang', '0', '0', 'Keongmas', 'intan bukit', 'merauke utara', 12212, '0751461692', '089399393930', 'saya@smaterbuka.com', '', 1, '813/005-5D/BKD-2006', '2006-04-01', '813/005-5D/BKD-2006', '2006-04-01', 'Pemerintah Kab/Kota', 1, '', 'APBD Kabupaten/Kota', 'Hj. Zulbaidah Ham', 1, 'Satria Irandi', '', 'Peternak', '2007-08-01', 'TIDAK', 0, 'TIDAK', '0', 'TIDAK', 'TIDAK', '476470836202000', 'Indonesia', '20231012141856-peluang2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `rb_halaman`
--

CREATE TABLE `rb_halaman` (
  `id_halaman` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `judul_seo` varchar(255) NOT NULL,
  `isi_halaman` text NOT NULL,
  `username` varchar(50) NOT NULL,
  `status` enum('psb','journal') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_halaman`
--

INSERT INTO `rb_halaman` (`id_halaman`, `judul`, `judul_seo`, `isi_halaman`, `username`, `status`) VALUES
(1, 'Selamat Datang di Sistem Pendaftaran Siswa Baru', 'selamat-datang-di-sistem-pendaftaran-siswa-baru', 'Sistem PSB online atau sistem informasi aplikasi penerimaan siswa baru online merupakan produk layanan aplikasi perangkat lunak  yang online real time dan 100%   berbasis web. Sistem   ini   berusaha   memenuhi kebutuhan   masyarakat khususnya  bagi orangtua  dan  calon  siswa  untuk  dapat melaksanakan  pendaftaran  ke sekolah dengan  aman  dan  tertib  dengan menyediakan  fitur  otomasi  proses penerimaan  siswa  baru secara  langsung  menggunakan  media internet,  mulai  dari proses pendaftaran, proses seleksi, hingga pengumuman hasil penerimaan siswa secara langsung nyata melalui internet.\r\n\r\nYayasan phpmu.com didirikan di Padang dengan Akte Notaris Leurentia Siti Nyoman tertanggal 6 Maret 1996.Pada tahun pertama ini dibukalah taman kanak-kanak dan plygroup dengan murid berjumlah 73 orang dan kampusnya berlokasi di jalan Thamrin No.22-25', 'admin', 'psb'),
(2, 'Prosedur Pendaftaran Siswa Baru', 'prosedur-pendaftaran-siswa-baru', 'Melakukan  pendaftaran secara online melalui website psb.dek.sch.id\nMembayar uang pendaftaran sebesar Rp 60.000,00 ke Rekening Sekolah :\nNo Rekening : xxxxxxxxxxxxxx\nAtas Nama : BPN 010 SMAK PADANG\nBRI UNIT PASAR BARU PADANG\n\n<b>Note : Bagi Bapak/Ibuk yang sudah melakukan pembayaran dan konfirmasi harap segera megirim pesan ke nomor 082384116431</b>\n\nUntuk Metode Tansfer.\ndengan format pesan : [jenis metode pembaran] [no_rekening] [nama anak/nama pesera] [nomor_konfirmasi]\nContoh Pesan Metode Transfer : Transfer 111112318923 Annisa Mardatilah QC401\n\nUntuk Metode Setoran.\nInvite/Add ID What\'sApp dengan nomor 081267771344\ndengan format pesan : Kirim foto bukti slip setoran dan nama anak/peserta serta nomor konfirmasi\nContoh Format Pesan Whatsapp : [foto bukti slip setor] Annisa Mardatillah QC401\n\nMenyerahkan berkas dan ketentuan sebagai berikut apabila calon siswa dinyatakan lulus tes online.\nFoto kopi  rapor yang sudah dilegalisasi dari semester I - IV (1 rangkap)\nMemperlihatkan rapor asli\nSehat jasmani dan rohani (diperiksa di  SMK SMAK)\nTidak Buta Warna (diperiksa di SMK SMAK Padang)\nPas foto  warna terbaru ukuran 2x3 sebanyak 2 lembar dan 3X4 sebanyak 3 lembar', 'admin', 'psb');

-- --------------------------------------------------------

--
-- Table structure for table `rb_identitas_sekolah`
--

CREATE TABLE `rb_identitas_sekolah` (
  `id_identitas_sekolah` int(5) NOT NULL,
  `nama_sekolah` varchar(255) NOT NULL,
  `npsn` varchar(50) NOT NULL,
  `nss` varchar(50) NOT NULL,
  `alamat_sekolah` text NOT NULL,
  `kode_pos` int(7) NOT NULL,
  `no_telpon` varchar(15) NOT NULL,
  `kelurahan` varchar(255) NOT NULL,
  `kecamatan` varchar(255) NOT NULL,
  `kabupaten_kota` varchar(255) NOT NULL,
  `provinsi` varchar(255) NOT NULL,
  `website` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_identitas_sekolah`
--

INSERT INTO `rb_identitas_sekolah` (`id_identitas_sekolah`, `nama_sekolah`, `npsn`, `nss`, `alamat_sekolah`, `kode_pos`, `no_telpon`, `kelurahan`, `kecamatan`, `kabupaten_kota`, `provinsi`, `website`, `email`) VALUES
(1, 'SMA NEGERI 14 SINJAI', '69753239 ', '4232322', 'Jalan Persatuan Raya, Desa Arabika, Kecamatan Sinjai Barat, Kabupaten Sinjai, Sulawesi Selatan.', 92653, '09786768768776', 'ARABIKA', 'SINJAI BARAT', 'SINJAI', 'SULAWESI SELATAN', 'sman14sinjai.com', 'sman14sinjai@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `rb_jadwal_pelajaran`
--

CREATE TABLE `rb_jadwal_pelajaran` (
  `kodejdwl` int(10) NOT NULL,
  `id_tahun_akademik` int(5) NOT NULL,
  `kode_kelas` varchar(10) NOT NULL,
  `kode_pelajaran` varchar(10) NOT NULL,
  `kode_ruangan` varchar(10) NOT NULL,
  `nip` varchar(30) NOT NULL,
  `paralel` varchar(10) NOT NULL,
  `jadwal_serial` varchar(10) NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `hari` varchar(20) NOT NULL,
  `aktif` enum('Ya','Tidak') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_jadwal_pelajaran`
--

INSERT INTO `rb_jadwal_pelajaran` (`kodejdwl`, `id_tahun_akademik`, `kode_kelas`, `kode_pelajaran`, `kode_ruangan`, `nip`, `paralel`, `jadwal_serial`, `jam_mulai`, `jam_selesai`, `hari`, `aktif`) VALUES
(5, 20161, 'X.MIPA.1', 'MK02', 'R003', '195806161984000001', '', '', '23:00:00', '23:30:00', 'Senin', 'Ya'),
(13, 20161, 'X.MIPA.1', 'MK01', 'R003', '195704111980032004', '', '', '09:00:00', '11:30:00', 'Senin', 'Ya'),
(14, 20161, 'X.MIPA.1', 'MK03', 'R004', '195806161984032002', '', '', '08:00:00', '10:30:00', 'Selasa', 'Ya'),
(33, 20162, 'X.MIPA.1', 'MK15', 'R001', '195806161984000002', '00', '00', '08:00:00', '10:00:00', 'Senin', 'Ya'),
(37, 20231, 'X.MIPA.1', 'MK01', 'R001', '202311111108', '', '', '08:44:04', '09:44:04', 'Senin', 'Ya'),
(35, 20231, 'X.MIPA.1', 'MK02', 'R002', '197110292005011003', '', '', '08:40:16', '10:40:16', 'Selasa', 'Ya'),
(36, 20231, 'X.MIPA.1', 'MK01', 'R001', '197110292005011003', '', '', '08:42:36', '10:42:36', 'Senin', 'Ya'),
(38, 20231, 'X.MIPA.1', 'MK02', 'R001', '202311111105', '', '', '09:44:46', '10:44:46', 'Senin', 'Ya'),
(39, 20231, 'X.MIPA.1', 'MK03', 'R001', '202311111102', '', '', '10:45:20', '11:45:20', 'Senin', 'Ya'),
(40, 20231, 'X.MIPA.1', 'MK05', 'R001', '202311111103', '', '', '11:45:48', '12:45:48', 'Senin', 'Ya'),
(41, 20231, 'X.MIPA.1', 'MK04', 'R001', '202311111107', '', '', '08:46:16', '09:46:16', 'Selasa', 'Ya'),
(42, 20231, 'X.MIPA.1', 'MK06', 'R001', '202311111106', '', '', '09:46:56', '10:46:56', 'Selasa', 'Ya'),
(43, 20231, 'X.MIPA.1', 'MK07', 'R001', '202311111104', '', '', '10:47:23', '11:47:23', 'Selasa', 'Ya'),
(44, 20231, 'X.MIPA.1', 'MK08', 'R001', '202311111101', '', '', '11:47:54', '12:47:54', 'Selasa', 'Ya');

-- --------------------------------------------------------

--
-- Table structure for table `rb_jawaban_essai`
--

CREATE TABLE `rb_jawaban_essai` (
  `id_jawaban_essai` int(5) NOT NULL,
  `nisn` varchar(20) NOT NULL,
  `id_pertanyaan_essai` int(10) NOT NULL,
  `jawaban_essai` text NOT NULL,
  `waktu_tugas` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_jawaban_essai`
--

INSERT INTO `rb_jawaban_essai` (`id_jawaban_essai`, `nisn`, `id_pertanyaan_essai`, `jawaban_essai`, `waktu_tugas`) VALUES
(1, '0000261141', 1, 'abdurrahman wahid (Gus Dur)', '2016-03-05 14:16:15'),
(2, '0000261141', 2, '1. Udin Sedunia\r\n2. Sopan Sopian\r\n3. Inul Daratista\r\n4. Angelina Sondak\r\n5. Ruhut Sitompul', '2016-03-05 14:16:11'),
(3, '0000261141', 3, 'Di Kota Padang, Sumatera Barat Kota Padang', '2016-03-05 14:16:08'),
(4, '0000261141', 6, 'Wr Supratman', '2016-03-05 14:16:04'),
(5, '0000240365', 10, '359', '2016-03-05 14:15:41'),
(6, '0000240365', 9, 'Robby Prihandaya, S.Kom, M.Kom', '2016-03-05 14:15:51'),
(7, '9991268756', 10, 'Jawaban dari soal no 1..', '2016-03-09 03:39:36'),
(8, '9991268756', 9, 'Jawaban soal no 2,..', '2016-03-09 03:39:46');

-- --------------------------------------------------------

--
-- Table structure for table `rb_jawaban_objektif`
--

CREATE TABLE `rb_jawaban_objektif` (
  `id_jawaban_objektif` int(5) NOT NULL,
  `nisn` varchar(20) NOT NULL,
  `id_pertanyaan_objektif` int(10) NOT NULL,
  `jawaban` varchar(2) NOT NULL,
  `waktu_objektif` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_jawaban_objektif`
--

INSERT INTO `rb_jawaban_objektif` (`id_jawaban_objektif`, `nisn`, `id_pertanyaan_objektif`, `jawaban`, `waktu_objektif`) VALUES
(21, '0000261141', 5, 'a', '2016-03-05 14:16:54'),
(20, '0000261141', 1, 'b', '2016-03-05 14:16:51'),
(19, '0000261141', 2, 'c', '2016-03-05 14:16:48'),
(18, '0000240365', 6, 'a', '2016-03-05 14:22:49'),
(22, '0000240365', 8, 'e', '2016-03-05 14:16:40'),
(23, '9991268756', 8, 'a', '2016-03-09 03:39:51'),
(24, '9991268756', 6, 'b', '2016-03-09 03:39:51'),
(25, '2232322', 13, 'a', '2023-10-11 14:48:10');

-- --------------------------------------------------------

--
-- Table structure for table `rb_jenis_kelamin`
--

CREATE TABLE `rb_jenis_kelamin` (
  `id_jenis_kelamin` int(5) NOT NULL,
  `jenis_kelamin` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_jenis_kelamin`
--

INSERT INTO `rb_jenis_kelamin` (`id_jenis_kelamin`, `jenis_kelamin`) VALUES
(1, 'Laki-laki'),
(2, 'Perempuan');

-- --------------------------------------------------------

--
-- Table structure for table `rb_jenis_ptk`
--

CREATE TABLE `rb_jenis_ptk` (
  `id_jenis_ptk` int(5) NOT NULL,
  `jenis_ptk` varchar(100) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_jenis_ptk`
--

INSERT INTO `rb_jenis_ptk` (`id_jenis_ptk`, `jenis_ptk`, `keterangan`) VALUES
(2, 'Guru Mapel', ''),
(3, 'Guru BK', ''),
(4, 'Guru Kelas', '');

-- --------------------------------------------------------

--
-- Table structure for table `rb_journal_list`
--

CREATE TABLE `rb_journal_list` (
  `id_journal` int(10) NOT NULL,
  `kodejdwl` int(10) NOT NULL,
  `hari` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_ke` varchar(50) NOT NULL,
  `materi` text NOT NULL,
  `keterangan` text NOT NULL,
  `waktu_input` datetime NOT NULL,
  `users` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_journal_list`
--

INSERT INTO `rb_journal_list` (`id_journal`, `kodejdwl`, `hari`, `tanggal`, `jam_ke`, `materi`, `keterangan`, `waktu_input`, `users`) VALUES
(1, 33, 'Jumat', '2016-07-08', '1', 'Memahami struktur dan kaidah teks cerita pendek, baik melalui lisan maupun tulisannn.', 'Sebagai pendidik kita tentunya harus mempersiapkan segala sesuatu yang berhubungan dengan administrasi untuk mengajar...dalam kesempatan ini kami akan mencoba membuat draft jurnal kelas', '2016-07-08 08:08:37', '195806161984000002'),
(2, 33, 'Jumat', '2016-07-08', '2', 'Menganalisis teks cerita pendek, baik melalui lisan maupun tulisane.', 'Jurnal pembelajaran harian merupakan salah satu perangkat pembelajaran yang diperlukan oleh guru guna mencatat pelaksanaan pembelajaran setiap hari. jurnal pembelajaran dapat membantu proses sejauh mana kita telah mengajar serta menghandle siapa saja murid/guru yang tidak masuk atau yang tidak mengikuti proses KBM.', '2016-07-08 09:11:24', '195806161984000002'),
(5, 33, 'Jumat', '2016-07-08', '3', 'Berikut ini merupakan contoh dari enkripsi RSA dan dekripsinya. Parameter yang digunakan disini berupa bilangan kecil.', 'RSA di bidang kriptografi adalah sebuah algoritma pada enkripsi public key. RSA merupakan algoritma pertama yang cocok untuk digital signature seperti halnya ekripsi, dan salah satu yang paling maju dalam bidang kriptografi public key. RSA masih digunakan secara luas dalam protokol electronic commerce, dan dipercaya dalam mengamnkan dengan menggunakan kunci yang cukup panjang.', '2016-07-08 10:33:39', '1'),
(6, 40, 'Minggu', '2025-12-14', '1', '', '', '2025-12-14 12:14:29', '1');

-- --------------------------------------------------------

--
-- Table structure for table `rb_jurusan`
--

CREATE TABLE `rb_jurusan` (
  `kode_jurusan` varchar(10) NOT NULL,
  `nama_jurusan` varchar(255) NOT NULL,
  `nama_jurusan_en` varchar(255) NOT NULL,
  `bidang_keahlian` varchar(150) NOT NULL,
  `kompetensi_umum` varchar(150) NOT NULL,
  `kompetensi_khusus` varchar(150) NOT NULL,
  `pejabat` varchar(100) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `keterangan` text NOT NULL,
  `aktif` enum('Ya','Tidak') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_jurusan`
--

INSERT INTO `rb_jurusan` (`kode_jurusan`, `nama_jurusan`, `nama_jurusan_en`, `bidang_keahlian`, `kompetensi_umum`, `kompetensi_khusus`, `pejabat`, `jabatan`, `keterangan`, `aktif`) VALUES
('MIPA', 'Ilmu Pengetahuan Alam', '', 'Biologi, Fisika, kimia', 'Menguasai Semua Bidang Keahlian', 'Menguasai Semua Bidang Biologi', 'Hasan Bin Mail', 'Ketua Jurusan', '', 'Ya'),
('IPS', 'Ilmu Pengetahuan Sosial', 'Social Science', '', 'Menguasai semua bidang sosial dan kemasyarakatn', 'Menguasai bidang perekonomian dan keuangan', '', '', '', 'Ya'),
('BAHASA', 'Jurusan Bahasa', 'Language', 'Bahasa Indonesia', 'Menguasai semua bidang kebahasaan', 'Menguasai semua bidang ilmu kebahasaan', '', '', '', 'Ya');

-- --------------------------------------------------------

--
-- Table structure for table `rb_kategori_elearning`
--

CREATE TABLE `rb_kategori_elearning` (
  `id_kategori_elearning` int(5) NOT NULL,
  `nama_kategori_elearning` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_kategori_elearning`
--

INSERT INTO `rb_kategori_elearning` (`id_kategori_elearning`, `nama_kategori_elearning`) VALUES
(1, 'Bahan'),
(2, 'Tugas');

-- --------------------------------------------------------

--
-- Table structure for table `rb_kategori_quiz_ujian`
--

CREATE TABLE `rb_kategori_quiz_ujian` (
  `id_kategori_quiz_ujian` int(5) NOT NULL,
  `kategori_quiz_ujian` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_kategori_quiz_ujian`
--

INSERT INTO `rb_kategori_quiz_ujian` (`id_kategori_quiz_ujian`, `kategori_quiz_ujian`) VALUES
(1, 'Quiz Online'),
(2, 'Ujian Online');

-- --------------------------------------------------------

--
-- Table structure for table `rb_kehadiran`
--

CREATE TABLE `rb_kehadiran` (
  `kode_kehadiran` varchar(5) NOT NULL,
  `nama_kehadiran` varchar(20) NOT NULL,
  `nilai` int(2) NOT NULL,
  `bobot` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_kehadiran`
--

INSERT INTO `rb_kehadiran` (`kode_kehadiran`, `nama_kehadiran`, `nilai`, `bobot`) VALUES
('H', 'Hadir', 1, '1'),
('I', 'Izin', 1, '0.5'),
('S', 'Sakit', 1, '0.5'),
('A', 'Alpa', 0, '0');

-- --------------------------------------------------------

--
-- Table structure for table `rb_kelas`
--

CREATE TABLE `rb_kelas` (
  `kode_kelas` varchar(10) NOT NULL,
  `nip` varchar(30) NOT NULL,
  `kode_jurusan` varchar(10) NOT NULL,
  `kode_ruangan` varchar(10) NOT NULL,
  `nama_kelas` varchar(20) NOT NULL,
  `aktif` enum('Ya','Tidak') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_kelas`
--

INSERT INTO `rb_kelas` (`kode_kelas`, `nip`, `kode_jurusan`, `kode_ruangan`, `nama_kelas`, `aktif`) VALUES
('X.MIPA.1', '202311111104', 'MIPA', 'R001', 'Kelas X IPA 1', 'Tidak'),
('X.MIPA.2', '13653450011', 'IPS', 'R002', 'Kelas X IPA 2', 'Ya'),
('X.MIPA.3', '13653450022', 'MIPA', 'R003', 'Kelas X IPA 3', 'Ya'),
('X.MIPA.4', '634534533234', 'MIPA', 'R004', 'Kelas X IPA 4', 'Ya'),
('X.MIPA.5', '63453453354', 'IPS', 'R003', 'Kelas X IPA 5', 'Ya'),
('X.IPS.1', '202311111105', 'IPS', 'R002', 'Kelas X IPS 1', 'Ya'),
('X.IPS.2', '634534533234', 'MIPA', 'R004', 'Kelas X IPS 2', 'Ya'),
('X.IPS.3', '634534533234', 'MIPA', 'R004', 'Kelas X IPS 3', 'Ya'),
('X.IPS.4', '63453453354', 'MIPA', 'R001', 'Kelas X IPS 4', 'Ya'),
('X.IPS.5', '63453453354', 'MIPA', 'R001', 'Kelas X IPS 5', 'Ya'),
('XI.MIPA.1', '13653450022', 'MIPA', 'R001', 'Kelas XI IPA 1', 'Ya'),
('XI.MIPA.2', '13653450022', 'MIPA', 'R002', 'Kelas XI IPA 2', 'Ya'),
('XI.MIPA.3', '13653450022', 'MIPA', 'R003', 'Kelas XI IPA 3', 'Ya'),
('XI.MIPA.4', '13653450022', 'MIPA', 'R004', 'Kelas XI IPA 4', 'Ya'),
('XI.MIPA.5', '13653450022', 'MIPA', 'R001', 'Kelas XI IPA 5', 'Ya'),
('XI.IPS.1', '13653450022', 'IPS', 'R003', 'Kelas XI IPS 1', 'Ya'),
('XI.IPS.2', '13653450022', 'IPS', 'R004', 'Kelas XI IPS 2', 'Ya'),
('XI.IPS.3', '13653450022', 'IPS', 'R001', 'Kelas XI IPS 3', 'Ya'),
('XI.IPS.4', '13653450022', 'IPS', 'R002', 'Kelas XI IPS 4', 'Ya'),
('XII.MIPA.1', '13653450022', 'MIPA', 'R003', 'Kelas XII IPA 1', 'Ya'),
('XII.MIPA.2', '13653450022', 'MIPA', 'R001', 'Kelas XII IPA 2', 'Ya'),
('XII.MIPA.3', '202311111105', 'MIPA', 'R002', 'Kelas XII IPA 3', 'Tidak'),
('XII.MIPA.4', '202311111103', 'MIPA', 'R001', 'Kelas XII IPA 4', 'Ya'),
('XII.MIPA.5', '202311111102', 'MIPA', 'R003', 'Kelas XII IPA 5', 'Ya'),
('XII.IPS.1', '13653450022', 'IPS', 'R002', 'Kelas XII IPS 1', 'Ya'),
('XII.IPS.2', '13653450022', 'IPS', 'R003', 'Kelas XII IPS 2', 'Ya'),
('XII.IPS.3', '13653450022', 'IPS', 'R001', 'Kelas XII IPS 3', 'Ya'),
('XII.IPS.4', '13653450022', 'IPS', 'R004', 'Kelas XII IPS 4', 'Ya'),
('XII.IPS.5', '13653450022', 'IPS', 'R002', 'Kelas XII IPS 5', 'Ya'),
('XI.BAHASA', '13653450022', 'BAHASA', 'R001', 'Kelas XI Bahasa', 'Ya'),
('X.IBBU', '13653450022', 'IBBU', 'R002', 'Kelas X IBBU', 'Ya'),
('ANU', '202311111108', 'MIPA', 'R001', 'Kelas X IPA 1', 'Ya'),
('X-1', '202311111108', 'MIPA', 'R001', 'KELAS X KREATIF', 'Tidak');

-- --------------------------------------------------------

--
-- Table structure for table `rb_kelompok_mata_pelajaran`
--

CREATE TABLE `rb_kelompok_mata_pelajaran` (
  `id_kelompok_mata_pelajaran` int(5) NOT NULL,
  `jenis_kelompok_mata_pelajaran` varchar(50) NOT NULL,
  `nama_kelompok_mata_pelajaran` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_kelompok_mata_pelajaran`
--

INSERT INTO `rb_kelompok_mata_pelajaran` (`id_kelompok_mata_pelajaran`, `jenis_kelompok_mata_pelajaran`, `nama_kelompok_mata_pelajaran`) VALUES
(1, 'A', 'Kelompok A (Umum)'),
(2, 'B', 'Kelompok B (Umum)'),
(4, 'C', 'Kelompok C (Peminatan)');

-- --------------------------------------------------------

--
-- Table structure for table `rb_kompetensi_dasar`
--

CREATE TABLE `rb_kompetensi_dasar` (
  `id_kompetensi_dasar` int(10) NOT NULL,
  `kodejdwl` int(10) NOT NULL,
  `ranah` enum('pengetahuan','keterampilan','sikap') NOT NULL,
  `kompetensi_dasar` text NOT NULL,
  `waktu_input` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_kompetensi_dasar`
--

INSERT INTO `rb_kompetensi_dasar` (`id_kompetensi_dasar`, `kodejdwl`, `ranah`, `kompetensi_dasar`, `waktu_input`) VALUES
(1, 33, 'pengetahuan', 'Memahami struktur dan kaidah teks cerita pendek, baik melalui lisan maupun tulisannn.', '2016-07-03 08:10:13'),
(2, 33, 'keterampilan', 'Menganalisis teks cerita pendek, baik melalui lisan maupun tulisane.', '2016-07-03 09:44:36'),
(3, 5, 'pengetahuan', 'Mampu mengoperasikan sistem perangkat untuk praktek laboratorium', '2023-10-10 11:00:10'),
(4, 40, 'pengetahuan', 'BHUBHB', '2025-12-14 12:14:59');

-- --------------------------------------------------------

--
-- Table structure for table `rb_kurikulum`
--

CREATE TABLE `rb_kurikulum` (
  `kode_kurikulum` int(5) NOT NULL,
  `nama_kurikulum` varchar(255) NOT NULL,
  `status_kurikulum` enum('Ya','Tidak') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_kurikulum`
--

INSERT INTO `rb_kurikulum` (`kode_kurikulum`, `nama_kurikulum`, `status_kurikulum`) VALUES
(1, 'Kurikulum 2013', 'Ya'),
(2, 'Kurikulum 2016', 'Tidak'),
(4, 'MERDEKA BELAJAR', 'Ya');

-- --------------------------------------------------------

--
-- Table structure for table `rb_mata_pelajaran`
--

CREATE TABLE `rb_mata_pelajaran` (
  `kode_pelajaran` varchar(20) NOT NULL,
  `id_kelompok_mata_pelajaran` int(3) NOT NULL,
  `kode_jurusan` varchar(10) NOT NULL,
  `nip` varchar(30) NOT NULL,
  `kode_kurikulum` int(5) NOT NULL,
  `namamatapelajaran` varchar(150) NOT NULL,
  `namamatapelajaran_en` varchar(150) NOT NULL,
  `tingkat` varchar(10) NOT NULL,
  `kompetensi_umum` text NOT NULL,
  `kompetensi_khusus` text NOT NULL,
  `jumlah_jam` varchar(20) NOT NULL,
  `sesi` varchar(50) NOT NULL,
  `urutan` int(3) NOT NULL,
  `aktif` enum('Ya','Tidak') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_mata_pelajaran`
--

INSERT INTO `rb_mata_pelajaran` (`kode_pelajaran`, `id_kelompok_mata_pelajaran`, `kode_jurusan`, `nip`, `kode_kurikulum`, `namamatapelajaran`, `namamatapelajaran_en`, `tingkat`, `kompetensi_umum`, `kompetensi_khusus`, `jumlah_jam`, `sesi`, `urutan`, `aktif`) VALUES
('MK01', 1, 'MIPA', '202311111108', 1, 'Bahasa Indonesia', '', '2 (SLTA)', 'Isikan Nama Kompetensi Umum', 'Isikan Nama Kompetensi Khusus', '2', '', 0, 'Ya'),
('MK02', 1, 'IPS', '202311111105', 1, 'Matematika', '', '2 (SLTA)', 'Isikan Nama Kompetensi Umum', 'Isikan Nama Kompetensi Khusus', '2', '', 0, 'Ya'),
('MK03', 2, 'MIPA', '202311111102', 1, 'Bahasa Inggris', '', '2 (SLTA)', 'Isikan Nama Kompetensi Umum', 'Isikan Nama Kompetensi Khusus', '2', '', 0, 'Ya'),
('MK05', 1, 'MIPA', '202311111101', 1, 'Aritmatika Dasar', '', '2 (SLTA)', 'Isikan Nama Kompetensi Umum', 'Isikan Nama Kompetensi Khusus', '2', '', 0, 'Ya'),
('MK04', 4, 'MIPA', '202311111106', 1, 'Kalkulus', '', '2 (SLTA)', 'Isikan Nama Kompetensi Umum', 'Isikan Nama Kompetensi Khusus', '2', '', 0, 'Ya'),
('MK06', 0, 'MIPA', '202311111104', 1, 'Pengantar Teknologi', '', '2 (SLTA)', 'Isikan Nama Kompetensi Umum', 'Isikan Nama Kompetensi Khusus', '2', '', 0, 'Ya'),
('MK07', 1, 'IPS', '202311111107', 1, 'Sejarah Indonesia', '', '2 (SLTA)', 'Isikan Nama Kompetensi Umum', 'Isikan Nama Kompetensi Khusus', '2', '', 0, 'Ya'),
('MK08', 1, 'IPS', '202311111106', 1, 'Pendidikan Pancasila', '', '2 (SLTA)', 'Isikan Nama Kompetensi Umum', 'Isikan Nama Kompetensi Khusus', '2', '', 0, 'Ya'),
('MK09', 1, 'IPS', '202311111103', 1, 'Pendidikan Agama', '', '2 (SLTA)', 'Isikan Nama Kompetensi Umum', 'Isikan Nama Kompetensi Khusus', '2', '', 0, 'Ya'),
('MK10', 2, 'IPS', '202311111102', 1, 'Seni Budaya', '', '2 (SLTA)', 'Isikan Nama Kompetensi Umum', 'Isikan Nama Kompetensi Khusus', '2', '', 0, 'Ya'),
('MK11', 2, 'IPS', '198406142009012003', 1, 'Pendidikan Olahraga', '', '2 (SLTA)', 'Isikan Nama Kompetensi Umum', 'Isikan Nama Kompetensi Khusus', '2', '', 0, 'Ya'),
('MK12', 2, 'MIPA', '198012112005012005', 1, 'Prakarya Kewirausahaan', '', '2 (SLTA)', 'Isikan Nama Kompetensi Umum', 'Isikan Nama Kompetensi Khusus', '2', '', 0, 'Ya'),
('MK13', 3, 'IPS', '196305141990032003', 1, 'Geografi', '', '2 (SLTA)', 'Isikan Nama Kompetensi Umum', 'Isikan Nama Kompetensi Khusus', '2', '', 0, 'Ya'),
('MK14', 3, 'MIPA', '198312252009022007', 1, 'Ekonomi', '', '2 (SLTA)', 'Isikan Nama Kompetensi Umum', 'Isikan Nama Kompetensi Khusus', '2', '', 0, 'Ya'),
('MK15', 3, 'IPS', '195806161984000002', 1, 'Web Programming', '', '3 (SLTA)', 'Mengenal teknik Pembuatan Web', 'Menguasai Bahasa Pemrograman Web', '3', '', 0, 'Ya');

-- --------------------------------------------------------

--
-- Table structure for table `rb_menu`
--

CREATE TABLE `rb_menu` (
  `id_menu` int(5) NOT NULL,
  `id_parent` int(5) NOT NULL DEFAULT 0,
  `nama_menu` varchar(30) NOT NULL,
  `icon` varchar(20) NOT NULL,
  `link` varchar(100) NOT NULL,
  `aktif` enum('Ya','Tidak') NOT NULL DEFAULT 'Ya',
  `urutan` int(3) NOT NULL,
  `status` enum('psb','journal') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_menu`
--

INSERT INTO `rb_menu` (`id_menu`, `id_parent`, `nama_menu`, `icon`, `link`, `aktif`, `urutan`, `status`) VALUES
(1, 0, 'Beranda', 'home', 'index.mu', 'Ya', 1, 'psb'),
(2, 0, 'Aturan & Prosedur', 'th-list', 'halaman-prosedur-pendaftaran-siswa-baru.mu', 'Ya', 2, 'psb'),
(3, 0, 'Jadwal Pelaksanaan', 'calendar', '#', 'Ya', 3, 'psb'),
(4, 0, 'Alur Pendaftaran', 'retweet', '#', 'Ya', 4, 'psb');

-- --------------------------------------------------------

--
-- Table structure for table `rb_nilai_extrakulikuler`
--

CREATE TABLE `rb_nilai_extrakulikuler` (
  `id_nilai_extrakulikuler` int(10) NOT NULL,
  `id_tahun_akademik` int(5) NOT NULL,
  `nisn` varchar(20) NOT NULL,
  `kode_kelas` varchar(10) NOT NULL,
  `kegiatan` text NOT NULL,
  `nilai` float NOT NULL,
  `deskripsi` text NOT NULL,
  `user_akses` varchar(50) NOT NULL,
  `waktu_input` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_nilai_extrakulikuler`
--

INSERT INTO `rb_nilai_extrakulikuler` (`id_nilai_extrakulikuler`, `id_tahun_akademik`, `nisn`, `kode_kelas`, `kegiatan`, `nilai`, `deskripsi`, `user_akses`, `waktu_input`) VALUES
(1, 20161, '9991268756', 'X.MIPA.1', 'Kegiatan Mandi-mandii', 87, 'Kegiatan mandi-mandi dilaksanakan di lubuak minturun bersamaan dengan perayaan ulang tahun sekolah.', '1', '2016-04-29 10:11:10'),
(2, 20161, '9991268756', 'X.MIPA.1', 'Kegiatan Bakar ayam.', 95, 'Memiliki keterampilan Mengidentifikasi, menyajikan model matematika dan menyelesaikan masalah keseharian.				', '1', '2016-04-29 07:08:28'),
(7, 20232, '2232322', 'X.MIPA.1', 'Catur', 90, 'Berprestasi', '1', '2023-10-11 07:08:26'),
(8, 20231, '2232322', 'X.MIPA.1', 'Sepak Takraw', 90, 'Berprestasi tingkat Provinsi', '1', '2023-10-11 21:59:14');

-- --------------------------------------------------------

--
-- Table structure for table `rb_nilai_keterampilan`
--

CREATE TABLE `rb_nilai_keterampilan` (
  `id_nilai_keterampilan` int(10) NOT NULL,
  `kodejdwl` int(10) NOT NULL,
  `nisn` varchar(20) NOT NULL,
  `kd` varchar(5) NOT NULL,
  `nilai1` float NOT NULL,
  `nilai2` float NOT NULL,
  `nilai3` float NOT NULL,
  `nilai4` float NOT NULL,
  `nilai5` float NOT NULL,
  `nilai6` float NOT NULL,
  `deskripsi` text NOT NULL,
  `user_akses` varchar(50) NOT NULL,
  `waktu` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_nilai_keterampilan`
--

INSERT INTO `rb_nilai_keterampilan` (`id_nilai_keterampilan`, `kodejdwl`, `nisn`, `kd`, `nilai1`, `nilai2`, `nilai3`, `nilai4`, `nilai5`, `nilai6`, `deskripsi`, `user_akses`, `waktu`) VALUES
(1, 5, '9991268756', '4.1', 75, 70, 78, 85, 78, 72, 'Mengabstraksi teks cerita pendek, baik secara lisan maupun tulisan ', '1', '2016-04-11 18:26:32'),
(2, 5, '9998218087', '1', 88, 90, 98, 96, 0, 0, '', '1', '2016-04-11 18:26:32'),
(3, 5, '9998215055', '1', 67, 98, 76, 90, 0, 0, '', '1', '2016-04-11 18:26:32'),
(4, 5, '9998214335', '1', 87, 88, 0, 0, 0, 0, '', '1', '2016-04-11 18:26:32'),
(5, 5, '9998214151', '1', 89, 0, 0, 90, 0, 0, '', '1', '2016-04-11 18:26:32'),
(6, 5, '9997515863', '1', 89, 80, 88, 0, 0, 0, '', '1', '2016-04-11 18:26:32'),
(7, 5, '9991268756', '4.2', 87, 90, 94, 93, 88, 83, 'Mengabstraksi teks cerita ulang, baik secara lisan maupun tulisan ', '1', '2016-04-14 08:03:27'),
(8, 5, '9998218087', '2', 88, 93, 90, 99, 0, 0, '', '1', '2016-04-14 08:03:27'),
(9, 5, '9998215055', '2', 78, 87, 89, 79, 0, 0, '', '1', '2016-04-14 08:03:27'),
(10, 5, '9991268756', '4.3', 89, 89, 98, 95, 79, 77, 'Mengabstraksi teks pantun, baik secara lisan maupun tulisan', '1', '2016-04-14 08:03:57'),
(11, 5, '9998218087', '3', 78, 87, 89, 88, 0, 0, '', '1', '2016-04-14 08:03:57'),
(12, 5, '9998215055', '3', 70, 78, 87, 90, 0, 0, '', '1', '2016-04-14 08:03:57'),
(13, 5, '9991268756', '4.4', 90, 89, 87, 90, 85, 90, 'Menginterpretasi makna teks pantun, baik secara lisan maupun tulisan ', '1', '2016-04-14 08:04:20'),
(14, 5, '9998218087', '4', 87, 88, 83, 89, 0, 0, '', '1', '2016-04-14 08:04:20'),
(15, 5, '9991268756', '4.5', 99, 87, 98, 95, 96, 91, 'Menyunting teks cerita ulang, sesuai dengan struktur dan kaidah teks baik secara lisan maupun tulisan', '1', '2016-04-14 08:04:36'),
(17, 34, '2232322', '87', 88, 90, 89, 90, 90, 95, 'Bagus Sekali', '1', '2023-10-11 07:05:44'),
(18, 36, '2232322', '75', 80, 85, 85, 90, 90, 95, 'Hebat', '197110292005011003', '2023-10-11 22:12:15'),
(19, 35, '2232322', '75', 85, 85, 90, 90, 90, 95, 'Hebat', '197110292005011003', '2023-10-11 22:17:39'),
(20, 35, '2232322', '75', 85, 85, 90, 90, 90, 95, 'Hebat', '197110292005011003', '2023-10-11 22:19:51');

-- --------------------------------------------------------

--
-- Table structure for table `rb_nilai_pengetahuan`
--

CREATE TABLE `rb_nilai_pengetahuan` (
  `id_nilai_pengetahuan` int(10) NOT NULL,
  `kodejdwl` int(10) NOT NULL,
  `nisn` varchar(20) NOT NULL,
  `kd` varchar(5) NOT NULL,
  `nilai1` float NOT NULL,
  `nilai2` float NOT NULL,
  `nilai3` float NOT NULL,
  `nilai4` float NOT NULL,
  `nilai5` float NOT NULL,
  `deskripsi` text NOT NULL,
  `user_akses` varchar(50) NOT NULL,
  `waktu` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_nilai_pengetahuan`
--

INSERT INTO `rb_nilai_pengetahuan` (`id_nilai_pengetahuan`, `kodejdwl`, `nisn`, `kd`, `nilai1`, `nilai2`, `nilai3`, `nilai4`, `nilai5`, `deskripsi`, `user_akses`, `waktu`) VALUES
(1, 5, '9991268756', '4.1', 89, 90, 89, 95, 90, 'Memahami struktur dan kaidah teks cerita pendek, baik melalui lisan maupun tulisan ', '1', '2016-04-11 18:26:32'),
(2, 5, '9998218087', '4.1', 90, 88, 90, 98, 96, 'Menganalisis teks cerita pendek, baik melalui lisan maupun tulisan ', '1', '2016-04-11 18:26:32'),
(3, 5, '9998215055', '', 98, 67, 98, 76, 90, '', '1', '2016-04-11 18:26:32'),
(4, 5, '9998214335', '', 88, 87, 88, 0, 0, '', '1', '2016-04-11 18:26:32'),
(5, 5, '9998214151', '', 0, 89, 0, 0, 90, '', '1', '2016-04-11 18:26:32'),
(6, 5, '9997515863', '', 80, 89, 80, 88, 0, '', '1', '2016-04-11 18:26:32'),
(7, 5, '9991268756', '4.2', 90, 87, 90, 94, 94, 'Membandingkan teks cerita pendek, baik melalui lisan maupun tulisan', '1', '2016-04-14 08:03:27'),
(8, 5, '9998218087', '4.2', 93, 88, 93, 90, 99, 'Menganalisis teks cerita ulang, baik melalui lisan maupun tulisan ', '1', '2016-04-14 08:03:27'),
(9, 5, '9998215055', '', 87, 78, 87, 89, 79, '', '1', '2016-04-14 08:03:27'),
(10, 5, '9991268756', '4.3', 89, 89, 89, 98, 95, 'Menganalisis teks pantun, baik melalui lisan maupun tulisan ', '1', '2016-04-14 08:03:57'),
(11, 5, '9998218087', '', 87, 78, 87, 89, 88, '', '1', '2016-04-14 08:03:57'),
(12, 5, '9998215055', '', 78, 70, 78, 87, 90, '', '1', '2016-04-14 08:03:57'),
(13, 5, '9991268756', '4.4', 89, 90, 89, 87, 90, 'Membandingkan teks cerita ulang, baik melalui lisan maupun tulisan', '1', '2016-04-14 08:04:20'),
(14, 5, '9998218087', '', 88, 87, 88, 83, 89, '', '1', '2016-04-14 08:04:20'),
(15, 5, '9991268756', '4.5', 87, 90, 87, 78, 90, 'Menganalisis teks cerita ulang, baik melalui lisan maupun tulisan ', '1', '2016-04-14 08:04:36'),
(16, 5, '9998218087', '', 98, 99, 98, 89, 90, 'Menganalisis teks pantun, baik melalui lisan maupun tulisan', '1', '2016-04-14 08:04:36'),
(18, 5, '9991268756', '4.6', 90, 89, 90, 98, 78, 'Memahami struktur dan kaidah teks cerita pendek, baik melalui lisan maupun tulisan', '1', '2016-04-30 10:50:43'),
(19, 34, '2232322', '80', 87, 90, 95, 80, 75, 'Sangat Bagus', '1', '2023-10-11 07:03:51'),
(20, 36, '2232322', '90', 85, 85, 90, 90, 90, '', '197110292005011003', '2023-10-11 22:11:16'),
(21, 35, '2232322', '75', 85, 85, 90, 90, 90, '95', '197110292005011003', '2023-10-11 22:16:58');

-- --------------------------------------------------------

--
-- Table structure for table `rb_nilai_pertanyaan_essai`
--

CREATE TABLE `rb_nilai_pertanyaan_essai` (
  `id_nilai_pertanyaan_essai` int(5) NOT NULL,
  `id_quiz_ujian` int(5) NOT NULL,
  `nisn` varchar(20) NOT NULL,
  `nilai_essai` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_nilai_pertanyaan_essai`
--

INSERT INTO `rb_nilai_pertanyaan_essai` (`id_nilai_pertanyaan_essai`, `id_quiz_ujian`, `nisn`, `nilai_essai`) VALUES
(1, 1, '0000261141', 80),
(2, 4, '0000240365', 70),
(4, 4, '9991268756', 80);

-- --------------------------------------------------------

--
-- Table structure for table `rb_nilai_prestasi`
--

CREATE TABLE `rb_nilai_prestasi` (
  `id_nilai_prestasi` int(10) NOT NULL,
  `id_tahun_akademik` int(5) NOT NULL,
  `nisn` varchar(20) NOT NULL,
  `kode_kelas` varchar(10) NOT NULL,
  `jenis_kegiatan` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `user_akses` varchar(50) NOT NULL,
  `waktu_input` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_nilai_prestasi`
--

INSERT INTO `rb_nilai_prestasi` (`id_nilai_prestasi`, `id_tahun_akademik`, `nisn`, `kode_kelas`, `jenis_kegiatan`, `keterangan`, `user_akses`, `waktu_input`) VALUES
(2, 20161, '9991268756', 'X.MIPA.1', 'Kegiatan Jalan-jalan sore', 'Memiliki keterampilan merencanakan dan melaksanakan percobaan interferensi gelombang cahaya 				', '1', '2016-04-29 08:09:42'),
(6, 20232, '2232322', 'X.MIPA.1', 'catur', 'berprestasi', '1', '2023-10-11 07:09:19'),
(7, 20231, '2232322', 'X.MIPA.1', 'Bola Voley', 'Juara tingkat Kabupaten', '1', '2023-10-11 22:04:15');

-- --------------------------------------------------------

--
-- Table structure for table `rb_nilai_sikap`
--

CREATE TABLE `rb_nilai_sikap` (
  `id_nilai_sikap` int(10) NOT NULL,
  `kodejdwl` int(10) NOT NULL,
  `nisn` varchar(20) NOT NULL,
  `positif` text NOT NULL,
  `negatif` text NOT NULL,
  `deskripsi` text NOT NULL,
  `status` enum('spiritual','sosial') NOT NULL,
  `user_akses` varchar(50) NOT NULL,
  `waktu` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_nilai_sikap`
--

INSERT INTO `rb_nilai_sikap` (`id_nilai_sikap`, `kodejdwl`, `nisn`, `positif`, `negatif`, `deskripsi`, `status`, `user_akses`, `waktu`) VALUES
(1, 5, '9999152999', 'Selalu bersyukur dan selalu berdoa sebelum melakukan kegiatan serta memiliki toleran pada agama yang berbeda', 'Ketaatan beribadah mulai berkembang', 'Selalu bersyukur dan selalu berdoa sebelum melakukan kegiatan serta memiliki toleran pada agama yang berbeda; ketaatan beribadah mulai berkembang', 'spiritual', '1', '2016-04-18 16:38:53'),
(2, 5, '9998218087', 'Nilai Positif,..', 'Nilai Negatif,..', 'Deskripsi Nilai Sikap,..', 'spiritual', '1', '2016-04-18 16:38:53'),
(3, 5, '9999152999', 'Nilai Sosial Posisitf,..', 'Nilai Sosial Negatif,..', 'Nilai Deskripsi Sosial,..', 'sosial', '1', '2016-04-18 16:39:53'),
(4, 5, '9998218087', 'Nilai Sosial Posisitf 2,..', 'Nilai Sosial Negatif 2,..', 'Nilai Deskripsi Sosial 2,..', 'sosial', '1', '2016-04-18 16:39:53'),
(5, 5, '9991268756', 'Nilai Positif,..', 'Nilai Negatif,..', 'Deskripsi Nilai Sikap,..', 'spiritual', '1', '2016-04-29 20:12:48'),
(6, 5, '0151379251', 'Selalu bersyukur dan selalu berdoa sebelum melakukan kegiatan serta memiliki toleran pada agama yang berbeda', 'Ketaatan beribadah mulai berkembang', 'Selalu bersyukur dan selalu berdoa sebelum melakukan kegiatan serta memiliki toleran pada agama yang berbeda; ketaatan beribadah mulai berkembang', 'spiritual', '1', '2016-04-29 20:12:48'),
(7, 5, '9991268756', 'Nilai Positif,..', 'Nilai Negatif,..', 'Deskripsi Nilai Sikap,..', 'spiritual', '1', '2016-04-29 20:13:05'),
(8, 5, '0151379251', 'Selalu bersyukur dan selalu berdoa sebelum melakukan kegiatan serta memiliki toleran pada agama yang berbeda', 'Ketaatan beribadah mulai berkembang', 'Selalu bersyukur dan selalu berdoa sebelum melakukan kegiatan serta memiliki toleran pada agama yang berbeda; ketaatan beribadah mulai berkembang', 'spiritual', '1', '2016-04-29 20:13:05'),
(9, 5, '9998218087', 'Nilai Positif,..', 'Nilai Negatif,..', 'Deskripsi Nilai Sikap,..', 'spiritual', '1', '2016-04-29 20:13:05'),
(10, 5, '9991268756', 'Nilai Positif,..', 'Nilai Negatif,..', 'Deskripsi Nilai Sikap,..', 'spiritual', '1', '2016-04-29 20:13:34'),
(11, 5, '0151379251', 'Selalu bersyukur dan selalu berdoa sebelum melakukan kegiatan serta memiliki toleran pada agama yang berbeda', 'Ketaatan beribadah mulai berkembang', 'Selalu bersyukur dan selalu berdoa sebelum melakukan kegiatan serta memiliki toleran pada agama yang berbeda; ketaatan beribadah mulai berkembang', 'spiritual', '1', '2016-04-29 20:13:34'),
(12, 5, '9998218087', 'Isi dengan Nilai Positif,..', 'Isi dengan Nilai Negatif,..', 'Deskripsi Nilai Sikap,..', 'spiritual', '1', '2016-04-29 20:13:34'),
(13, 5, '9999152999', 'Selalu bersyukur dan selalu berdoa sebelum melakukan kegiatan serta memiliki toleran pada agama yang berbeda', 'Ketaatan beribadah mulai berkembang', 'Selalu bersyukur dan selalu berdoa sebelum melakukan kegiatan serta memiliki toleran pada agama yang berbeda; ketaatan beribadah mulai berkembang', 'spiritual', '1', '2016-04-29 20:13:34'),
(14, 5, '9991268756', 'Isi dengan Nilai Sosial Posisitf 2,..', 'Isi dengan Nilai Sosial Negatif 2,..', 'Isi dengan Nilai Deskripsi Sosial 2,..', 'sosial', '1', '2016-04-29 20:14:07'),
(15, 5, '9998218087', 'Nilai Sosial Posisitf 2,..', 'Nilai Sosial Negatif 2,..', '', 'sosial', '1', '2016-04-29 20:14:07'),
(16, 5, '9999152999', 'Nilai Sosial Posisitf,..', 'Nilai Sosial Negatif,..', 'Nilai Deskripsi Sosial,..', 'sosial', '1', '2016-04-29 20:14:07'),
(17, 34, '2232322', 'Positif', 'Positif', 'Sangat Koperatif dan motivatif', 'spiritual', '1', '2023-10-11 07:06:51'),
(18, 34, '2232322', 'Bagus', 'pendiam', 'Rajin tapi pendiam', 'sosial', '197110292005011003', '2023-10-11 21:23:34'),
(19, 36, '2232322', 'Baik', 'kurang aktif', 'baik dan rajin tapi kurang aktif', 'spiritual', '197110292005011003', '2023-10-11 22:10:04'),
(20, 36, '2232322', 'Cerdas', 'Pendiam', 'Cerdas tapi pendiam', 'sosial', '197110292005011003', '2023-10-11 22:10:27'),
(21, 35, '2232322', 'Baik', 'diam', 'baik tapi diam', 'spiritual', '197110292005011003', '2023-10-11 22:15:47'),
(22, 35, '2232322', 'Baik', 'diam', 'baik tapi diam', 'sosial', '197110292005011003', '2023-10-11 22:16:12');

-- --------------------------------------------------------

--
-- Table structure for table `rb_nilai_sikap_semester`
--

CREATE TABLE `rb_nilai_sikap_semester` (
  `id_nilai_sikap_semester` int(10) NOT NULL,
  `id_tahun_akademik` int(5) NOT NULL,
  `nisn` varchar(20) NOT NULL,
  `kode_kelas` varchar(10) NOT NULL,
  `spiritual_predikat` varchar(2) NOT NULL,
  `spiritual_deskripsi` text NOT NULL,
  `sosial_predikat` varchar(2) NOT NULL,
  `sosial_deskripsi` text NOT NULL,
  `user_akses` varchar(50) NOT NULL,
  `waktu_input` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_nilai_sikap_semester`
--

INSERT INTO `rb_nilai_sikap_semester` (`id_nilai_sikap_semester`, `id_tahun_akademik`, `nisn`, `kode_kelas`, `spiritual_predikat`, `spiritual_deskripsi`, `sosial_predikat`, `sosial_deskripsi`, `user_akses`, `waktu_input`) VALUES
(1, 20161, '9991268756', 'X.MIPA.1', 'A', 'Pertahankan Nilai anda,..', 'B', 'Tingkatkan Nilai anda,..', '1', '2016-04-28 10:10:16'),
(2, 20161, '0151379251', 'X.MIPA.1', 'C', 'Tolong Perbaiki Sikap anda,..', 'D', 'Anda Tidak Berutak,..', '1', '2016-04-28 10:10:16'),
(3, 20161, '0004107204', 'X.MIPA.1', 'A', 'Pertahankan Nilai anda,..', 'C', 'Tolong Perbaiki Sikap anda,..', '1', '2016-04-28 10:10:50'),
(4, 20232, '9991268756', 'X.MIPA.1', 'B', 'Baik', 'A', 'Baik Sekali', '1', '2023-10-10 11:32:15'),
(5, 20232, '0151379251', 'X.MIPA.1', 'C', 'Cukup', 'B', 'Baik', '1', '2023-10-10 11:32:15'),
(6, 20232, '0004107204', 'X.MIPA.1', 'B', 'Baik', 'A', 'Baik Sekali', '1', '2023-10-10 11:32:15'),
(7, 20232, '9998218087', 'X.MIPA.1', 'C', 'Cukup', 'C', 'Cukup', '1', '2023-10-10 11:32:15'),
(8, 20232, '0007105659', 'X.MIPA.1', 'B', 'Baik', 'A', 'Baik Sekali', '1', '2023-10-10 11:32:15'),
(9, 20232, '0000267795', 'X.MIPA.1', 'B', 'Baik', 'B', 'Baik', '1', '2023-10-10 11:32:15'),
(10, 20232, '0007011100', 'X.MIPA.1', 'C', 'Cukup', 'C', 'Cukup', '1', '2023-10-10 11:32:15'),
(11, 20232, '0000261160', 'X.MIPA.1', 'B', 'Baik', 'A', 'Baik Sekali', '1', '2023-10-10 11:32:15'),
(12, 20232, '9991261263', 'X.MIPA.1', 'B', 'Baik', 'A', 'Baik Sekali', '1', '2023-10-10 11:32:15'),
(13, 20232, '9994930260', 'X.MIPA.1', 'C', 'Cukup', 'C', 'Cukup', '1', '2023-10-10 11:32:15'),
(14, 20232, '9991262828', 'X.MIPA.1', 'B', 'Baik', 'B', 'Baik', '1', '2023-10-10 11:32:15'),
(15, 20232, '9991261271', 'X.MIPA.1', 'C', 'Cukup', 'C', 'Cukup', '1', '2023-10-10 11:32:15'),
(16, 20232, '9998214151', 'X.MIPA.1', 'B', 'Baik', 'A', 'Baik Sekali', '1', '2023-10-10 11:32:15'),
(17, 20232, '0000282457', 'X.MIPA.1', 'C', 'Cukup', 'C', 'Cukup', '1', '2023-10-10 11:32:15'),
(18, 20232, '0126523169', 'X.MIPA.1', 'B', 'Baik', 'A', 'Baik Sekali', '1', '2023-10-10 11:32:15'),
(19, 20232, '9997515863', 'X.MIPA.1', 'C', 'Cukup', 'C', 'Cukup', '1', '2023-10-10 11:32:15'),
(20, 20232, '9991261719', 'X.MIPA.1', 'B', 'Baik', 'B', 'Baik', '1', '2023-10-10 11:32:15'),
(21, 20232, '0000240365', 'X.MIPA.1', 'B', 'Baik', 'A', 'Baik Sekali', '1', '2023-10-10 11:32:15'),
(22, 20232, '9998214335', 'X.MIPA.1', 'C', 'Cukup', 'C', 'Cukup', '1', '2023-10-10 11:32:15'),
(23, 20232, '9998215055', 'X.MIPA.1', 'A', 'Baik Sekali', 'B', 'Baik', '1', '2023-10-10 11:32:15'),
(24, 20232, '0002882643', 'X.MIPA.1', 'A', 'Baik Sekali', 'B', 'Baik', '1', '2023-10-10 11:32:15'),
(25, 20232, '0009170412', 'X.MIPA.1', 'C', 'Cukup', 'A', 'Baik Sekali', '1', '2023-10-10 11:32:15'),
(26, 20232, '0005405460', 'X.MIPA.1', 'A', 'Baik Sekali', 'C', 'Cukup', '1', '2023-10-10 11:32:15'),
(27, 20232, '0007675125', 'X.MIPA.1', 'A', 'Baik Sekali', 'B', 'Baik', '1', '2023-10-10 11:32:15'),
(28, 20232, '9991384898', 'X.MIPA.1', 'C', 'Cukup', 'A', 'Baik Sekali', '1', '2023-10-10 11:32:15'),
(29, 20232, '9991260829', 'X.MIPA.1', 'A', 'Baik Sekali', 'C', 'Cukup', '1', '2023-10-10 11:32:15'),
(30, 20232, '0007011850', 'X.MIPA.1', 'C', 'Cukup', 'B', 'Baik', '1', '2023-10-10 11:32:15'),
(31, 20232, '9993841192', 'X.MIPA.1', 'A', 'Baik Sekali', 'A', 'Baik Sekali', '1', '2023-10-10 11:32:15'),
(32, 20232, '0000423077', 'X.MIPA.1', 'A', 'Baik Sekali', 'B', 'Baik', '1', '2023-10-10 11:32:15'),
(33, 20232, '0000261542', 'X.MIPA.1', 'C', 'Cukup', 'A', 'Baik Sekali', '1', '2023-10-10 11:32:15'),
(34, 20232, '0002731714', 'X.MIPA.1', 'A', 'Baik Sekali', 'C', 'Cukup', '1', '2023-10-10 11:32:15'),
(35, 20232, '0000282184', 'X.MIPA.1', 'C', 'Cukup', 'B', 'Baik', '1', '2023-10-10 11:32:15'),
(36, 20232, '9991263477', 'X.MIPA.1', 'A', 'Baik Sekali', 'C', 'Cukup', '1', '2023-10-10 11:32:15'),
(37, 20232, '9999152999', 'X.MIPA.1', 'C', 'Cukup', 'A', 'Baik Sekali', '1', '2023-10-10 11:32:15'),
(38, 20232, '0000261141', 'X.MIPA.1', 'B', 'Baik Sekali', 'C', 'Cukup', '1', '2023-10-10 11:32:15'),
(39, 20232, '2232322', 'X.MIPA.1', 'C', 'Cukup', 'A', 'Baik Sekali', '1', '2023-10-10 11:32:15'),
(40, 20231, '2232322', 'X.MIPA.1', 'A', 'Baik sekali', 'A', 'Unggul', '1', '2023-10-11 22:00:38');

-- --------------------------------------------------------

--
-- Table structure for table `rb_nilai_uts`
--

CREATE TABLE `rb_nilai_uts` (
  `id_nilai_uts` int(10) NOT NULL,
  `kodejdwl` int(10) NOT NULL,
  `nisn` varchar(20) NOT NULL,
  `angka_pengetahuan` float NOT NULL,
  `deskripsi_pengetahuan` text NOT NULL,
  `angka_keterampilan` float NOT NULL,
  `deskripsi_keterampilan` text NOT NULL,
  `waktu_input_uts` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_nilai_uts`
--

INSERT INTO `rb_nilai_uts` (`id_nilai_uts`, `kodejdwl`, `nisn`, `angka_pengetahuan`, `deskripsi_pengetahuan`, `angka_keterampilan`, `deskripsi_keterampilan`, `waktu_input_uts`) VALUES
(1, 5, '9991268756', 85, '', 90, '', '2016-04-15 17:54:05'),
(2, 5, '9998218087', 74, '', 83, '', '2016-04-15 17:54:05'),
(3, 13, '9999152999', 89, '', 90, '', '2016-04-21 18:52:57'),
(4, 14, '9999152999', 85, '', 79, '', '2016-04-21 18:53:14'),
(5, 34, '9991268756', 75, '', 75, '', '2023-10-10 11:21:21'),
(6, 34, '0151379251', 80, '', 80, '', '2023-10-10 11:21:21'),
(7, 34, '0004107204', 80, '', 76, '', '2023-10-10 11:21:21'),
(8, 34, '9998218087', 88, '', 87, '', '2023-10-10 11:21:21'),
(9, 34, '0007105659', 89, '', 98, '', '2023-10-10 11:21:21'),
(10, 34, '0000267795', 76, '', 78, '', '2023-10-10 11:21:21'),
(11, 34, '0007011100', 65, '', 99, '', '2023-10-10 11:21:21'),
(12, 34, '0000261160', 87, '', 89, '', '2023-10-10 11:21:21'),
(13, 34, '9991261263', 76, '', 78, '', '2023-10-10 11:21:21'),
(14, 34, '9994930260', 65, '', 99, '', '2023-10-10 11:21:21'),
(15, 34, '9991262828', 88, '', 77, '', '2023-10-10 11:21:21'),
(16, 34, '9991261271', 88, '', 77, '', '2023-10-10 11:21:21'),
(17, 34, '9998214151', 88, '', 77, '', '2023-10-10 11:21:21'),
(18, 34, '0000282457', 88, '', 77, '', '2023-10-10 11:21:21'),
(19, 34, '0126523169', 88, '', 77, '', '2023-10-10 11:21:21'),
(20, 34, '9997515863', 98, '', 75, '', '2023-10-10 11:21:21'),
(21, 34, '9991261719', 77, '', 66, '', '2023-10-10 11:21:21'),
(22, 34, '0000240365', 77, '', 66, '', '2023-10-10 11:21:21'),
(23, 34, '9998214335', 77, '', 66, '', '2023-10-10 11:21:21'),
(24, 34, '9998215055', 77, '', 66, '', '2023-10-10 11:21:21'),
(25, 34, '0002882643', 77, '', 77, '', '2023-10-10 11:21:21'),
(26, 34, '0009170412', 77, '', 88, '', '2023-10-10 11:21:21'),
(27, 34, '0005405460', 78, '', 76, '', '2023-10-10 11:21:21'),
(28, 34, '0007675125', 77, '', 77, '', '2023-10-10 11:21:21'),
(29, 34, '9991384898', 66, '', 88, '', '2023-10-10 11:21:21'),
(30, 34, '9991260829', 77, '', 88, '', '2023-10-10 11:21:21'),
(31, 34, '0007011850', 77, '', 88, '', '2023-10-10 11:21:21'),
(32, 34, '9993841192', 77, '', 88, '', '2023-10-10 11:21:21'),
(33, 34, '0000423077', 77, '', 88, '', '2023-10-10 11:21:21'),
(34, 34, '0000261542', 77, '', 88, '', '2023-10-10 11:21:21'),
(35, 34, '0002731714', 77, '', 88, '', '2023-10-10 11:21:21'),
(36, 34, '0000282184', 77, '', 88, '', '2023-10-10 11:21:21'),
(37, 34, '9991263477', 77, '', 88, '', '2023-10-10 11:21:21'),
(38, 34, '9999152999', 77, '', 88, '', '2023-10-10 11:21:21'),
(39, 34, '0000261141', 77, '', 76, '', '2023-10-10 11:21:21'),
(40, 34, '2232322', 77, '', 77, '', '2023-10-10 11:21:21'),
(41, 36, '2232322', 90, '', 85, '', '2023-10-11 22:04:54'),
(42, 35, '2232322', 90, '', 95, '', '2023-10-11 22:08:41'),
(43, 44, '12345678', 90, '', 90, '', '2023-10-12 15:10:55'),
(44, 44, '0151379251', 90, '', 90, '', '2023-10-12 15:10:55'),
(45, 44, '0004107204', 85, '', 90, '', '2023-10-12 15:10:55'),
(46, 44, '9998218087', 85, '', 80, '', '2023-10-12 15:10:55'),
(47, 44, '0007105659', 85, '', 80, '', '2023-10-12 15:10:55'),
(48, 44, '0000267795', 85, '', 80, '', '2023-10-12 15:10:55'),
(49, 44, '0007011100', 85, '', 80, '', '2023-10-12 15:10:55'),
(50, 44, '0000261160', 90, '', 80, '', '2023-10-12 15:10:55'),
(51, 44, '9991261263', 90, '', 85, '', '2023-10-12 15:10:55'),
(52, 44, '2232322', 90, '', 85, '', '2023-10-12 15:10:55'),
(53, 40, '12345678', 90, '', 90, '', '2025-12-14 12:16:17'),
(54, 40, '0151379251', 90, '', 90, '', '2025-12-14 12:16:17'),
(55, 40, '0004107204', 90, '', 90, '', '2025-12-14 12:16:17');

-- --------------------------------------------------------

--
-- Table structure for table `rb_pertanyaan_essai`
--

CREATE TABLE `rb_pertanyaan_essai` (
  `id_pertanyaan_essai` int(11) NOT NULL,
  `id_quiz_ujian` int(5) NOT NULL,
  `pertanyaan_essai` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_pertanyaan_essai`
--

INSERT INTO `rb_pertanyaan_essai` (`id_pertanyaan_essai`, `id_quiz_ujian`, `pertanyaan_essai`) VALUES
(1, 1, 'Siapakah Nama Presiden ke 5 Indonesia ?'),
(2, 1, 'Sebutkan Nama-nama Pahlawan Revolusi ?'),
(3, 1, 'Dimanakah Terjadinya Perjanjian Linggarjati ?'),
(5, 2, 'Sebutkan Arti Sila Ke 2 ?'),
(6, 2, 'Siapa Nama Pencipta Lagu Indonesia Raya ?'),
(9, 4, 'Siapa Nama Kepa Sekolah Kita ?'),
(10, 4, 'Berapakah Hasil 234 + 125 ?'),
(11, 5, 'kbkbkjbkjbkbk');

-- --------------------------------------------------------

--
-- Table structure for table `rb_pertanyaan_objektif`
--

CREATE TABLE `rb_pertanyaan_objektif` (
  `id_pertanyaan_objektif` int(11) NOT NULL,
  `id_quiz_ujian` int(11) NOT NULL,
  `pertanyaan_objektif` text NOT NULL,
  `jawab_a` varchar(255) NOT NULL,
  `jawab_b` varchar(255) NOT NULL,
  `jawab_c` varchar(255) NOT NULL,
  `jawab_d` varchar(255) NOT NULL,
  `jawab_e` varchar(255) NOT NULL,
  `kunci_jawaban` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_pertanyaan_objektif`
--

INSERT INTO `rb_pertanyaan_objektif` (`id_pertanyaan_objektif`, `id_quiz_ujian`, `pertanyaan_objektif`, `jawab_a`, `jawab_b`, `jawab_c`, `jawab_d`, `jawab_e`, `kunci_jawaban`) VALUES
(1, 1, 'Gubernur Tertua di Sumbar ?', 'Udin Sedunia', 'Saipul Jamil', 'Roma Irama', 'Fauzi Bahar', '', 'd'),
(2, 1, 'Nama-nama Pahlawan Indonesia ?', 'Robby Prihandaya', 'Taufik Hidayat', 'Ahmad Yani', 'Jokowi', '', 'c'),
(3, 1, 'Dimana Terjadinya Pembunuhan Sukarno ?', 'Padang', 'Payakumbuh', 'Bukit Tinggi', 'Semua Benar', '', 'a'),
(5, 1, 'Sebutkan Arti Sila Ke 2 ?', 'Keadilan Bagi Indonedia', 'Kerakyatan yang dipimpin Ndeso', 'Berjuang Untuk Jadi Lebih Baik', 'Kemanusiaan yang adil dan Beradap', '', 'd'),
(6, 4, 'Siapa Nama Pencipta Lagu Indonesia Raya ?', 'Dewiit Safitri', 'Ahmad Dani', 'Aura Kasih', 'Wr.Supratman', '', 'd'),
(8, 4, 'Siapakah nama Presiden ke 2 Indonesia ?', 'Joko Widodo', 'Susilo Bambang Yudoyono', 'Abdulrahman Wahid', 'Megawati', 'Soeharto', 'e'),
(10, 6, 'Tahun berapa Indonesia Merdeka', '1995', '1945', '2023', '2011', '2005', 'B'),
(12, 6, 'Siapakah Proklamator Kemerdekaan Republik Indonesia', 'Ir. Soekarno', 'Jendral Sudirman', 'Jendral Ahmad Yani', 'Jendral Soeharto', 'RA. Kartini', 'A'),
(13, 7, 'Siapa Presiden pertama RI?', 'Ir. Soekarno', 'Soeharto', 'Soedirman', 'Soetomo', 'Bung Hata', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `rb_pertanyaan_penilaian`
--

CREATE TABLE `rb_pertanyaan_penilaian` (
  `id_pertanyaan_penilaian` int(5) NOT NULL,
  `pertanyaan` varchar(255) NOT NULL,
  `status` enum('diri','teman') NOT NULL,
  `waktu_input` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_pertanyaan_penilaian`
--

INSERT INTO `rb_pertanyaan_penilaian` (`id_pertanyaan_penilaian`, `pertanyaan`, `status`, `waktu_input`) VALUES
(1, 'Bagaimana kenyamanan anda di sekolah ini pada |namamatapelajaran| ?', 'diri', '2016-07-03 04:17:29'),
(2, 'Bagaimana kenyamanan anda tehadap teman di sekolah ini ?', 'diri', '2016-07-03 08:12:17'),
(4, 'Apa perbuatan jahat yang pernah teman anda ini lakukan ?', 'teman', '2016-07-08 05:08:10'),
(5, 'Apakah dia teman yang baik?', 'teman', '2016-07-08 08:12:25'),
(6, 'Apa yang bisa dicontoh dari teman yang baik?', 'teman', '2023-10-10 11:03:40');

-- --------------------------------------------------------

--
-- Table structure for table `rb_pertanyaan_penilaian_jawab`
--

CREATE TABLE `rb_pertanyaan_penilaian_jawab` (
  `id_pertanyaan_penilaian_jawab` int(10) NOT NULL,
  `id_pertanyaan_penilaian` int(10) NOT NULL,
  `nisn` varchar(20) NOT NULL,
  `nisn_teman` varchar(20) NOT NULL,
  `jawaban` text NOT NULL,
  `status` enum('diri','teman') NOT NULL,
  `kode_kelas` varchar(10) NOT NULL,
  `waktu_jawab` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_pertanyaan_penilaian_jawab`
--

INSERT INTO `rb_pertanyaan_penilaian_jawab` (`id_pertanyaan_penilaian_jawab`, `id_pertanyaan_penilaian`, `nisn`, `nisn_teman`, `jawaban`, `status`, `kode_kelas`, `waktu_jawab`) VALUES
(23, 2, '9991268756', '', 'jjjj', 'diri', 'X.MIPA.1', '2016-07-08 15:57:55'),
(12, 4, '9991268756', '0151379251', 'fff', 'teman', 'X.MIPA.1', '2016-07-08 15:21:34'),
(11, 5, '9991268756', '0151379251', 'eee', 'teman', 'X.MIPA.1', '2016-07-08 15:21:34'),
(15, 5, '9991268756', '0004107204', 'aaaa', 'teman', 'X.MIPA.1', '2016-07-08 15:23:05'),
(16, 4, '9991268756', '0004107204', 'bbbb', 'teman', 'X.MIPA.1', '2016-07-08 15:23:05'),
(17, 5, '9991268756', '9998218087', 'ttt', 'teman', 'X.MIPA.1', '2016-07-08 15:23:34'),
(18, 4, '9991268756', '9998218087', 'yyy', 'teman', 'X.MIPA.1', '2016-07-08 15:23:34'),
(24, 1, '9991268756', '', 'kkkk', 'diri', 'X.MIPA.1', '2016-07-08 15:57:55'),
(25, 5, '9991268756', '0007105659', 'hhh', 'teman', 'X.MIPA.1', '2016-07-08 15:58:39'),
(26, 4, '9991268756', '0007105659', 'nnn', 'teman', 'X.MIPA.1', '2016-07-08 15:58:39');

-- --------------------------------------------------------

--
-- Table structure for table `rb_predikat`
--

CREATE TABLE `rb_predikat` (
  `id_predikat` int(5) NOT NULL,
  `kode_kelas` varchar(10) NOT NULL,
  `nilai_a` int(3) NOT NULL,
  `nilai_b` int(3) NOT NULL,
  `grade` varchar(5) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_predikat`
--

INSERT INTO `rb_predikat` (`id_predikat`, `kode_kelas`, `nilai_a`, `nilai_b`, `grade`, `keterangan`) VALUES
(1, '0', 86, 100, 'A', 'Sangat Baik'),
(2, '0', 79, 85, 'B', 'Baik'),
(3, '0', 77, 78, 'C', 'Cukup'),
(4, '0', 0, 77, 'D', 'Kurang'),
(7, 'X.MIPA.1', 85, 100, 'A', 'Sangat Baik'),
(8, 'X.MIPA.1', 70, 84, 'B', 'Baik'),
(9, 'X.MIPA.1', 50, 69, 'C', 'Cukup'),
(10, 'X.MIPA.1', 0, 49, 'D', 'Kurang');

-- --------------------------------------------------------

--
-- Table structure for table `rb_psb_aktivasi`
--

CREATE TABLE `rb_psb_aktivasi` (
  `id_aktivasi` int(10) NOT NULL,
  `kode_pendaftaran` varchar(50) NOT NULL,
  `nama_lengkap` varchar(150) NOT NULL,
  `status` enum('sma','smk','smp') NOT NULL,
  `proses` int(2) NOT NULL,
  `waktu_input` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_psb_aktivasi`
--

INSERT INTO `rb_psb_aktivasi` (`id_aktivasi`, `kode_pendaftaran`, `nama_lengkap`, `status`, `proses`, `waktu_input`) VALUES
(1, 'SMA-20160701085110', 'Robby Prihandaya', 'sma', 1, '2016-06-21 12:11:45'),
(2, 'SMK-20160701085110', 'Dewiit Safitri', 'smk', 1, '2016-06-21 15:04:57'),
(3, 'SMA-20160701085111', 'Tommy Utama', 'sma', 1, '2016-07-01 03:13:12'),
(4, 'SMP-20160701094107', 'Willy Fernando', 'smp', 0, '2016-07-01 09:27:54');

-- --------------------------------------------------------

--
-- Table structure for table `rb_psb_pendaftaran`
--

CREATE TABLE `rb_psb_pendaftaran` (
  `id_pendaftaran` int(10) NOT NULL,
  `kode_pendaftaran` varchar(50) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nama_panggilan` varchar(120) NOT NULL,
  `no_induk` varchar(50) NOT NULL,
  `id_jenis_kelamin` int(5) NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `id_agama` int(5) NOT NULL,
  `anak_ke` varchar(10) NOT NULL,
  `jumlah_saudara` varchar(10) NOT NULL,
  `status_dalam_keluarga` varchar(100) NOT NULL,
  `alamat_siswa` text NOT NULL,
  `no_telpon` varchar(15) NOT NULL,
  `berat_badan` int(5) NOT NULL,
  `tinggi_badan` int(5) NOT NULL,
  `golongan_darah` varchar(5) NOT NULL,
  `penyakit_pernah_diderita` varchar(255) NOT NULL,
  `diterima_dikelas` varchar(50) NOT NULL,
  `diterima_tanggal` date NOT NULL,
  `sekolah_asal` varchar(255) NOT NULL,
  `alamat_sekolah_asal` text NOT NULL,
  `nama_ayah` varchar(150) NOT NULL,
  `tempat_lahir_ayah` text NOT NULL,
  `tanggal_lahir_ayah` date NOT NULL,
  `agama_ayah` int(5) NOT NULL,
  `pendidikan_ayah` varchar(100) NOT NULL,
  `pekerjaan_ayah` varchar(255) NOT NULL,
  `alamat_rumah_ayah` text NOT NULL,
  `telpon_rumah_ayah` varchar(15) NOT NULL,
  `alamat_kantor_ayah` text NOT NULL,
  `telpon_kantor_ayah` varchar(15) NOT NULL,
  `nama_ibu` varchar(150) NOT NULL,
  `tempat_lahir_ibu` text NOT NULL,
  `tanggal_lahir_ibu` date NOT NULL,
  `agama_ibu` int(5) NOT NULL,
  `pendidikan_ibu` varchar(100) NOT NULL,
  `pekerjaan_ibu` varchar(255) NOT NULL,
  `alamat_rumah_ibu` text NOT NULL,
  `telpon_rumah_ibu` varchar(15) NOT NULL,
  `alamat_kantor_ibu` text NOT NULL,
  `telpon_kantor_ibu` varchar(15) NOT NULL,
  `nama_wali` varchar(150) NOT NULL,
  `alamat_wali` text NOT NULL,
  `no_telpon_wali` varchar(15) NOT NULL,
  `status` enum('sma','smk','smp') NOT NULL,
  `waktu_daftar` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_psb_pendaftaran`
--

INSERT INTO `rb_psb_pendaftaran` (`id_pendaftaran`, `kode_pendaftaran`, `nama`, `nama_panggilan`, `no_induk`, `id_jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `id_agama`, `anak_ke`, `jumlah_saudara`, `status_dalam_keluarga`, `alamat_siswa`, `no_telpon`, `berat_badan`, `tinggi_badan`, `golongan_darah`, `penyakit_pernah_diderita`, `diterima_dikelas`, `diterima_tanggal`, `sekolah_asal`, `alamat_sekolah_asal`, `nama_ayah`, `tempat_lahir_ayah`, `tanggal_lahir_ayah`, `agama_ayah`, `pendidikan_ayah`, `pekerjaan_ayah`, `alamat_rumah_ayah`, `telpon_rumah_ayah`, `alamat_kantor_ayah`, `telpon_kantor_ayah`, `nama_ibu`, `tempat_lahir_ibu`, `tanggal_lahir_ibu`, `agama_ibu`, `pendidikan_ibu`, `pekerjaan_ibu`, `alamat_rumah_ibu`, `telpon_rumah_ibu`, `alamat_kantor_ibu`, `telpon_kantor_ibu`, `nama_wali`, `alamat_wali`, `no_telpon_wali`, `status`, `waktu_daftar`) VALUES
(1, 'SMA-20160701085110', 'Robby Prihandaya', 'Robby', '5675345', 1, 'Padang', '1989-06-05', 1, '3', '5', 'Anak Kandung', 'Jl. Angkasa Puri, Perundam 4, Blok C No 2', '081267771344', 75, 170, 'O', 'Tdak Pernah', '1', '2016-06-22', 'SMP N 2 Payakumbuh', 'Jl. Lingar Jati 6, No 16 C', 'Nafnizon (Alm)', 'Payakumbuh', '1975-04-12', 1, 'S1', 'PNS', 'Jl.Gatot Subroto 6, No 7a', '0752461692', 'Muro Paiti, Kapur IX', '0752786512', 'Yeni Ermawaty', 'Padang', '1974-01-18', 1, 'S1', 'Rumah Tangga', 'Jl.Gatot Subroto 6, No 7a', '0752461692', '-', '0', 'Tommy Utama', 'Jl.Ulak Karang Padang', '081266881226', 'sma', '2016-06-22 12:11:45'),
(3, 'SMK-20160701085110', 'Dewiit Safitri', 'Dewi', '5674322', 1, 'Gumarang', '1989-02-12', 1, '3', '5', 'Anak Kandung', 'Jl. Linggar Jati, Padang', '082173054501', 60, 170, 'AB', 'Tdak Pernah', '1', '2016-06-22', 'SMP N 2 Payakumbuh', 'Jl. Lingar Jati 6, No 16 C', 'Sukarni', 'Gumarang', '1976-12-01', 1, 'S1', 'PNS', 'Jl.Gatot Subroto 6, No 7a', '0753456790', 'Muro Paiti, Kapur IX', '0753445566', 'Mama Dewi', 'Gumarang', '1973-11-11', 1, 'S1', 'Rumah Tangga', 'Jl.Gatot Subroto 6, No 7a', '0753456790', '-', '0', 'Adeil Putra', 'Jl.Ulak Karang, Padang', '082190871234', 'smk', '2016-06-22 15:04:57'),
(5, 'SMA-20160701085111', 'Tommy Utama', 'Tommy', '5674327', 1, 'Padang', '1985-08-18', 1, '1', '5', 'Anak Kandung', 'Jl. Simpang DPR, Padang', '081266881226', 70, 160, 'AB', 'Tdak Pernah', '1', '2016-07-01', 'SMA N 2 Payakumbuh', 'Jl. Lingar Jati 6, No 16 C', 'Sunandar', 'Payakumbuh', '0004-12-05', 1, 'S1', 'PNS', 'Jl.Gatot Subroto 6, No 7a', '0752461645', 'Muro Paiti, Kapur IX', '0752897855', 'Yunimar', 'Padang', '0000-00-00', 1, 'S1', 'Rumah Tangga', 'Jl.Gatot Subroto 6, No 7a', '0752461645', '-', '0', 'Willy Fernando', 'Jl.Ulak Karang, Padang', '082167771233', 'sma', '2016-07-01 11:19:36');

-- --------------------------------------------------------

--
-- Table structure for table `rb_psb_pendaftaran_saudara`
--

CREATE TABLE `rb_psb_pendaftaran_saudara` (
  `id_saudara` int(10) NOT NULL,
  `id_pendaftaran` int(10) NOT NULL,
  `nama_saudara` varchar(150) NOT NULL,
  `umur_saudara` int(5) NOT NULL,
  `pendidikan_saudara` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_psb_pendaftaran_saudara`
--

INSERT INTO `rb_psb_pendaftaran_saudara` (`id_saudara`, `id_pendaftaran`, `nama_saudara`, `umur_saudara`, `pendidikan_saudara`) VALUES
(1, 1, 'Willy Fernando', 29, 'S1'),
(2, 1, 'Randy Komara', 25, 'SMA'),
(3, 1, 'Laura Hikmah Izzatin', 18, 'SMA'),
(4, 3, 'Lira Virna', 15, 'SMP'),
(5, 3, 'Airin Stewano', 13, 'SD'),
(10, 5, 'Randy Komara', 25, 'SMA'),
(9, 5, 'Willy Fernando', 28, 'S1'),
(11, 5, 'Laura Hikmah Izzatin', 19, 'SMA');

-- --------------------------------------------------------

--
-- Table structure for table `rb_quiz_ujian`
--

CREATE TABLE `rb_quiz_ujian` (
  `id_quiz_ujian` int(5) NOT NULL,
  `id_kategori_quiz_ujian` int(5) NOT NULL,
  `kodejdwl` int(5) NOT NULL,
  `keterangan` text NOT NULL,
  `batas_waktu` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_quiz_ujian`
--

INSERT INTO `rb_quiz_ujian` (`id_quiz_ujian`, `id_kategori_quiz_ujian`, `kodejdwl`, `keterangan`, `batas_waktu`) VALUES
(4, 1, 5, 'Quiz Online Nilai Akhir Matematika', '2016-04-25 08:54:42'),
(5, 1, 5, 'hhhb', '2016-03-11 16:02:02'),
(6, 1, 34, 'Elisa Romeo', '2023-10-10 12:40:35'),
(7, 1, 36, 'tes1', '2023-10-11 23:46:21');

-- --------------------------------------------------------

--
-- Table structure for table `rb_ruangan`
--

CREATE TABLE `rb_ruangan` (
  `kode_ruangan` varchar(10) NOT NULL,
  `kode_gedung` varchar(10) NOT NULL,
  `nama_ruangan` varchar(100) NOT NULL,
  `kapasitas_belajar` int(5) NOT NULL,
  `kapasitas_ujian` int(5) NOT NULL,
  `keterangan` text NOT NULL,
  `aktif` enum('Ya','Tidak') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_ruangan`
--

INSERT INTO `rb_ruangan` (`kode_ruangan`, `kode_gedung`, `nama_ruangan`, `kapasitas_belajar`, `kapasitas_ujian`, `keterangan`, `aktif`) VALUES
('R001', 'G001', 'A.1', 35, 30, '', ''),
('R002', 'G001', 'A.2', 40, 20, '12 - 10 - 2009', ''),
('R003', 'G002', 'B.1', 30, 15, 'SHIFT', ''),
('R004', 'G002', 'B.2', 40, 20, '', ''),
('', '0', '', 0, 0, '', ''),
('X-KREATIF', 'G001', 'KELAS 10 KREATIF', 30, 30, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `rb_sesi`
--

CREATE TABLE `rb_sesi` (
  `id_sesi` int(5) NOT NULL,
  `nama_sesi` varchar(100) NOT NULL,
  `keterangan` text NOT NULL,
  `aktif` enum('Ya','Tidak') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_sesi`
--

INSERT INTO `rb_sesi` (`id_sesi`, `nama_sesi`, `keterangan`, `aktif`) VALUES
(1, 'Semester 1', '', 'Ya'),
(2, 'Semester 2', '', 'Ya'),
(3, 'Semester 3', '', 'Ya'),
(4, 'Semester 4', '', 'Ya'),
(5, 'Semester 5', '', 'Ya'),
(6, 'Semester 6', '', 'Ya');

-- --------------------------------------------------------

--
-- Table structure for table `rb_siswa`
--

CREATE TABLE `rb_siswa` (
  `id_siswa` int(10) NOT NULL,
  `nipd` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(120) NOT NULL,
  `id_jenis_kelamin` int(5) NOT NULL,
  `nisn` varchar(20) NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `nik` varchar(50) NOT NULL,
  `id_agama` int(5) NOT NULL,
  `kebutuhan_khusus` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `rt` varchar(5) NOT NULL,
  `rw` varchar(5) NOT NULL,
  `dusun` varchar(100) NOT NULL,
  `kelurahan` varchar(100) NOT NULL,
  `kecamatan` varchar(100) NOT NULL,
  `kode_pos` int(10) NOT NULL,
  `jenis_tinggal` varchar(100) NOT NULL,
  `alat_transportasi` varchar(100) NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `hp` varchar(15) NOT NULL,
  `email` varchar(150) NOT NULL,
  `skhun` varchar(50) NOT NULL,
  `penerima_kps` varchar(20) NOT NULL,
  `no_kps` varchar(50) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `nama_ayah` varchar(150) NOT NULL,
  `tahun_lahir_ayah` int(4) NOT NULL,
  `pendidikan_ayah` varchar(50) NOT NULL,
  `pekerjaan_ayah` varchar(100) NOT NULL,
  `penghasilan_ayah` varchar(100) NOT NULL,
  `kebutuhan_khusus_ayah` varchar(100) NOT NULL,
  `no_telpon_ayah` varchar(15) NOT NULL,
  `nama_ibu` varchar(150) NOT NULL,
  `tahun_lahir_ibu` int(4) NOT NULL,
  `pendidikan_ibu` varchar(50) NOT NULL,
  `pekerjaan_ibu` varchar(100) NOT NULL,
  `penghasilan_ibu` varchar(100) NOT NULL,
  `kebutuhan_khusus_ibu` varchar(100) NOT NULL,
  `no_telpon_ibu` varchar(15) NOT NULL,
  `nama_wali` varchar(150) NOT NULL,
  `tahun_lahir_wali` int(4) NOT NULL,
  `pendidikan_wali` varchar(50) NOT NULL,
  `pekerjaan_wali` varchar(100) NOT NULL,
  `penghasilan_wali` varchar(50) NOT NULL,
  `angkatan` int(5) NOT NULL,
  `status_awal` varchar(20) NOT NULL,
  `status_siswa` enum('Aktif','Tidak Aktif') NOT NULL,
  `tingkat` varchar(10) NOT NULL,
  `kode_kelas` varchar(10) NOT NULL,
  `kode_jurusan` varchar(10) NOT NULL,
  `id_sesi` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_siswa`
--

INSERT INTO `rb_siswa` (`id_siswa`, `nipd`, `password`, `nama`, `id_jenis_kelamin`, `nisn`, `tempat_lahir`, `tanggal_lahir`, `nik`, `id_agama`, `kebutuhan_khusus`, `alamat`, `rt`, `rw`, `dusun`, `kelurahan`, `kecamatan`, `kode_pos`, `jenis_tinggal`, `alat_transportasi`, `telepon`, `hp`, `email`, `skhun`, `penerima_kps`, `no_kps`, `foto`, `nama_ayah`, `tahun_lahir_ayah`, `pendidikan_ayah`, `pekerjaan_ayah`, `penghasilan_ayah`, `kebutuhan_khusus_ayah`, `no_telpon_ayah`, `nama_ibu`, `tahun_lahir_ibu`, `pendidikan_ibu`, `pekerjaan_ibu`, `penghasilan_ibu`, `kebutuhan_khusus_ibu`, `no_telpon_ibu`, `nama_wali`, `tahun_lahir_wali`, `pendidikan_wali`, `pekerjaan_wali`, `penghasilan_wali`, `angkatan`, `status_awal`, `status_siswa`, `tingkat`, `kode_kelas`, `kode_jurusan`, `id_sesi`) VALUES
(1, '14422', 'siswa123', 'Siswa Smart', 1, '12345678', 'jakarta', '1999-11-14', '1306066910090000', 1, 'Tidak ada', 'Jatinegara Barat', '09', '10', 'Bali Mester', 'Bali Mester', 'Jatinegara', 13310, '', 'Sepeda motor', '0751-7835083', '082385418021', 'AAD.SIROJUDIN04@GMAIL.COM', '2-12-02-002-002-7   ', 'TIDAK', '', '20231012213430-own.jpg', 'WASLIM', 1968, 'SMP / sederajat', 'Lainnya', 'Rp. 1,000,000 - Rp. 1,999,999', 'Tidak ada', '', 'TETI MURNI', 1973, 'SMP / sederajat', 'Tidak bekerja', '', 'Tidak ada', '', '', 1900, '', '', '', 2023, 'Baru', 'Aktif', '(SLTA)', 'X.MIPA.1', 'MIPA', 1),
(63, '14423', '0151379251', 'AL FAJRI', 1, '0151379251', 'Bandung', '2015-06-27', '1375012610990000', 1, 'Tidak ada', 'JALAN PANORAMA NO 4B', '4', '2', '', 'PANORAMA', 'tebet timur', 12220, 'Bersama orang tua', 'Angkutan umum', '75221487', '085766422330', 'AYI.ALFAJRI@YAHOO.COM', '2-12-02-001-007-2   ', 'TIDAK', '', '', 'EFDIWARMAN', 1964, 'SMA / sederajat', 'Wiraswasta', 'Rp. 2,000,000 - Rp. 4,999,999', 'Tidak ada', '', 'ASYULIANTI', 1969, 'SMA / sederajat', '', 'Rp. 2,000,000 - Rp. 4,999,999', 'Tidak ada', '', '', 1900, '', '', '', 2023, 'Baru', 'Aktif', '(SLTA)', 'X.MIPA.1', 'MIPA', 1),
(105, '14424', '0004107204', 'ANDRE THOMOK SIDABUTAR', 1, '0004107204', 'LUBUK BASUNG', '2000-05-16', '', 1, 'Tidak ada', 'MANGGIS GANTING', '0', '0', '', 'MANGGIS', 'Kec. Mandiangin Koto Selayan', 0, 'Bersama orang tua', 'Angkutan umum/bus/pete-pete', '', '', '', '2/12/2002', 'TIDAK', '', '', 'UNTUNG SARAGI SIDABUTAR', 1966, 'SMA / sederajat', 'PNS/TNI/Polri', 'Rp. 2,000,000 - Rp. 4,999,999', 'Tidak ada', '', 'RONA TAMPUBOLON', 1977, 'SMA / sederajat', 'Tidak bekerja', '', 'Tidak ada', '', '', 1900, '', '', '', 2023, 'Baru', 'Aktif', '(SLTA)', 'X.MIPA.1', 'MIPA', 1),
(143, '14425', '9998218087', 'ANNISA SERLINA', 2, '9998218087', 'PEKAN KAMIS', '2000-10-15', '1306095510000000', 1, 'Tidak ada', 'GANTING KOTO TANGAN', '0', '0', 'KOTO TANGAH', 'KOTO TANGAH', 'Kec. Tilatang Kamang', 0, 'Bersama orang tua', 'Angkutan umum/bus/pete-pete', '', '083180361912', '', '2/12/2002', 'TIDAK', '', '', 'NOVIARDI', 1965, 'SMA / sederajat', 'Petani', 'Rp. 500,000 - Rp. 999,999', 'Tidak ada', '', 'SESNIAR', 1966, 'SMA / sederajat', 'Lainnya', 'Rp. 500,000 - Rp. 999,999', 'Tidak ada', '', '', 1900, '', '', '', 2023, 'Baru', 'Aktif', '(SLTA)', 'X.MIPA.1', 'MIPA', 1),
(214, '14426', '0007105659', 'DAVIN FERDIANSYAH', 1, '0007105659', 'PADANG', '2000-09-06', '1312060609020000', 1, 'Tidak ada', 'JORONG KAMPUNG ALANG', '0', '0', '', 'MUARO KIAWAI', 'Kec. Gunung Tuleh', 26371, 'Kost', 'Angkutan umum/bus/pete-pete', '', '', '', '2/12/2002', 'TIDAK', '', '', 'SYAHRIAL', 1962, 'S1', 'PNS/TNI/Polri', 'Rp. 5,000,000 - Rp. 20,000,000', 'Tidak ada', '', 'DESMINAR', 1965, 'S1', 'PNS/TNI/Polri', 'Rp. 2,000,000 - Rp. 4,999,999', 'Tidak ada', '', '', 1900, '', '', '', 2023, 'Baru', 'Aktif', '(SLTA)', 'X.MIPA.1', 'MIPA', 1),
(242, '14427', '0000267795', 'DHINDA AMALIA KIFLIA', 2, '0000267795', 'Bukittinggi', '2000-03-01', '1375034103000000', 1, 'Tidak ada', 'JL.Puding Mas no.33-Tabek Gadang-Aur Kuning-Bukittinggi', '1', '2', 'Tabek Gadang', 'Aur Kuning', 'Kec. Aur Birugo Tigo Baleh', 0, 'Bersama orang tua', 'Angkutan umum/bus/pete-pete', '0752-31089', '081261631384', 'dhindaamaliakiflianainggolan@yahoo.co.id', '2/12/2002', 'TIDAK', '', '', 'Zulkifli Nainggolan', 1966, 'SMA / sederajat', 'Wiraswasta', 'Rp. 1,000,000 - Rp. 1,999,999', 'Tidak ada', '', 'Delfiani', 1972, 'SMA / sederajat', 'Tidak bekerja', '', 'Tidak ada', '', '', 1900, '', '', '', 2023, 'Baru', 'Aktif', '(SLTA)', 'X.MIPA.1', 'MIPA', 1),
(335, '14428', '0007011100', 'FARID NAJAH ALDI', 1, '0007011100', 'Jakarta', '2000-04-12', '1306071204000000', 1, 'Tidak ada', 'Tanah  Nyariang', '0', '0', '', 'Batu Taba', 'Kec. Ampek Angkek', 0, 'Bersama orang tua', '', '', '085263312034', '', '2/12/2002', 'TIDAK', '', '', 'endrisman', 1971, 'SMA / sederajat', 'Wiraswasta', 'Rp. 500,000 - Rp. 999,999', 'Tidak ada', '', 'Reni', 1972, 'D1', 'Tidak bekerja', '', 'Tidak ada', '', '', 1900, '', '', '', 2023, 'Baru', 'Aktif', '(SLTA)', 'X.MIPA.1', 'MIPA', 1),
(369, '14429', '0000261160', 'FELLYA KHAIRANI MONEVY', 2, '0000261160', 'BUKITTINGGI', '2000-07-07', '1306074707000000', 1, 'Tidak ada', 'JORONG PARIT PUTUS,NAGARI AMPANG GADANG,Kec.AMPEK ANGKEK,Kab.AGAM', '0', '0', 'PARIT PUTUS', 'AMPANG GADANG', 'Kec. Ampek Angkek', 0, 'Bersama orang tua', 'Sepeda motor', '', '089629288677', 'FELLYAKHAIRANIMONEVY@YAHOO.co.id', '2-12-02-            ', 'TIDAK', '', '', 'MEDMON HAIKAL', 1969, 'S1', 'PNS/TNI/Polri', 'Rp. 2,000,000 - Rp. 4,999,999', 'Tidak ada', '', 'EVI YENDRIANI', 1975, 'SMA / sederajat', 'Tidak bekerja', '', 'Tidak ada', '', '', 1900, '', '', '', 2023, 'Baru', 'Aktif', '(SLTA)', 'X.MIPA.1', 'MIPA', 1),
(378, '14430', '9991261263', 'FERNANDO PRATAMA', 1, '9991261263', 'BUKITTINGGI', '1999-11-08', '1306060811990000', 1, 'Tidak ada', 'JLN.BANUHAMPU RAYA NO.246 PERUMNAS KUBANG PUTIH', '0', '0', '', 'KUBANG PUTIH', 'Kec. Banuhampu', 26181, 'Bersama orang tua', 'Angkutan umum/bus/pete-pete', '0752-7835136', '08126695672', '', '2/12/2002', 'TIDAK', '', '', 'MUKHLIS', 1970, 'SMA / sederajat', 'Wiraswasta', 'Rp. 5,000,000 - Rp. 20,000,000', 'Tidak ada', '', 'NENY FEBRIDAL', 1974, 'SMA / sederajat', 'Tidak bekerja', '', 'Tidak ada', '', '', 1900, '', '', '', 2023, 'Baru', 'Aktif', '(SLTA)', 'X.MIPA.1', 'MIPA', 1),
(1273, '4343244', 'siswa123', 'Siswa Smart bright', 2, '2232322', 'Bekasi', '0000-00-00', '323232323232323', 1, '', 'Perum Graha Harapan Blok A8/No.12', '00', '00', 'Kabupaten Bekasi', 'Kabupaten Bekasi', 'Kabupaten Bekasi', 17158, 'Rumah', 'Jalan kaki', '07775656565', '89676777777', 'mail2bejosutrisno@gmail.com', '34', 'YA', '45454', '20231012075026-man.jpeg', 'Jono sucipto', 1975, 's2', 'Dosen', 'Rp. 01,000,000 - Rp. 10,999,999', '', '', 'Jenny Lupita', 1980, 'SMA', 'Instruktur Senam', '10000000', '', '08889399393', 'Jenny Lupita', 1977, 'SMA', 'Instruktur Senam', '10000000', 2023, 'Baru', 'Aktif', '', 'X.MIPA.1', 'MIPA', 0),
(1274, '222301001', 'rahasia123', 'Pratama', 1, '0081234567', 'Sinjai', '2010-05-15', '7307011234560001', 1, 'Tidak Ada', 'Jl. Pendidikan No. 45', '02', '05', 'Arango', 'Arabika', 'Sinjai Barat', 92611, 'Bersama Orang Tua', 'Motor', '048212345', '081234567890', 'andi.p@example.com', '1-22-33-44-555', 'Tidak', '-', '20260407200834-Frame 3.png', '', 0, '', '', '', '', '', '', 0, '', '', '', '', '', '', 0, '', '', '', 2026, 'Siswa', 'Aktif', '', 'X-1', 'MIPA', 0);

-- --------------------------------------------------------

--
-- Table structure for table `rb_sms`
--

CREATE TABLE `rb_sms` (
  `id_sms` int(5) NOT NULL,
  `nohp` varchar(15) NOT NULL,
  `pesan` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_sms`
--

INSERT INTO `rb_sms` (`id_sms`, `nohp`, `pesan`) VALUES
(6, '08159781395', 'tes ya'),
(7, '6289652885753', 'tes'),
(8, '08159781395', 'etrtrgfgfgdgdfdgff'),
(9, '628159781395', 'dgdgdfdsfsd'),
(10, '08889399393', 'Diberitahukan kepada Yth Bpk/Ibk, Bahwa anak anda Siswa Smart bright, Kelas X IPA 1 absensi Hari ini Tanggal 12-10-2023 : Sakit');

-- --------------------------------------------------------

--
-- Table structure for table `rb_sms_autoreply`
--

CREATE TABLE `rb_sms_autoreply` (
  `id_autoreply` int(5) NOT NULL,
  `keyword` varchar(100) NOT NULL,
  `isi_pesan` text NOT NULL,
  `waktu` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_sms_autoreply`
--

INSERT INTO `rb_sms_autoreply` (`id_autoreply`, `keyword`, `isi_pesan`, `waktu`) VALUES
(1, 'REG INFO', 'Diharapkan kepada semua orang tua lebih memperhatikan pergaulan anak-anaknya.', '2016-04-23 08:16:22'),
(2, 'REG KEGIATAN', 'Kegiatan Pramuka 27-04-2016, Kegiatan Paskibra 12-05-2016, Kegiatan Maraton Bersama Guru 16-05-2016.', '2016-04-23 09:23:34');

-- --------------------------------------------------------

--
-- Table structure for table `rb_sms_inbox`
--

CREATE TABLE `rb_sms_inbox` (
  `id` int(11) NOT NULL,
  `pesan` text DEFAULT NULL,
  `nohp` varchar(20) DEFAULT NULL,
  `waktu` datetime DEFAULT NULL,
  `modem` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rb_sms_outbox`
--

CREATE TABLE `rb_sms_outbox` (
  `id_outbox` int(5) NOT NULL,
  `nohp` varchar(20) NOT NULL,
  `pesan` text NOT NULL,
  `waktu` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rb_status_keaktifan`
--

CREATE TABLE `rb_status_keaktifan` (
  `id_status_keaktifan` int(5) NOT NULL,
  `nama_status_keaktifan` varchar(255) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_status_keaktifan`
--

INSERT INTO `rb_status_keaktifan` (`id_status_keaktifan`, `nama_status_keaktifan`, `keterangan`) VALUES
(1, 'Aktif', ''),
(2, 'Tidak Aktif', '');

-- --------------------------------------------------------

--
-- Table structure for table `rb_status_kepegawaian`
--

CREATE TABLE `rb_status_kepegawaian` (
  `id_status_kepegawaian` int(5) NOT NULL,
  `status_kepegawaian` varchar(255) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_status_kepegawaian`
--

INSERT INTO `rb_status_kepegawaian` (`id_status_kepegawaian`, `status_kepegawaian`, `keterangan`) VALUES
(1, 'Tenaga Honorer', ''),
(2, 'Guru Honorer', ''),
(3, 'PNS\r\n', ''),
(4, 'GTY/PTY\r\n', ''),
(5, 'CPNS\r\n', '');

-- --------------------------------------------------------

--
-- Table structure for table `rb_status_pernikahan`
--

CREATE TABLE `rb_status_pernikahan` (
  `id_status_pernikahan` int(5) NOT NULL,
  `status_pernikahan` varchar(150) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_status_pernikahan`
--

INSERT INTO `rb_status_pernikahan` (`id_status_pernikahan`, `status_pernikahan`, `keterangan`) VALUES
(1, 'Menikah', ''),
(2, 'Belum Menikah', '');

-- --------------------------------------------------------

--
-- Table structure for table `rb_tahun_akademik`
--

CREATE TABLE `rb_tahun_akademik` (
  `id_tahun_akademik` int(5) NOT NULL,
  `nama_tahun` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `aktif` enum('Ya','Tidak') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_tahun_akademik`
--

INSERT INTO `rb_tahun_akademik` (`id_tahun_akademik`, `nama_tahun`, `keterangan`, `aktif`) VALUES
(20231, 'Semester Ganjil 2023/2024', '2023/2024', 'Ya'),
(20221, 'Semester Ganjil 2022/2023', '2022/2023', 'Ya'),
(20222, 'Semester Genap 2022/2023', '2022/2023', 'Ya'),
(2026, 'SEMESTER GENAP 2026 / 2027', '2026 / 2027', 'Ya');

-- --------------------------------------------------------

--
-- Table structure for table `rb_users`
--

CREATE TABLE `rb_users` (
  `id_user` int(5) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_telpon` varchar(15) NOT NULL,
  `jabatan` varchar(150) NOT NULL,
  `level` varchar(20) NOT NULL DEFAULT 'sekolah',
  `aktif` enum('Y','N') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `rb_users`
--

INSERT INTO `rb_users` (`id_user`, `username`, `password`, `nama_lengkap`, `email`, `no_telpon`, `jabatan`, `level`, `aktif`) VALUES
(1, 'admin', 'bff0cc42103de1b4721370e84dc24f635a7afeca41198c9b3e03946a1b6b7191d14356408a5e57ce6daf77e6e800c66fac7ab0482d57d48d23e6808e4b562daa', 'Administrator', 'alfajrininsani@gmail.com', '081234567879', 'Kepala IT', 'superuser', 'Y'),
(2, '196209051987031007', 'a6185fdc86a220b07d055de71d74d569261a3db2c408b06955bdac382c581f08105a7205988980a5f445fe34dbe884389ed6c89674d0a05bd3c8b58c82b43746', 'Dr. Hermawan kartasana, M.Pd', 'hermawan@gmail.com', '082173054522', 'Kepala Sekolah', 'kepala', 'Y'),
(107, 'admin', 'edbd881f1ee2f76ba0bd70fd184f87711be991a0401fd07ccd4b199665f00761afc91731d8d8ba6cbb188b2ed5bfb465b9f3d30231eb0430b9f90fe91d136648', 'Admin TU', 'admin@rumahnet.id', '089652885753', 'Kabag Administator', 'superuser', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `rb_users_aktivitas`
--

CREATE TABLE `rb_users_aktivitas` (
  `id_users_aktivitas` int(10) NOT NULL,
  `identitas` varchar(50) NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `browser` varchar(50) NOT NULL,
  `os` varchar(50) NOT NULL,
  `status` enum('siswa','guru','superuser') NOT NULL,
  `jam` time NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rb_users_aktivitas`
--

INSERT INTO `rb_users_aktivitas` (`id_users_aktivitas`, `identitas`, `ip_address`, `browser`, `os`, `status`, `jam`, `tanggal`) VALUES
(1, '195704111980032004', '::1', 'Chrome 49.0.2623.112', 'Windows 7', 'guru', '10:59:57', '2016-04-13'),
(2, '9991268756', '::1', 'Chrome 49.0.2623.112', 'Windows 7', 'siswa', '11:00:27', '2016-04-13'),
(3, '9994030915', '::1', 'Chrome 49.0.2623.112', 'Windows 7', 'siswa', '11:01:44', '2016-04-14'),
(4, '9975540740', '::1', 'Chrome 49.0.2623.112', 'Windows 7', 'siswa', '11:20:43', '2016-04-14'),
(5, '195901241986032002', '::1', 'Chrome 49.0.2623.112', 'Windows 7', 'guru', '11:21:04', '2016-04-14'),
(6, '0006223671', '::1', 'Chrome 49.0.2623.112', 'Windows 7', 'siswa', '12:18:06', '2016-04-15'),
(7, '195912121986021004', '::1', 'Chrome 49.0.2623.112', 'Windows 7', 'guru', '12:18:32', '2016-04-15'),
(8, '197110292005011003', '::1', 'Chrome 49.0.2623.112', 'Windows 7', 'guru', '12:18:40', '2016-04-15'),
(9, '196109191988031006', '::1', 'Chrome 49.0.2623.112', 'Windows 7', 'guru', '12:18:49', '2016-04-16'),
(10, '196202191990032001', '::1', 'Chrome 49.0.2623.112', 'Windows 7', 'guru', '12:19:02', '2016-04-16'),
(11, '9999344284', '::1', 'Chrome 49.0.2623.112', 'Windows 7', 'siswa', '12:19:24', '2016-04-16'),
(12, '9980725248', '::1', 'Chrome 49.0.2623.112', 'Windows 7', 'siswa', '12:19:32', '2016-04-16'),
(13, '0006223671', '::1', 'Chrome 49.0.2623.112', 'Windows 7', 'siswa', '12:19:42', '2016-04-16'),
(14, '2', '', ' Chrome 49.0.2623.112', 'Windows 7', 'guru', '06:13:43', '2016-04-23'),
(15, '195704111980032004', '::1', 'Chrome 49.0.2623.112', 'Windows 7', 'guru', '06:15:28', '2016-04-23'),
(16, '1', '', ' Chrome 49.0.2623.112', 'Windows 7', 'superuser', '06:27:20', '2016-04-23'),
(17, '195704111980032004', '::1', 'Chrome 49.0.2623.112', 'Windows 7', 'guru', '06:34:28', '2016-04-23'),
(18, '9980708111', '::1', 'Chrome 49.0.2623.112', 'Windows 7', 'siswa', '06:36:21', '2016-04-23'),
(19, '195704111980032004', '::1', 'Chrome 49.0.2623.112', 'Windows 7', 'guru', '06:37:05', '2016-04-23'),
(20, '9994030915', '::1', 'Chrome 49.0.2623.112', 'Windows 7', 'siswa', '06:41:40', '2016-04-23'),
(21, '195704111980032004', '::1', 'Chrome 49.0.2623.112', 'Windows 7', 'guru', '06:43:49', '2016-04-23'),
(22, '9991268756', '::1', 'Firefox 46.0', 'Windows 7', 'siswa', '06:46:06', '2016-04-23'),
(23, '1', '', ' Chrome 49.0.2623.112', 'Windows 7', 'superuser', '07:02:03', '2016-04-23'),
(24, '9980708111', '::1', 'Chrome 49.0.2623.112', 'Windows 7', 'siswa', '07:21:03', '2016-04-23'),
(25, '9980720559', '::1', 'Chrome 49.0.2623.112', 'Windows 7', 'siswa', '07:21:21', '2016-04-23'),
(26, '9991268756', '::1', 'Chrome 49.0.2623.112', 'Windows 7', 'siswa', '07:22:01', '2016-04-23'),
(27, '9999152999', '::1', 'Chrome 49.0.2623.112', 'Windows 7', 'siswa', '07:29:17', '2016-04-23'),
(28, '195704111980032004', '::1', 'Chrome 49.0.2623.112', 'Windows 7', 'guru', '08:40:14', '2016-04-23'),
(29, '1', '', 'Chrome 49.0.2623.112', 'Windows 7', 'superuser', '08:45:52', '2016-04-23'),
(30, '1', '::1', 'Chrome 49.0.2623.112', 'Windows 7', 'superuser', '06:13:18', '2016-04-16'),
(31, '1', '::1', 'Chrome 49.0.2623.112', 'Windows 7', 'superuser', '03:12:26', '2016-04-15'),
(32, '1', '::1', 'Chrome 49.0.2623.112', 'Windows 7', 'superuser', '06:13:18', '2016-04-14'),
(33, '1', '::1', 'Chrome 49.0.2623.112', 'Windows 7', 'superuser', '03:12:26', '2016-04-13'),
(34, '1', '::1', 'Chrome 49.0.2623.112', 'Windows 7', 'superuser', '07:13:18', '2016-04-14'),
(35, '1', '::1', 'Chrome 49.0.2623.112', 'Windows 7', 'superuser', '05:12:26', '2016-04-13'),
(36, '1', '36.68.12.49', 'Chrome 49.0.2623.112', 'Windows 7', 'superuser', '10:32:19', '2016-04-23'),
(48, '1', '114.4.79.250', 'Chrome 50.0.2661.87', 'Windows 7', 'superuser', '15:08:36', '2016-04-27'),
(47, '1', '36.84.224.134', 'Chrome 50.0.2661.87', 'Windows 7', 'superuser', '10:17:00', '2016-04-27'),
(40, '195704111980032004', '114.4.21.153', 'Chrome 50.0.2661.87', 'Windows 7', 'guru', '07:50:45', '2016-04-27'),
(41, '1', '114.4.21.153', 'Chrome 50.0.2661.87', 'Windows 7', 'superuser', '07:54:08', '2016-04-27'),
(42, '9980708111', '114.4.21.153', 'Chrome 50.0.2661.87', 'Windows 7', 'siswa', '07:55:08', '2016-04-27'),
(43, '9980722436', '114.4.21.153', 'Chrome 50.0.2661.87', 'Windows 7', 'siswa', '07:55:23', '2016-04-27'),
(44, '198605012009011001', '114.4.21.153', 'Chrome 50.0.2661.87', 'Windows 7', 'guru', '07:55:38', '2016-04-27'),
(45, '1', '114.4.21.153', 'Chrome 50.0.2661.87', 'Windows 7', 'superuser', '07:55:51', '2016-04-27'),
(46, '1', '114.4.21.153', 'Chrome 50.0.2661.87', 'Windows 7', 'superuser', '08:01:10', '2016-04-27'),
(49, '1', '::1', 'Chrome 50.0.2661.87', 'Windows 7', 'superuser', '20:16:59', '2016-04-27'),
(50, '1', '::1', 'Chrome 50.0.2661.87', 'Windows 7', 'superuser', '08:27:54', '2016-04-28'),
(51, '198710052010012011', '::1', 'Chrome 50.0.2661.87', 'Windows 7', 'guru', '10:41:56', '2016-04-28'),
(52, '195704111980032004', '::1', 'Chrome 50.0.2661.87', 'Windows 7', 'guru', '10:42:15', '2016-04-28'),
(53, '1', '::1', 'Chrome 50.0.2661.87', 'Windows 7', 'superuser', '13:12:06', '2016-04-28'),
(54, '9991268756', '::1', 'Chrome 50.0.2661.87', 'Windows 7', 'siswa', '13:30:48', '2016-04-28'),
(55, '1', '::1', 'Chrome 50.0.2661.87', 'Windows 7', 'superuser', '19:15:10', '2016-04-28'),
(56, '1', '::1', 'Chrome 50.0.2661.87', 'Windows 7', 'superuser', '10:02:22', '2016-04-29'),
(57, '195806161984000001', '::1', 'Chrome 50.0.2661.87', 'Windows 7', 'guru', '22:37:57', '2016-04-29'),
(58, '9991268756', '::1', 'Chrome 50.0.2661.87', 'Windows 7', 'siswa', '22:41:40', '2016-04-29'),
(59, '1', '::1', 'Chrome 50.0.2661.87', 'Windows 7', 'superuser', '23:09:20', '2016-04-29'),
(60, '1', '::1', 'Chrome 50.0.2661.87', 'Windows 7', 'superuser', '23:20:06', '2016-04-29'),
(61, '195704111980032004', '::1', 'Chrome 50.0.2661.87', 'Windows 7', 'guru', '06:14:36', '2016-04-30'),
(62, '1', '::1', 'Chrome 50.0.2661.87', 'Windows 7', 'superuser', '06:14:55', '2016-04-30'),
(63, '195806161984000001', '::1', 'Chrome 50.0.2661.87', 'Windows 7', 'guru', '06:18:35', '2016-04-30'),
(64, '195806161984000001', '::1', 'Chrome 50.0.2661.87', 'Windows 7', 'guru', '06:19:47', '2016-04-30'),
(65, '1', '::1', 'Chrome 50.0.2661.87', 'Windows 7', 'superuser', '10:00:28', '2016-04-30'),
(66, '9991268756', '::1', 'Chrome 50.0.2661.87', 'Windows 7', 'siswa', '10:01:25', '2016-04-30'),
(67, '1', '::1', 'Chrome 50.0.2661.87', 'Windows 7', 'superuser', '10:01:44', '2016-04-30'),
(68, '2', '::1', 'Chrome 50.0.2661.87', 'Windows 7', '', '10:02:29', '2016-04-30'),
(69, '196209051987031007', '::1', 'Chrome 50.0.2661.87', 'Windows 7', 'guru', '10:02:51', '2016-04-30'),
(70, '1', '::1', 'Chrome 50.0.2661.87', 'Windows 7', 'superuser', '10:37:52', '2016-04-30'),
(71, '195806161984000001', '::1', 'Chrome 50.0.2661.87', 'Windows 7', 'guru', '10:58:18', '2016-04-30'),
(72, '1', '::1', 'Chrome 50.0.2661.87', 'Windows 7', 'superuser', '12:57:17', '2016-04-30'),
(74, '1', '::1', 'Chrome 50.0.2661.94', 'Windows 7', 'superuser', '20:17:11', '2016-05-04'),
(75, '1', '::1', 'Chrome 50.0.2661.94', 'Windows 7', 'superuser', '22:34:59', '2016-05-11'),
(76, '1', '::1', 'Chrome 50.0.2661.102', 'Windows 7', 'superuser', '07:21:10', '2016-06-02'),
(77, '1', '::1', 'Chrome 51.0.2704.103', 'Windows 7', 'superuser', '22:52:32', '2016-06-19'),
(78, '1', '::1', 'Chrome 51.0.2704.103', 'Windows 7', 'superuser', '15:06:29', '2016-06-22'),
(79, '1', '::1', 'Chrome 51.0.2704.103', 'Windows 7', 'superuser', '15:45:59', '2016-06-22'),
(80, '1', '::1', 'Chrome 51.0.2704.103', 'Windows 7', 'superuser', '07:40:52', '2016-06-23'),
(81, '1', '::1', 'Chrome 51.0.2704.103', 'Windows 7', 'superuser', '11:41:34', '2016-06-23'),
(82, '9991268756', '::1', 'Chrome 51.0.2704.103', 'Windows 7', 'siswa', '04:56:37', '2016-06-29'),
(83, '1', '::1', 'Chrome 51.0.2704.103', 'Windows 7', 'superuser', '08:46:48', '2016-07-01'),
(84, '1', '::1', 'Chrome 51.0.2704.103', 'Windows 7', 'superuser', '15:32:49', '2016-07-02'),
(85, '1', '::1', 'Chrome 51.0.2704.103', 'Windows 7', 'superuser', '06:37:49', '2016-07-03'),
(86, '1', '::1', 'Chrome 51.0.2704.103', 'Windows 7', 'superuser', '11:24:00', '2016-07-04'),
(87, '9991268756', '::1', 'Chrome 51.0.2704.103', 'Windows 7', 'siswa', '12:24:55', '2016-07-04'),
(88, '1', '::1', 'Chrome 51.0.2704.103', 'Windows 7', 'superuser', '13:38:17', '2016-07-04'),
(89, '1', '::1', 'Chrome 51.0.2704.103', 'Windows 7', 'superuser', '16:41:51', '2016-07-04'),
(90, '1', '::1', 'Chrome 51.0.2704.103', 'Windows 7', 'superuser', '05:45:25', '2016-07-05'),
(91, '195704111980032004', '::1', 'Chrome 51.0.2704.103', 'Windows 7', 'guru', '09:59:50', '2016-07-05'),
(92, '1', '::1', 'Chrome 51.0.2704.103', 'Windows 7', 'superuser', '10:12:22', '2016-07-05'),
(93, '1', '::1', 'Chrome 51.0.2704.103', 'Windows 7', 'superuser', '10:34:34', '2016-07-05'),
(94, '1', '::1', 'Chrome 51.0.2704.103', 'Windows 7', 'superuser', '08:09:08', '2016-07-08'),
(95, '195806161984000002', '::1', 'Chrome 51.0.2704.103', 'Windows 7', 'guru', '11:15:49', '2016-07-08'),
(96, '1', '::1', 'Chrome 51.0.2704.103', 'Windows 7', 'superuser', '11:32:28', '2016-07-08'),
(97, '1', '::1', 'Chrome 51.0.2704.103', 'Windows 7', 'superuser', '13:30:18', '2016-07-08'),
(98, '9991268756', '::1', 'Chrome 51.0.2704.103', 'Windows 7', 'siswa', '13:31:00', '2016-07-08'),
(99, '1', '::1', 'Chrome 51.0.2704.103', 'Windows 7', 'superuser', '13:49:22', '2016-07-08'),
(100, '9991268756', '::1', 'Chrome 51.0.2704.103', 'Windows 7', 'siswa', '13:50:02', '2016-07-08'),
(101, '1', '::1', 'Chrome 51.0.2704.103', 'Windows 7', 'superuser', '15:27:03', '2016-07-08'),
(102, '9991268756', '::1', 'Chrome 51.0.2704.103', 'Windows 7', 'siswa', '15:54:51', '2016-07-08'),
(103, '1', '::1', 'Chrome 51.0.2704.103', 'Windows 7', 'superuser', '05:36:38', '2016-07-09'),
(104, '9991268756', '::1', 'Chrome 51.0.2704.103', 'Windows 7', 'siswa', '06:12:14', '2016-07-09'),
(105, '2', '::1', 'Chrome 51.0.2704.103', 'Windows 7', '', '06:18:50', '2016-07-09'),
(106, '1', '::1', 'Chrome 51.0.2704.103', 'Windows 7', 'superuser', '06:27:53', '2016-07-09'),
(107, '1', '::1', 'Chrome 51.0.2704.103', 'Windows 7', 'superuser', '06:57:52', '2016-07-09'),
(108, '195806161984000002', '::1', 'Chrome 51.0.2704.103', 'Windows 7', 'guru', '07:01:50', '2016-07-09'),
(109, '1', '::1', 'Chrome 51.0.2704.103', 'Windows 7', 'superuser', '05:41:14', '2016-07-10'),
(110, '1', '::1', 'Chrome 117.0.0.0', 'Windows 10', 'superuser', '22:29:51', '2023-10-09'),
(111, '1', '::1', 'Chrome 117.0.0.0', 'Windows 10', 'superuser', '23:05:39', '2023-10-09'),
(112, '1', '::1', 'Chrome 117.0.0.0', 'Windows 10', 'superuser', '09:29:41', '2023-10-10'),
(113, '1', '::1', 'Chrome 117.0.0.0', 'Windows 10', 'superuser', '05:09:20', '2023-10-11'),
(114, '2232322', '::1', 'Chrome 117.0.0.0', 'Windows 10', 'siswa', '06:53:31', '2023-10-11'),
(115, '1', '::1', 'Chrome 117.0.0.0', 'Windows 10', 'superuser', '10:57:01', '2023-10-11'),
(116, '1', '::1', 'Chrome 117.0.0.0', 'Windows 10', 'superuser', '11:18:56', '2023-10-11'),
(117, '1', '::1', 'Chrome 117.0.0.0', 'Windows 10', 'superuser', '19:57:43', '2023-10-11'),
(118, '2', '::1', 'Chrome 117.0.0.0', 'Windows 10', '', '20:16:24', '2023-10-11'),
(119, '197110292005011003', '::1', 'Chrome 117.0.0.0', 'Windows 10', 'guru', '20:19:36', '2023-10-11'),
(120, '1', '::1', 'Chrome 117.0.0.0', 'Windows 10', 'superuser', '20:29:44', '2023-10-11'),
(121, '197110292005011003', '::1', 'Chrome 117.0.0.0', 'Windows 10', 'guru', '20:31:12', '2023-10-11'),
(122, '2232322', '::1', 'Chrome 117.0.0.0', 'Windows 10', 'siswa', '20:38:01', '2023-10-11'),
(123, '2', '::1', 'Chrome 117.0.0.0', 'Windows 10', '', '22:29:03', '2023-10-11'),
(124, '1', '::1', 'Chrome 117.0.0.0', 'Windows 10', 'superuser', '05:52:56', '2023-10-12'),
(125, '1', '::1', 'Chrome 117.0.0.0', 'Windows 10', 'superuser', '07:17:38', '2023-10-12'),
(126, '2232322', '::1', 'Chrome 117.0.0.0', 'Windows 10', 'siswa', '07:56:15', '2023-10-12'),
(127, '1', '::1', 'Chrome 118.0.0.0', 'Windows 10', 'superuser', '14:01:00', '2023-10-12'),
(128, '2232322', '::1', 'Chrome 118.0.0.0', 'Windows 10', 'siswa', '15:01:25', '2023-10-12'),
(129, '202311111101', '::1', 'Chrome 118.0.0.0', 'Windows 10', 'guru', '15:09:43', '2023-10-12'),
(130, '1', '::1', 'Chrome 118.0.0.0', 'Windows 10', 'superuser', '21:28:08', '2023-10-12'),
(131, '202311111101', '::1', 'Chrome 118.0.0.0', 'Windows 10', 'guru', '21:29:02', '2023-10-12'),
(132, '12345678', '::1', 'Chrome 118.0.0.0', 'Windows 10', 'siswa', '21:33:55', '2023-10-12'),
(133, '2', '::1', 'Chrome 118.0.0.0', 'Windows 10', '', '21:36:12', '2023-10-12'),
(134, '202311111110', '::1', 'Chrome 118.0.0.0', 'Windows 10', 'guru', '21:40:44', '2023-10-12'),
(135, '107', '::1', 'Chrome 118.0.0.0', 'Windows 10', 'superuser', '21:45:29', '2023-10-12'),
(136, '1', '::1', 'Chrome 143.0.0.0', 'Windows 10', 'superuser', '00:12:30', '2025-12-12'),
(137, '202311111101', '::1', 'Chrome 143.0.0.0', 'Windows 10', 'guru', '00:13:34', '2025-12-12'),
(138, '1', '::1', 'Chrome 143.0.0.0', 'Windows 10', 'superuser', '00:14:48', '2025-12-12'),
(139, '1', '::1', 'Chrome 143.0.0.0', 'Windows 10', 'superuser', '00:27:11', '2025-12-12'),
(140, '1', '::1', 'Chrome 143.0.0.0', 'Windows 10', 'superuser', '00:30:20', '2025-12-12'),
(141, '1', '::1', 'Chrome 143.0.0.0', 'Windows 10', 'superuser', '00:47:06', '2025-12-12'),
(142, '2', '::1', 'Chrome 143.0.0.0', 'Windows 10', '', '00:52:26', '2025-12-12'),
(143, '1', '::1', 'Chrome 143.0.0.0', 'Windows 10', 'superuser', '02:11:59', '2025-12-12'),
(144, '202311111101', '::1', 'Chrome 143.0.0.0', 'Windows 10', 'guru', '02:23:17', '2025-12-12'),
(145, '1', '::1', 'Chrome 143.0.0.0', 'Windows 10', 'superuser', '02:29:49', '2025-12-12'),
(146, '2', '::1', 'Chrome 143.0.0.0', 'Windows 10', '', '02:30:16', '2025-12-12'),
(147, '12345678', '::1', 'Chrome 143.0.0.0', 'Windows 10', 'siswa', '02:44:18', '2025-12-12'),
(148, '12345678', '::1', 'Chrome 143.0.0.0', 'Windows 10', 'siswa', '02:48:19', '2025-12-12'),
(149, '1', '::1', 'Chrome 143.0.0.0', 'Windows 10', 'superuser', '04:04:20', '2025-12-12'),
(150, '1', '::1', 'Chrome 143.0.0.0', 'Windows 10', 'superuser', '04:12:39', '2025-12-12'),
(151, '1', '::1', 'Chrome 143.0.0.0', 'Windows 10', 'superuser', '13:43:21', '2025-12-12'),
(152, '2', '::1', 'Chrome 143.0.0.0', 'Windows 10', '', '14:38:01', '2025-12-12'),
(153, '202311111101', '::1', 'Chrome 143.0.0.0', 'Windows 10', 'guru', '14:54:54', '2025-12-12'),
(154, '12345678', '::1', 'Chrome 143.0.0.0', 'Windows 10', 'siswa', '15:07:25', '2025-12-12'),
(155, '1', '::1', 'Chrome 143.0.0.0', 'Windows 10', 'superuser', '15:21:45', '2025-12-12'),
(156, '2', '::1', 'Chrome 143.0.0.0', 'Windows 10', '', '17:40:20', '2025-12-12'),
(157, '202311111101', '::1', 'Chrome 143.0.0.0', 'Windows 10', 'guru', '17:45:06', '2025-12-12'),
(158, '12345678', '::1', 'Chrome 143.0.0.0', 'Windows 10', 'siswa', '17:48:56', '2025-12-12'),
(159, '1', '::1', 'Chrome 143.0.0.0', 'Windows 10', 'superuser', '20:32:09', '2025-12-13'),
(160, '1', '::1', 'Chrome 143.0.0.0', 'Windows 10', 'superuser', '21:33:28', '2025-12-13'),
(161, '1', '::1', 'Chrome 143.0.0.0', 'Windows 10', 'superuser', '12:08:56', '2025-12-14'),
(162, '2', '::1', 'Chrome 143.0.0.0', 'Windows 10', '', '12:58:49', '2025-12-14'),
(163, '202311111101', '::1', 'Chrome 143.0.0.0', 'Windows 10', 'guru', '13:06:01', '2025-12-14'),
(164, '1', '::1', 'Chrome 143.0.0.0', 'Windows 10', 'superuser', '18:26:39', '2025-12-14'),
(165, '2', '::1', 'Chrome 143.0.0.0', 'Windows 10', '', '20:51:34', '2025-12-14'),
(166, '1', '::1', 'Chrome 143.0.0.0', 'Windows 10', 'superuser', '21:10:48', '2025-12-14'),
(167, '2', '::1', 'Chrome 143.0.0.0', 'Windows 10', '', '21:11:19', '2025-12-14'),
(168, '202311111101', '::1', 'Chrome 143.0.0.0', 'Windows 10', 'guru', '21:11:55', '2025-12-14'),
(169, '1', '::1', 'Chrome 143.0.0.0', 'Windows 10', 'superuser', '21:13:36', '2025-12-14'),
(170, '2', '::1', 'Chrome 143.0.0.0', 'Windows 10', '', '21:14:04', '2025-12-14'),
(171, '1', '::1', 'Chrome 143.0.0.0', 'Windows 10', 'superuser', '21:15:01', '2025-12-14'),
(172, '12345678', '::1', 'Chrome 143.0.0.0', 'Windows 10', 'siswa', '21:23:28', '2025-12-14'),
(173, '2', '::1', 'Chrome 143.0.0.0', 'Windows 10', '', '21:30:53', '2025-12-14'),
(174, '1', '::1', 'Chrome 143.0.0.0', 'Windows 10', 'superuser', '21:31:49', '2025-12-14'),
(175, '202311111101', '::1', 'Chrome 143.0.0.0', 'Windows 10', 'guru', '21:32:43', '2025-12-14'),
(176, '12345678', '::1', 'Chrome 143.0.0.0', 'Windows 10', 'siswa', '21:33:34', '2025-12-14'),
(177, '2', '::1', 'Chrome 143.0.0.0', 'Windows 10', '', '21:34:03', '2025-12-14'),
(178, '1', '::1', 'Chrome 143.0.0.0', 'Windows 10', 'superuser', '21:34:35', '2025-12-14'),
(179, '2', '::1', 'Chrome 143.0.0.0', 'Windows 10', '', '21:35:10', '2025-12-14'),
(180, '202311111101', '::1', 'Chrome 143.0.0.0', 'Windows 10', 'guru', '21:35:35', '2025-12-14'),
(181, '12345678', '::1', 'Chrome 143.0.0.0', 'Windows 10', 'siswa', '21:36:32', '2025-12-14'),
(182, '1', '::1', 'Chrome 143.0.0.0', 'Windows 10', 'superuser', '22:02:27', '2025-12-14'),
(183, '1', '::1', 'Chrome 143.0.0.0', 'Windows 10', 'superuser', '16:27:34', '2025-12-15'),
(184, '1', '::1', 'Chrome 143.0.0.0', 'Windows 10', 'superuser', '00:06:15', '2026-01-15'),
(185, '1', '::1', 'Chrome 145.0.0.0', 'Windows 10', 'superuser', '19:30:15', '2026-04-07'),
(186, '1', '::1', 'Chrome 145.0.0.0', 'Windows 10', 'superuser', '19:58:15', '2026-04-08'),
(187, '1', '::1', 'Chrome 145.0.0.0', 'Windows 10', 'superuser', '18:41:43', '2026-04-09'),
(188, '1', '::1', 'Chrome 145.0.0.0', 'Windows 10', 'superuser', '18:47:21', '2026-04-09'),
(189, '202311111101', '::1', 'Chrome 145.0.0.0', 'Windows 10', 'guru', '18:50:53', '2026-04-09'),
(190, '1', '::1', 'Chrome 145.0.0.0', 'Windows 10', 'superuser', '18:51:53', '2026-04-09'),
(191, '1', '::1', 'Chrome 145.0.0.0', 'Windows 10', 'superuser', '12:12:57', '2026-04-12'),
(192, '1', '::1', 'Chrome 145.0.0.0', 'Windows 10', 'superuser', '13:11:28', '2026-04-12'),
(193, '1', '::1', 'Chrome 145.0.0.0', 'Windows 10', 'superuser', '13:57:18', '2026-04-12'),
(194, '1', '::1', 'Chrome 145.0.0.0', 'Windows 10', 'superuser', '14:03:45', '2026-04-12'),
(195, '1', '::1', 'Chrome 145.0.0.0', 'Windows 10', 'superuser', '14:49:50', '2026-04-12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rb_absensi_guru`
--
ALTER TABLE `rb_absensi_guru`
  ADD PRIMARY KEY (`id_absensi_guru`);

--
-- Indexes for table `rb_absensi_siswa`
--
ALTER TABLE `rb_absensi_siswa`
  ADD PRIMARY KEY (`id_absensi_siswa`);

--
-- Indexes for table `rb_agama`
--
ALTER TABLE `rb_agama`
  ADD PRIMARY KEY (`id_agama`);

--
-- Indexes for table `rb_elearning`
--
ALTER TABLE `rb_elearning`
  ADD PRIMARY KEY (`id_elearning`);

--
-- Indexes for table `rb_elearning_jawab`
--
ALTER TABLE `rb_elearning_jawab`
  ADD PRIMARY KEY (`id_elearning_jawab`);

--
-- Indexes for table `rb_forum_komentar`
--
ALTER TABLE `rb_forum_komentar`
  ADD PRIMARY KEY (`id_forum_komentar`);

--
-- Indexes for table `rb_forum_topic`
--
ALTER TABLE `rb_forum_topic`
  ADD PRIMARY KEY (`id_forum_topic`);

--
-- Indexes for table `rb_gedung`
--
ALTER TABLE `rb_gedung`
  ADD PRIMARY KEY (`kode_gedung`);

--
-- Indexes for table `rb_golongan`
--
ALTER TABLE `rb_golongan`
  ADD PRIMARY KEY (`id_golongan`);

--
-- Indexes for table `rb_guru`
--
ALTER TABLE `rb_guru`
  ADD PRIMARY KEY (`nip`);

--
-- Indexes for table `rb_halaman`
--
ALTER TABLE `rb_halaman`
  ADD PRIMARY KEY (`id_halaman`);

--
-- Indexes for table `rb_identitas_sekolah`
--
ALTER TABLE `rb_identitas_sekolah`
  ADD PRIMARY KEY (`id_identitas_sekolah`);

--
-- Indexes for table `rb_jadwal_pelajaran`
--
ALTER TABLE `rb_jadwal_pelajaran`
  ADD PRIMARY KEY (`kodejdwl`);

--
-- Indexes for table `rb_jawaban_essai`
--
ALTER TABLE `rb_jawaban_essai`
  ADD PRIMARY KEY (`id_jawaban_essai`);

--
-- Indexes for table `rb_jawaban_objektif`
--
ALTER TABLE `rb_jawaban_objektif`
  ADD PRIMARY KEY (`id_jawaban_objektif`);

--
-- Indexes for table `rb_jenis_kelamin`
--
ALTER TABLE `rb_jenis_kelamin`
  ADD PRIMARY KEY (`id_jenis_kelamin`);

--
-- Indexes for table `rb_jenis_ptk`
--
ALTER TABLE `rb_jenis_ptk`
  ADD PRIMARY KEY (`id_jenis_ptk`);

--
-- Indexes for table `rb_journal_list`
--
ALTER TABLE `rb_journal_list`
  ADD PRIMARY KEY (`id_journal`);

--
-- Indexes for table `rb_jurusan`
--
ALTER TABLE `rb_jurusan`
  ADD PRIMARY KEY (`kode_jurusan`);

--
-- Indexes for table `rb_kategori_elearning`
--
ALTER TABLE `rb_kategori_elearning`
  ADD PRIMARY KEY (`id_kategori_elearning`);

--
-- Indexes for table `rb_kategori_quiz_ujian`
--
ALTER TABLE `rb_kategori_quiz_ujian`
  ADD PRIMARY KEY (`id_kategori_quiz_ujian`);

--
-- Indexes for table `rb_kehadiran`
--
ALTER TABLE `rb_kehadiran`
  ADD PRIMARY KEY (`kode_kehadiran`);

--
-- Indexes for table `rb_kelas`
--
ALTER TABLE `rb_kelas`
  ADD PRIMARY KEY (`kode_kelas`);

--
-- Indexes for table `rb_kelompok_mata_pelajaran`
--
ALTER TABLE `rb_kelompok_mata_pelajaran`
  ADD PRIMARY KEY (`id_kelompok_mata_pelajaran`);

--
-- Indexes for table `rb_kompetensi_dasar`
--
ALTER TABLE `rb_kompetensi_dasar`
  ADD PRIMARY KEY (`id_kompetensi_dasar`);

--
-- Indexes for table `rb_kurikulum`
--
ALTER TABLE `rb_kurikulum`
  ADD PRIMARY KEY (`kode_kurikulum`);

--
-- Indexes for table `rb_mata_pelajaran`
--
ALTER TABLE `rb_mata_pelajaran`
  ADD PRIMARY KEY (`kode_pelajaran`);

--
-- Indexes for table `rb_menu`
--
ALTER TABLE `rb_menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `rb_nilai_extrakulikuler`
--
ALTER TABLE `rb_nilai_extrakulikuler`
  ADD PRIMARY KEY (`id_nilai_extrakulikuler`);

--
-- Indexes for table `rb_nilai_keterampilan`
--
ALTER TABLE `rb_nilai_keterampilan`
  ADD PRIMARY KEY (`id_nilai_keterampilan`);

--
-- Indexes for table `rb_nilai_pengetahuan`
--
ALTER TABLE `rb_nilai_pengetahuan`
  ADD PRIMARY KEY (`id_nilai_pengetahuan`);

--
-- Indexes for table `rb_nilai_pertanyaan_essai`
--
ALTER TABLE `rb_nilai_pertanyaan_essai`
  ADD PRIMARY KEY (`id_nilai_pertanyaan_essai`);

--
-- Indexes for table `rb_nilai_prestasi`
--
ALTER TABLE `rb_nilai_prestasi`
  ADD PRIMARY KEY (`id_nilai_prestasi`);

--
-- Indexes for table `rb_nilai_sikap`
--
ALTER TABLE `rb_nilai_sikap`
  ADD PRIMARY KEY (`id_nilai_sikap`);

--
-- Indexes for table `rb_nilai_sikap_semester`
--
ALTER TABLE `rb_nilai_sikap_semester`
  ADD PRIMARY KEY (`id_nilai_sikap_semester`);

--
-- Indexes for table `rb_nilai_uts`
--
ALTER TABLE `rb_nilai_uts`
  ADD PRIMARY KEY (`id_nilai_uts`);

--
-- Indexes for table `rb_pertanyaan_essai`
--
ALTER TABLE `rb_pertanyaan_essai`
  ADD PRIMARY KEY (`id_pertanyaan_essai`);

--
-- Indexes for table `rb_pertanyaan_objektif`
--
ALTER TABLE `rb_pertanyaan_objektif`
  ADD PRIMARY KEY (`id_pertanyaan_objektif`);

--
-- Indexes for table `rb_pertanyaan_penilaian`
--
ALTER TABLE `rb_pertanyaan_penilaian`
  ADD PRIMARY KEY (`id_pertanyaan_penilaian`);

--
-- Indexes for table `rb_pertanyaan_penilaian_jawab`
--
ALTER TABLE `rb_pertanyaan_penilaian_jawab`
  ADD PRIMARY KEY (`id_pertanyaan_penilaian_jawab`);

--
-- Indexes for table `rb_predikat`
--
ALTER TABLE `rb_predikat`
  ADD PRIMARY KEY (`id_predikat`);

--
-- Indexes for table `rb_psb_aktivasi`
--
ALTER TABLE `rb_psb_aktivasi`
  ADD PRIMARY KEY (`id_aktivasi`);

--
-- Indexes for table `rb_psb_pendaftaran`
--
ALTER TABLE `rb_psb_pendaftaran`
  ADD PRIMARY KEY (`id_pendaftaran`);

--
-- Indexes for table `rb_psb_pendaftaran_saudara`
--
ALTER TABLE `rb_psb_pendaftaran_saudara`
  ADD PRIMARY KEY (`id_saudara`);

--
-- Indexes for table `rb_quiz_ujian`
--
ALTER TABLE `rb_quiz_ujian`
  ADD PRIMARY KEY (`id_quiz_ujian`);

--
-- Indexes for table `rb_ruangan`
--
ALTER TABLE `rb_ruangan`
  ADD PRIMARY KEY (`kode_ruangan`);

--
-- Indexes for table `rb_sesi`
--
ALTER TABLE `rb_sesi`
  ADD PRIMARY KEY (`id_sesi`);

--
-- Indexes for table `rb_siswa`
--
ALTER TABLE `rb_siswa`
  ADD PRIMARY KEY (`id_siswa`);

--
-- Indexes for table `rb_sms`
--
ALTER TABLE `rb_sms`
  ADD PRIMARY KEY (`id_sms`);

--
-- Indexes for table `rb_sms_autoreply`
--
ALTER TABLE `rb_sms_autoreply`
  ADD PRIMARY KEY (`id_autoreply`);

--
-- Indexes for table `rb_sms_inbox`
--
ALTER TABLE `rb_sms_inbox`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rb_sms_outbox`
--
ALTER TABLE `rb_sms_outbox`
  ADD PRIMARY KEY (`id_outbox`);

--
-- Indexes for table `rb_status_keaktifan`
--
ALTER TABLE `rb_status_keaktifan`
  ADD PRIMARY KEY (`id_status_keaktifan`);

--
-- Indexes for table `rb_status_kepegawaian`
--
ALTER TABLE `rb_status_kepegawaian`
  ADD PRIMARY KEY (`id_status_kepegawaian`);

--
-- Indexes for table `rb_status_pernikahan`
--
ALTER TABLE `rb_status_pernikahan`
  ADD PRIMARY KEY (`id_status_pernikahan`);

--
-- Indexes for table `rb_tahun_akademik`
--
ALTER TABLE `rb_tahun_akademik`
  ADD PRIMARY KEY (`id_tahun_akademik`);

--
-- Indexes for table `rb_users`
--
ALTER TABLE `rb_users`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `rb_users_aktivitas`
--
ALTER TABLE `rb_users_aktivitas`
  ADD PRIMARY KEY (`id_users_aktivitas`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `rb_absensi_guru`
--
ALTER TABLE `rb_absensi_guru`
  MODIFY `id_absensi_guru` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `rb_absensi_siswa`
--
ALTER TABLE `rb_absensi_siswa`
  MODIFY `id_absensi_siswa` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `rb_agama`
--
ALTER TABLE `rb_agama`
  MODIFY `id_agama` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rb_elearning`
--
ALTER TABLE `rb_elearning`
  MODIFY `id_elearning` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `rb_elearning_jawab`
--
ALTER TABLE `rb_elearning_jawab`
  MODIFY `id_elearning_jawab` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rb_forum_komentar`
--
ALTER TABLE `rb_forum_komentar`
  MODIFY `id_forum_komentar` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `rb_forum_topic`
--
ALTER TABLE `rb_forum_topic`
  MODIFY `id_forum_topic` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rb_golongan`
--
ALTER TABLE `rb_golongan`
  MODIFY `id_golongan` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rb_halaman`
--
ALTER TABLE `rb_halaman`
  MODIFY `id_halaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rb_identitas_sekolah`
--
ALTER TABLE `rb_identitas_sekolah`
  MODIFY `id_identitas_sekolah` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rb_jadwal_pelajaran`
--
ALTER TABLE `rb_jadwal_pelajaran`
  MODIFY `kodejdwl` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `rb_jawaban_essai`
--
ALTER TABLE `rb_jawaban_essai`
  MODIFY `id_jawaban_essai` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `rb_jawaban_objektif`
--
ALTER TABLE `rb_jawaban_objektif`
  MODIFY `id_jawaban_objektif` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `rb_jenis_kelamin`
--
ALTER TABLE `rb_jenis_kelamin`
  MODIFY `id_jenis_kelamin` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rb_jenis_ptk`
--
ALTER TABLE `rb_jenis_ptk`
  MODIFY `id_jenis_ptk` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rb_journal_list`
--
ALTER TABLE `rb_journal_list`
  MODIFY `id_journal` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rb_kategori_elearning`
--
ALTER TABLE `rb_kategori_elearning`
  MODIFY `id_kategori_elearning` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rb_kategori_quiz_ujian`
--
ALTER TABLE `rb_kategori_quiz_ujian`
  MODIFY `id_kategori_quiz_ujian` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rb_kelompok_mata_pelajaran`
--
ALTER TABLE `rb_kelompok_mata_pelajaran`
  MODIFY `id_kelompok_mata_pelajaran` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rb_kompetensi_dasar`
--
ALTER TABLE `rb_kompetensi_dasar`
  MODIFY `id_kompetensi_dasar` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rb_kurikulum`
--
ALTER TABLE `rb_kurikulum`
  MODIFY `kode_kurikulum` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rb_menu`
--
ALTER TABLE `rb_menu`
  MODIFY `id_menu` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT for table `rb_nilai_extrakulikuler`
--
ALTER TABLE `rb_nilai_extrakulikuler`
  MODIFY `id_nilai_extrakulikuler` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `rb_nilai_keterampilan`
--
ALTER TABLE `rb_nilai_keterampilan`
  MODIFY `id_nilai_keterampilan` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `rb_nilai_pengetahuan`
--
ALTER TABLE `rb_nilai_pengetahuan`
  MODIFY `id_nilai_pengetahuan` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `rb_nilai_pertanyaan_essai`
--
ALTER TABLE `rb_nilai_pertanyaan_essai`
  MODIFY `id_nilai_pertanyaan_essai` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rb_nilai_prestasi`
--
ALTER TABLE `rb_nilai_prestasi`
  MODIFY `id_nilai_prestasi` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `rb_nilai_sikap`
--
ALTER TABLE `rb_nilai_sikap`
  MODIFY `id_nilai_sikap` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `rb_nilai_sikap_semester`
--
ALTER TABLE `rb_nilai_sikap_semester`
  MODIFY `id_nilai_sikap_semester` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `rb_nilai_uts`
--
ALTER TABLE `rb_nilai_uts`
  MODIFY `id_nilai_uts` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `rb_pertanyaan_essai`
--
ALTER TABLE `rb_pertanyaan_essai`
  MODIFY `id_pertanyaan_essai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `rb_pertanyaan_objektif`
--
ALTER TABLE `rb_pertanyaan_objektif`
  MODIFY `id_pertanyaan_objektif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `rb_pertanyaan_penilaian`
--
ALTER TABLE `rb_pertanyaan_penilaian`
  MODIFY `id_pertanyaan_penilaian` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rb_pertanyaan_penilaian_jawab`
--
ALTER TABLE `rb_pertanyaan_penilaian_jawab`
  MODIFY `id_pertanyaan_penilaian_jawab` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `rb_predikat`
--
ALTER TABLE `rb_predikat`
  MODIFY `id_predikat` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `rb_psb_aktivasi`
--
ALTER TABLE `rb_psb_aktivasi`
  MODIFY `id_aktivasi` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rb_psb_pendaftaran`
--
ALTER TABLE `rb_psb_pendaftaran`
  MODIFY `id_pendaftaran` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rb_psb_pendaftaran_saudara`
--
ALTER TABLE `rb_psb_pendaftaran_saudara`
  MODIFY `id_saudara` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `rb_quiz_ujian`
--
ALTER TABLE `rb_quiz_ujian`
  MODIFY `id_quiz_ujian` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `rb_sesi`
--
ALTER TABLE `rb_sesi`
  MODIFY `id_sesi` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rb_siswa`
--
ALTER TABLE `rb_siswa`
  MODIFY `id_siswa` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1275;

--
-- AUTO_INCREMENT for table `rb_sms`
--
ALTER TABLE `rb_sms`
  MODIFY `id_sms` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `rb_sms_autoreply`
--
ALTER TABLE `rb_sms_autoreply`
  MODIFY `id_autoreply` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rb_sms_inbox`
--
ALTER TABLE `rb_sms_inbox`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rb_sms_outbox`
--
ALTER TABLE `rb_sms_outbox`
  MODIFY `id_outbox` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rb_status_keaktifan`
--
ALTER TABLE `rb_status_keaktifan`
  MODIFY `id_status_keaktifan` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rb_status_kepegawaian`
--
ALTER TABLE `rb_status_kepegawaian`
  MODIFY `id_status_kepegawaian` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rb_status_pernikahan`
--
ALTER TABLE `rb_status_pernikahan`
  MODIFY `id_status_pernikahan` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rb_tahun_akademik`
--
ALTER TABLE `rb_tahun_akademik`
  MODIFY `id_tahun_akademik` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20233;

--
-- AUTO_INCREMENT for table `rb_users`
--
ALTER TABLE `rb_users`
  MODIFY `id_user` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `rb_users_aktivitas`
--
ALTER TABLE `rb_users_aktivitas`
  MODIFY `id_users_aktivitas` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=196;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
