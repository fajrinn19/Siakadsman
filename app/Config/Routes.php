<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Daftarkan rute CRUD standar untuk controller turunan App\Controllers\Master\CrudController.
$crud = static function (RouteCollection $routes, string $segmen, string $controller): void {
    $routes->get($segmen, "{$controller}::index");
    $routes->get("{$segmen}/tambah", "{$controller}::tambah");
    $routes->post("{$segmen}/tambah", "{$controller}::simpan");
    $routes->get("{$segmen}/detail/(:segment)", "{$controller}::detail/$1");
    $routes->get("{$segmen}/edit/(:segment)", "{$controller}::edit/$1");
    $routes->post("{$segmen}/edit/(:segment)", "{$controller}::update/$1");
    $routes->post("{$segmen}/hapus/(:segment)", "{$controller}::hapus/$1");
};

// ---------------------------------------------------------------- Login
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attempt');
$routes->get('login/captcha', 'Auth::captcha');
$routes->get('logout', 'Auth::logout');

$routes->group('', ['filter' => 'auth'], static function (RouteCollection $routes) use ($crud): void {
    $routes->get('/', 'Dashboard::index');
    $routes->get('profil', 'Dashboard::profil');
    $routes->get('unduh/bahan/(:num)', 'BahanTugas::unduhBahan/$1');
    $routes->get('unduh/jawaban/(:num)', 'BahanTugas::unduhJawaban/$1');

    // ------------------------------------------------------------ Admin & kepala sekolah
    $routes->group('', ['filter' => 'role:superuser,kepala'], static function (RouteCollection $routes) use ($crud): void {
        $routes->get('identitas', 'Master\Identitas::index');
        $routes->post('identitas', 'Master\Identitas::update');

        $crud($routes, 'kurikulum', 'Master\Kurikulum');
        $crud($routes, 'tahun-akademik', 'Master\TahunAkademik');
        $crud($routes, 'gedung', 'Master\Gedung');
        $crud($routes, 'ruangan', 'Master\Ruangan');
        $crud($routes, 'golongan', 'Master\Golongan');
        $crud($routes, 'jenis-ptk', 'Master\JenisPtk');
        $crud($routes, 'jurusan', 'Master\Jurusan');
        $crud($routes, 'kelas', 'Master\Kelas');
        $routes->get('kelas/excel/(:segment)', 'Master\Kelas::excel/$1');
        $crud($routes, 'status-kepegawaian', 'Master\StatusKepegawaian');
        $crud($routes, 'kelompok-mapel', 'Master\KelompokMapel');
        $crud($routes, 'mata-pelajaran', 'Master\MataPelajaran');
        $crud($routes, 'jadwal-pelajaran', 'Master\JadwalPelajaran');
        $crud($routes, 'predikat', 'Master\Predikat');
        $crud($routes, 'penilaian-diri', 'Master\PenilaianDiri');
        $crud($routes, 'penilaian-teman', 'Master\PenilaianTeman');
        $crud($routes, 'kepala-sekolah', 'Master\KepalaSekolah');

        // Data administrator hanya untuk superuser, kecuali kepala mengubah profilnya sendiri (dicek di controller).
        $crud($routes, 'admin', 'Master\Admin');

        $routes->get('siswa', 'Siswa::index');
        $routes->get('siswa/tambah', 'Siswa::tambah');
        $routes->post('siswa/tambah', 'Siswa::simpan');
        $routes->post('siswa/pindah-kelas', 'Siswa::pindahKelas');
        $routes->post('siswa/hapus/(:segment)', 'Siswa::hapus/$1');
        $routes->post('siswa/riwayat/hapus/(:num)', 'Siswa::hapusRiwayat/$1');
        $routes->get('siswa/cetak', 'Siswa::cetak');
        $routes->get('siswa/(:segment)/penilaian-diri', 'Siswa::penilaianDiri/$1');
        $routes->get('siswa/(:segment)/penilaian-teman', 'Siswa::penilaianTeman/$1');
        $routes->get('siswa/(:segment)/penilaian-teman/(:segment)', 'Siswa::penilaianTemanDetail/$1/$2');

        $routes->get('guru/tambah', 'Guru::tambah');
        $routes->post('guru/tambah', 'Guru::simpan');
        $routes->post('guru/hapus/(:segment)', 'Guru::hapus/$1');

        $routes->get('absensi-guru', 'AbsensiGuru::index');
        $routes->post('absensi-guru', 'AbsensiGuru::simpan');
        $routes->get('journal-kbm', 'Journal::semua');

        $routes->get('raport/capaian', 'Raport\Capaian::index');
        $routes->post('raport/capaian', 'Raport\Capaian::simpan');
        $routes->get('raport/ekstrakurikuler', 'Raport\Ekstrakurikuler::index');
        $routes->post('raport/ekstrakurikuler', 'Raport\Ekstrakurikuler::simpan');
        $routes->post('raport/ekstrakurikuler/hapus/(:num)', 'Raport\Ekstrakurikuler::hapus/$1');
        $routes->get('raport/prestasi', 'Raport\Prestasi::index');
        $routes->post('raport/prestasi', 'Raport\Prestasi::simpan');
        $routes->post('raport/prestasi/hapus/(:num)', 'Raport\Prestasi::hapus/$1');
    });

    // ------------------------------------------------------------ Guru, admin & kepala sekolah
    $routes->group('', ['filter' => 'role:guru,superuser,kepala'], static function (RouteCollection $routes): void {
        $routes->get('guru', 'Guru::index');

        $routes->get('absensi-siswa', 'AbsensiSiswa::index');
        $routes->get('absensi-siswa/(:num)', 'AbsensiSiswa::form/$1');
        $routes->post('absensi-siswa/(:num)', 'AbsensiSiswa::simpan/$1');
        $routes->get('absensi-siswa/rekap', 'AbsensiSiswa::rekapPilih');
        $routes->get('absensi-siswa/rekap/(:num)', 'AbsensiSiswa::rekap/$1');
        $routes->get('absensi-siswa/rekap/(:num)/bulanan', 'AbsensiSiswa::rekapBulanan/$1');

        $routes->get('journal', 'Journal::index');
        $routes->get('journal/(:num)', 'Journal::daftar/$1');
        $routes->get('journal/(:num)/tambah', 'Journal::tambah/$1');
        $routes->post('journal/(:num)/tambah', 'Journal::simpan/$1');
        $routes->get('journal/(:num)/edit/(:num)', 'Journal::edit/$1/$2');
        $routes->post('journal/(:num)/edit/(:num)', 'Journal::update/$1/$2');
        $routes->post('journal/(:num)/hapus/(:num)', 'Journal::hapus/$1/$2');

        $routes->get('kompetensi-dasar', 'KompetensiDasar::index');
        $routes->get('kompetensi-dasar/(:num)', 'KompetensiDasar::daftar/$1');
        $routes->get('kompetensi-dasar/(:num)/tambah', 'KompetensiDasar::tambah/$1');
        $routes->post('kompetensi-dasar/(:num)/tambah', 'KompetensiDasar::simpan/$1');
        $routes->get('kompetensi-dasar/(:num)/edit/(:num)', 'KompetensiDasar::edit/$1/$2');
        $routes->post('kompetensi-dasar/(:num)/edit/(:num)', 'KompetensiDasar::update/$1/$2');
        $routes->post('kompetensi-dasar/(:num)/hapus/(:num)', 'KompetensiDasar::hapus/$1/$2');

        $routes->get('bahan-tugas/(:num)/tambah', 'BahanTugas::tambah/$1');
        $routes->post('bahan-tugas/(:num)/tambah', 'BahanTugas::simpan/$1');
        $routes->get('bahan-tugas/(:num)/edit/(:num)', 'BahanTugas::edit/$1/$2');
        $routes->post('bahan-tugas/(:num)/edit/(:num)', 'BahanTugas::update/$1/$2');
        $routes->post('bahan-tugas/(:num)/hapus/(:num)', 'BahanTugas::hapus/$1/$2');
        $routes->get('bahan-tugas/(:num)/jawaban/(:num)', 'BahanTugas::jawaban/$1/$2');

        $routes->get('quiz/(:num)/tambah', 'Quiz::tambah/$1');
        $routes->post('quiz/(:num)/tambah', 'Quiz::simpan/$1');
        $routes->post('quiz/(:num)/hapus/(:num)', 'Quiz::hapus/$1/$2');
        $routes->get('quiz/soal/(:num)', 'Quiz::soal/$1');
        $routes->post('quiz/soal/(:num)/essai', 'Quiz::tambahEssai/$1');
        $routes->post('quiz/soal/(:num)/objektif', 'Quiz::tambahObjektif/$1');
        $routes->post('quiz/soal/(:num)/essai/hapus/(:num)', 'Quiz::hapusEssai/$1/$2');
        $routes->post('quiz/soal/(:num)/objektif/hapus/(:num)', 'Quiz::hapusObjektif/$1/$2');
        $routes->get('quiz/soal/(:num)/jawaban', 'Quiz::jawaban/$1');
        $routes->get('quiz/soal/(:num)/jawaban/(:segment)', 'Quiz::jawabanSiswa/$1/$2');
        $routes->post('quiz/soal/(:num)/jawaban/(:segment)', 'Quiz::nilaiEssai/$1/$2');

        $routes->get('forum/(:num)/tambah', 'Forum::tambah/$1');
        $routes->post('forum/(:num)/tambah', 'Forum::simpan/$1');
        $routes->post('forum/topik/(:num)/hapus', 'Forum::hapusTopik/$1');

        $routes->get('nilai', 'Nilai::index');
        $routes->get('nilai/(:num)/pengetahuan', 'Nilai::pengetahuan/$1');
        $routes->post('nilai/(:num)/pengetahuan', 'Nilai::simpanPengetahuan/$1');
        $routes->post('nilai/(:num)/pengetahuan/hapus/(:num)', 'Nilai::hapusPengetahuan/$1/$2');
        $routes->get('nilai/(:num)/keterampilan', 'Nilai::keterampilan/$1');
        $routes->post('nilai/(:num)/keterampilan', 'Nilai::simpanKeterampilan/$1');
        $routes->post('nilai/(:num)/keterampilan/hapus/(:num)', 'Nilai::hapusKeterampilan/$1/$2');
        $routes->get('nilai/(:num)/sikap', 'Nilai::sikap/$1');
        $routes->post('nilai/(:num)/sikap', 'Nilai::simpanSikap/$1');

        $routes->get('nilai-uts', 'NilaiUts::index');
        $routes->get('nilai-uts/(:num)', 'NilaiUts::form/$1');
        $routes->post('nilai-uts/(:num)', 'NilaiUts::simpan/$1');

        $routes->get('raport/cetak', 'Raport\Cetak::index');
        $routes->get('raport/cetak-uts', 'Raport\Cetak::uts');
        $routes->get('raport/print/uts/(:segment)', 'Raport\Cetak::printUts/$1');
        $routes->get('raport/print/(:segment)/(:segment)', 'Raport\Cetak::halaman/$1/$2');
    });

    // ------------------------------------------------------------ Siswa
    $routes->group('', ['filter' => 'role:siswa'], static function (RouteCollection $routes): void {
        $routes->get('penilaian/diri', 'Penilaian::diri');
        $routes->post('penilaian/diri', 'Penilaian::simpanDiri');
        $routes->get('penilaian/teman', 'Penilaian::teman');
        $routes->get('penilaian/teman/(:segment)', 'Penilaian::temanForm/$1');
        $routes->post('penilaian/teman/(:segment)', 'Penilaian::simpanTeman/$1');

        $routes->get('bahan-tugas/(:num)/kirim/(:num)', 'BahanTugas::kirim/$1/$2');
        $routes->post('bahan-tugas/(:num)/kirim/(:num)', 'BahanTugas::simpanKiriman/$1/$2');

        $routes->get('quiz/soal/(:num)/kerjakan', 'Quiz::kerjakan/$1');
        $routes->post('quiz/soal/(:num)/kerjakan', 'Quiz::simpanObjektif/$1');
        $routes->get('quiz/soal/(:num)/essai/(:num)', 'Quiz::jawabEssai/$1/$2');
        $routes->post('quiz/soal/(:num)/essai/(:num)', 'Quiz::simpanEssai/$1/$2');

        $routes->get('raport/saya', 'Raport\Siswa::raport');
        $routes->get('raport/uts-saya', 'Raport\Siswa::uts');
        $routes->get('kompetensi-saya/(:num)', 'Dashboard::kompetensi/$1');
    });

    // ------------------------------------------------------------ Semua pengguna (akses per jadwal dicek di controller)
    $routes->get('siswa/detail/(:segment)', 'Siswa::detail/$1');
    $routes->get('siswa/edit/(:segment)', 'Siswa::edit/$1');
    $routes->post('siswa/edit/(:segment)', 'Siswa::update/$1');
    $routes->post('siswa/edit/(:segment)/ortu', 'Siswa::updateOrtu/$1');
    $routes->get('guru/detail/(:segment)', 'Guru::detail/$1');
    $routes->get('guru/edit/(:segment)', 'Guru::edit/$1');
    $routes->post('guru/edit/(:segment)', 'Guru::update/$1');

    $routes->get('bahan-tugas', 'BahanTugas::index');
    $routes->get('bahan-tugas/(:num)', 'BahanTugas::daftar/$1');

    $routes->get('quiz', 'Quiz::index');
    $routes->get('quiz/(:num)', 'Quiz::daftar/$1');

    $routes->get('forum', 'Forum::index');
    $routes->get('forum/(:num)', 'Forum::daftar/$1');
    $routes->get('forum/topik/(:num)', 'Forum::topik/$1');
    $routes->post('forum/topik/(:num)', 'Forum::komentar/$1');
    $routes->post('forum/topik/(:num)/komentar/(:num)/hapus', 'Forum::hapusKomentar/$1/$2');
});
