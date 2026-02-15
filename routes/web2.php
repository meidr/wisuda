<?php

use App\Http\Controllers\Admin\AcaraController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\KuotaController;
use App\Http\Controllers\Admin\ListDokumenController;
use App\Http\Controllers\Admin\PembayaranController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\PesertaController as AdminPesertaController;
use App\Http\Controllers\Admin\ProdiController;
use App\Http\Controllers\Admin\ProfilController;
use App\Http\Controllers\Admin\QRCodeController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TahunController;
use App\Http\Controllers\Auth\LoginAdminController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Operasi\DaftarTugasController;
use App\Http\Controllers\Operasi\DokumenController as OperasiDokumenController;
use App\Http\Controllers\Operasi\KalenderController;
use App\Http\Controllers\Operasi\KehadiranController;
use App\Http\Controllers\Operasi\KuotaController as OperasiKuotaController;
use App\Http\Controllers\Operasi\PesertaController as OperasiPesertaController;
use App\Http\Controllers\Peserta\DashboardController as PesertaDashboardController;
use App\Http\Controllers\Peserta\FormulirController as PesertaFormulirController;
use App\Http\Controllers\Peserta\PesertaController;
use App\Http\Controllers\RootController;
use App\Http\Controllers\TestingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Auth::routes([
    'register' => false,
    'reset'    => false,
    'verify'   => false,
]);

// Route::group(['middleware' => ['jadwal']], function () {
//     Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
//     Route::post('/register', [RegisterController::class, 'register']);
// });

Route::get('/', [RootController::class, 'root'])->name('root');
Route::get('/home', [RootController::class, 'home'])->name('home')->middleware('auth');
Route::get('/pengembangan', [RootController::class, 'pengembangan'])->name('pengembangan');

Route::prefix('otp')->group(function () {
    Route::get('/{siswa}', [OtpController::class, 'index'])->name('otp')->middleware('otp:1');
    Route::post('/{siswa}', [OtpController::class, 'process'])->name('otp.process')->middleware('otp:1');
    Route::put('/{siswa}', [OtpController::class, 'savePassword'])->name('otp.savePassword')->middleware('otp:1');
    Route::get('/{siswa}/resend', [OtpController::class, 'resend'])->name('otp.resend')->middleware('otp:1');
    Route::get('/{siswa}/setPassword', [OtpController::class, 'setPassword'])->name('otp.setPassword')->middleware('otp:0');
});

Route::prefix('admin')->group(function () {
    Route::get('/', [LoginAdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/', [LoginAdminController::class, 'login'])->name('admin.login.process');
    Route::get('/login', [LoginAdminController::class, 'backToLogin'])->name('admin.login.backToLogin');

    Route::group(['middleware' => ['auth']], function () {
        Route::prefix('dashboard')->group(function () {
            Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
            Route::get('/getDaurah', [DashboardController::class, 'getDaurah'])->name('admin.dashboard.getDaurah');
            Route::get('/getRekapan', [DashboardController::class, 'getRekapan'])->name('admin.dashboard.getRekapan');
            Route::post('/updateTahunPelajaranAdmin', [DashboardController::class, 'updateTahunPelajaranAdmin'])->name('admin.dashboard.updateTahunPelajaranAdmin');
        });

        Route::prefix('pengguna')->middleware('role:admin')->group(function () {
            Route::get('/', [PenggunaController::class, 'index'])->name('admin.pengguna');
            Route::get('/data', [PenggunaController::class, 'data'])->name('admin.pengguna.data');
            Route::post('/add', [PenggunaController::class, 'add'])->name('admin.pengguna.add');
            Route::post('/edit', [PenggunaController::class, 'edit'])->name('admin.pengguna.edit');
            Route::delete('/delete', [PenggunaController::class, 'delete'])->name('admin.pengguna.delete');
        });

        Route::prefix('tahun')->middleware('role:admin')->group(function () {
            Route::get('/', [TahunController::class, 'index'])->name('admin.tahun');
            Route::get('/data', [TahunController::class, 'data'])->name('admin.tahun.data');
            Route::post('/add', [TahunController::class, 'add'])->name('admin.tahun.add');
            Route::post('/edit', [TahunController::class, 'edit'])->name('admin.tahun.edit');
            Route::delete('/delete', [TahunController::class, 'delete'])->name('admin.tahun.delete');
        });

        Route::prefix('prodi')->middleware('role:admin')->group(function () {
            Route::get('/', [ProdiController::class, 'index'])->name('admin.prodi');
            Route::get('/data', [ProdiController::class, 'data'])->name('admin.prodi.data');
            Route::post('/add', [ProdiController::class, 'add'])->name('admin.prodi.add');
            Route::post('/edit', [ProdiController::class, 'edit'])->name('admin.prodi.edit');
            Route::delete('/delete', [ProdiController::class, 'delete'])->name('admin.prodi.delete');
        });

        Route::prefix('kuota')->middleware('role:admin')->group(function () {
            Route::get('/', [KuotaController::class, 'index'])->name('admin.kuota');
            Route::get('/data', [KuotaController::class, 'data'])->name('admin.kuota.data');
            Route::post('/add', [KuotaController::class, 'add'])->name('admin.kuota.add');
            Route::post('/edit', [KuotaController::class, 'edit'])->name('admin.kuota.edit');
            Route::delete('/delete', [KuotaController::class, 'delete'])->name('admin.kuota.delete');
        });

        Route::prefix('jadwal')->middleware('role:admin')->group(function () {
            Route::get('/', [JadwalController::class, 'index'])->name('admin.jadwal');
            Route::get('/data', [JadwalController::class, 'data'])->name('admin.jadwal.data');
            Route::post('/add', [JadwalController::class, 'add'])->name('admin.jadwal.add');
            Route::post('/edit', [JadwalController::class, 'edit'])->name('admin.jadwal.edit');
            Route::delete('/delete', [JadwalController::class, 'delete'])->name('admin.jadwal.delete');
        });

        Route::prefix('list-dokumen')->middleware('role:admin')->group(function () {
            Route::get('/', [ListDokumenController::class, 'index'])->name('admin.list-dokumen');
            Route::get('/data', [ListDokumenController::class, 'data'])->name('admin.list-dokumen.data');
            Route::post('/add', [ListDokumenController::class, 'add'])->name('admin.list-dokumen.add');
            Route::post('/edit', [ListDokumenController::class, 'edit'])->name('admin.list-dokumen.edit');
            Route::delete('/delete', [ListDokumenController::class, 'delete'])->name('admin.list-dokumen.delete');
        });

        Route::prefix('pembayaran')->middleware('role:admin,keuangan')->group(function () {
            Route::get('/', [PembayaranController::class, 'index'])->name('admin.pembayaran');
            Route::get('/data', [PembayaranController::class, 'data'])->name('admin.pembayaran.data');
            Route::get('/dataInfo', [PembayaranController::class, 'dataInfo'])->name('admin.pembayaran.dataInfo');
            Route::post('/add', [PembayaranController::class, 'add'])->name('admin.pembayaran.add');
            Route::post('/edit', [PembayaranController::class, 'edit'])->name('admin.pembayaran.edit');
            Route::delete('/delete', [PembayaranController::class, 'delete'])->name('admin.pembayaran.delete');
            Route::get('/kwitansi/{pembayaran}', [PembayaranController::class, 'kwitansi'])->name('admin.pembayaran.kwitansi');
            Route::post('/registasi', [PembayaranController::class, 'registrasi'])->name('admin.pembayaran.registrasi');
            Route::post('/export', [PembayaranController::class, 'export'])->name('admin.pembayaran.export');

        });

        Route::prefix('peserta')->middleware('role:admin')->group(function () {
            Route::get('/', [AdminPesertaController::class, 'index'])->name('admin.peserta');
            Route::get('/data', [AdminPesertaController::class, 'data'])->name('admin.peserta.data');
            Route::get('/generateQr', [AdminPesertaController::class, 'generateQr'])->name('admin.peserta.generateQr');
            Route::post('/add', [AdminPesertaController::class, 'add'])->name('admin.peserta.add');
            Route::post('/edit', [AdminPesertaController::class, 'edit'])->name('admin.peserta.edit');
            Route::delete('/', [AdminPesertaController::class, 'delete'])->name('admin.peserta.delete');

            Route::prefix('detail/{peserta}')->group(function () {
                Route::get('/', [AdminPesertaController::class, 'detail'])->name('admin.peserta.detail');
                Route::put('/', [AdminPesertaController::class, 'update'])->name('admin.peserta.update');
                Route::get('/dataDokumen', [AdminPesertaController::class, 'dataDokumen'])->name('admin.peserta.dataDokumen');
                Route::delete('/deleteDokumen', [AdminPesertaController::class, 'deleteDokumen'])->name('admin.peserta.deleteDokumen');
                Route::post('/saveDokumen', [AdminPesertaController::class, 'saveDokumen'])->name('admin.peserta.saveDokumen');
                Route::put('/updateStatusTerverifikasi', [AdminPesertaController::class, 'updateStatusTerverifikasi'])->name('admin.peserta.updateStatusTerverifikasi');
            });

            Route::post('/upload-file', [AdminPesertaController::class, 'fileUpload'])->name('admin.peserta.fileUpload');
            Route::post('/delete-file', [AdminPesertaController::class, 'fileDelete'])->name('admin.peserta.fileDelete');
            Route::put('/detail/{peserta}/updatePassword', [AdminPesertaController::class, 'updatePassword'])->name('admin.peserta.updatePassword');
            Route::post('/export', [AdminPesertaController::class, 'export'])->name('admin.peserta.export');

            // idCard
            Route::get('/idCard/{idPeserta}/{noUnik}/{download}', [AdminPesertaController::class, 'IdCard'])->name('peserta.peserta.idCard');
        });

        Route::prefix('acara')->group(function () {
            Route::get('/', [AcaraController::class, 'index'])->name('admin.acara');
            Route::post('/downloadFoto', [AcaraController::class, 'downloadFoto'])->name('admin.acara.downloadFoto');
            Route::get('/slideshow', [AcaraController::class, 'slideshow'])->name('admin.acara.slideshow');
            Route::post('/storeUrutan', [AcaraController::class, 'storeUrutan'])->name('admin.acara.storeUrutan');
        });
    });

    // Profil
    Route::prefix('profil')->group(function () {
        Route::get('/', [ProfilController::class, 'index'])->name('admin.profil');
        Route::get('/edit', [ProfilController::class, 'edit'])->name('admin.profil.edit');
        Route::post('/edit', [ProfilController::class, 'editProses'])->name('admin.profil.edit.proses');
        Route::get('/upload', [ProfilController::class, 'upload'])->name('admin.profil.upload');
        Route::post('/crop', [ProfilController::class, 'crop'])->name('admin.profil.crop');
    });

    // Setting
    Route::prefix('setting')->middleware('role:admin')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('admin.setting');
        Route::post('/', [SettingController::class, 'save'])->name('admin.setting.save');
        Route::post('/tes', [SettingController::class, 'tes'])->name('admin.setting.tes');
        Route::post('/generateQr', [SettingController::class, 'generateQr'])->name('admin.setting.generateQr');
        Route::get('/getPeserta', [SettingController::class, 'getPeserta'])->name('admin.setting.getPeserta');
    });

    // QR Code
    Route::prefix('qr_code')->middleware('role:admin')->group(function () {
        Route::get('/', [QRCodeController::class, 'index'])->name('admin.qr_code');
        Route::post('/konfirmasi', [QRCodeController::class, 'konfirmasi'])->name('admin.qr_code.konfirmasi');
    });

    // Berkas Bukti & Revisi
    Route::prefix('berkas-bukti-revisi')->middleware('role:admin')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\BerkasBuktiRevisiController::class, 'index'])->name('admin.berkas-bukti-revisi');
        Route::get('/data', [\App\Http\Controllers\Admin\BerkasBuktiRevisiController::class, 'data'])->name('admin.berkas-bukti-revisi.data');
        Route::post('/validasi-bukti', [\App\Http\Controllers\Admin\BerkasBuktiRevisiController::class, 'validasiBukti'])->name('admin.berkas-bukti-revisi.validasiBukti');
        Route::post('/validasi-revisi', [\App\Http\Controllers\Admin\BerkasBuktiRevisiController::class, 'validasiRevisi'])->name('admin.berkas-bukti-revisi.validasiRevisi');
    });

    // Antrian Atribut
    Route::prefix('antrian_atribut')->middleware('role:admin')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AntrianAtributController::class, 'index'])->name('admin.antrian_atribut');
        Route::get('/dataTable', [\App\Http\Controllers\Admin\AntrianAtributController::class, 'dataTable'])->name('admin.antrian_atribut.dataTable');
        Route::get('/autocomplete', [\App\Http\Controllers\Admin\AntrianAtributController::class, 'autocomplete'])->name('admin.antrian_atribut.autocomplete');
        Route::post('/konfirmasi', [\App\Http\Controllers\Admin\AntrianAtributController::class, 'konfirmasi'])->name('admin.antrian_atribut.konfirmasi');
        Route::post('/getData', [\App\Http\Controllers\Admin\AntrianAtributController::class, 'getData'])->name('admin.antrian_atribut.getData');
    });
});

Route::prefix('peserta')->middleware(['auth', 'role:peserta'])->group(function () {
    Route::get('/', [PesertaController::class, 'index'])->name('peserta');
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [PesertaDashboardController::class, 'index'])->name('peserta.dashboard');
        Route::put('/change-password', [PesertaDashboardController::class, 'changePassword'])->name('peserta.dashboard.changePassword');
    });
    Route::prefix('formulir')->group(function () {
        Route::get('/edit', [PesertaFormulirController::class, 'edit'])->name('peserta.formulir.edit');
        Route::put('/update', [PesertaFormulirController::class, 'update'])->name('peserta.formulir.update');
        Route::post('/dokumen', [PesertaFormulirController::class, 'dokumen'])->name('peserta.formulir.dokumen');
        Route::post('/upload-bukti', [PesertaFormulirController::class, 'uploadBukti'])->name('peserta.formulir.uploadBukti');
        Route::post('/upload-revisi', [PesertaFormulirController::class, 'uploadRevisi'])->name('peserta.formulir.uploadRevisi');
    });
});

Route::prefix('operasi')->middleware('auth')->group(function () {
    // admin
    Route::prefix('daftar-tugas')->group(function () {
        Route::get('/', [DaftarTugasController::class, 'show'])->name('operasi.daftarTugas.show');
        Route::post('/tambah', [DaftarTugasController::class, 'tambah'])->name('operasi.daftarTugas.tambah');
        Route::post('/edit', [DaftarTugasController::class, 'edit'])->name('operasi.daftarTugas.edit');
        Route::get('/jumlah-halaman', [DaftarTugasController::class, 'jumlahHalaman'])->name('operasi.daftarTugas.jumlahHalaman');
        Route::get('/{offset}', [DaftarTugasController::class, 'daftarTugas'])->name('operasi.daftarTugas');
        Route::get('/{id}/edit/{status}', [DaftarTugasController::class, 'check'])->name('operasi.daftarTugas.check');
        Route::post('/{id}/hapus', [DaftarTugasController::class, 'hapus'])->name('operasi.daftarTugas.hapus');
    });

    Route::prefix('kalender')->group(function () {
        Route::get('/', [KalenderController::class, 'show'])->name('operasi.kalender');
        Route::post('/tambah', [KalenderController::class, 'tambah'])->name('operasi.kalender.tambah');
        Route::post('/{id}/edit', [KalenderController::class, 'edit'])->name('operasi.kalender.edit');
        Route::delete('/{id}/hapus', [KalenderController::class, 'hapus'])->name('operasi.kalender.hapus');
    });

    Route::prefix('dokumen')->group(function () {
        Route::post('/delete-image', [OperasiDokumenController::class, 'imageDelete'])->name('operasi.dokumen.imageDelete');
        Route::get('/download', [OperasiDokumenController::class, 'download'])->name('operasi.dokumen.download');
        Route::get('/downloadFile', [OperasiDokumenController::class, 'downloadFile'])->name('operasi.dokumen.downloadFile');
    });

    Route::prefix('peserta')->group(function () {
        Route::get('/autocomplete', [OperasiPesertaController::class, 'autocomplete'])->name('operasi.peserta.autocomplete');
        Route::post('/getData', [OperasiPesertaController::class, 'getData'])->name('operasi.peserta.getData');
    });
    Route::prefix('kehadiran')->group(function () {
        Route::get('/autocomplete', [KehadiranController::class, 'autocomplete'])->name('operasi.kehadiran.autocomplete');
        Route::post('/getData', [KehadiranController::class, 'getData'])->name('operasi.kehadiran.getData');
    });

    Route::prefix('kuota')->group(function () {
        Route::get('/', [OperasiKuotaController::class, 'show'])->name('operasi.kuota');
        Route::get('/getData', [OperasiKuotaController::class, 'getData'])->name('operasi.kuota.getData');
    });
});

Route::prefix('peserta')->group(function () {
    Route::prefix('formulir')->group(function () {
        Route::get('/cetak/{idPeserta}/{noUnik}', [PesertaFormulirController::class, 'cetak'])->name('peserta.formulir.cetak');
        Route::get('/cetak-antrian/{idPeserta}/{noUnik}', [PesertaFormulirController::class, 'cetakAntrianAtribut'])->name('peserta.formulir.cetakAntrian');
    });
});
Route::get('/testing', [TestingController::class, 'index'])->name('testing')->middleware('jadwal');
