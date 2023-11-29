
<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;


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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return redirect()->route('login');
});


Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//GURU


// Rute yang memerlukan admin

Route::group(['middleware' => ['checkadminstatus:admin']], function () {
    // ROUTE GURU FITUR
    Route::get('/guru', [App\Http\Controllers\GuruController::class, 'index'])->name('guru.index');
    Route::get('/guru/add', [App\Http\Controllers\GuruController::class, 'add'])->name('guru.create');
    Route::post('/guru', [App\Http\Controllers\GuruController::class, 'store'])->name('guru.store');
    Route::delete('/guru/{id}', [App\Http\Controllers\GuruController::class, 'delete'])->name('guru.destroy');
    Route::get('/guru/search', [App\Http\Controllers\GuruController::class, 'search'])->name('guru.search');

    // ROUTE SISWA FITUR
    Route::get('/siswa', [App\Http\Controllers\SiswaController::class, 'index'])->name('siswa.index');
    Route::get('/siswa/add', [App\Http\Controllers\SiswaController::class, 'add'])->name('siswa.create');
    Route::post('/siswa', [App\Http\Controllers\SiswaController::class, 'store'])->name('siswa.store');
    Route::delete('/siswa/{id}', [App\Http\Controllers\SiswaController::class, 'delete'])->name('siswa.destroy');
    Route::get('/siswa/search', [App\Http\Controllers\SiswaController::class, 'search'])->name('siswa.search');

    // ROUTE PERMOHONAN MAGANG FITUR
    Route::get('/admin/magang', [App\Http\Controllers\MagangController::class, 'index'])->name('magang.index');

    Route::get('/admin/preview-file/{id}', [App\Http\Controllers\MagangController::class, 'preview'])->name('admin.file-preview');
    Route::get('/admin/permohonan-magang', [App\Http\Controllers\MagangController::class, 'list_approve'])->name('magang.list_approve');
    Route::post('/permohonan-magang/approve/{id}', [App\Http\Controllers\MagangController::class, 'approve'])->name('magang.approve');
    Route::post('/permohonan-magang/reject/{id}', [App\Http\Controllers\MagangController::class, 'reject'])->name('magang.reject');

    Route::post('/admin/magang/{id}', [App\Http\Controllers\MagangController::class, 'simpanGuru'])->name('admin.pilih-pembimbing');

    // SIDANG SISWA
    Route::get('/admin/sidang-siswa', [App\Http\Controllers\SidangController::class, 'index'])->name('admin.sidang-siswa');
    Route::post('/admin/sidang/jadwal/{id}', [App\Http\Controllers\SidangController::class, 'jadwal_sidang'])->name('admin.jadwal-sidang');
    Route::get('/admin/sidang/edit/{id}', [App\Http\Controllers\SidangController::class, 'edit'])->name('admin.jadwal-sidang.edit');
    Route::put('/admin/sidang/{id}', [App\Http\Controllers\SidangController::class, 'update'])->name('admin.jadwal-sidang.update');

});

Route::group(['middleware' => ['checkgurustatus:guru']], function () {
    // Rute-rute guru
    Route::get('/guru/preview-file-bimbingan/{id}', [App\Http\Controllers\BimbinganController::class, 'preview'])->name('guru.file-preview');

    Route::get('/guru/bimbingan-siswa/{id}', [App\Http\Controllers\BimbinganController::class, 'index_2'])->name('guru.bimbingan-siswa');
    Route::get('/guru/data-siswa-bimbingan', [App\Http\Controllers\BimbinganController::class, 'list'])->name('guru.siswa-bimbingan');

    Route::get('/guru/respon-pembimbing/edit/{id}', [App\Http\Controllers\BimbinganController::class, 'respon'])->name('guru.respon-pembimbing');
    Route::put('/guru/respon-pembimbing/{id}', [App\Http\Controllers\BimbinganController::class, 'guru_respon'])->name('guru.respon-bimbingan.update');


    Route::post('/guru/setujui-bimbingan/{id}', [App\Http\Controllers\BimbinganController::class, 'setujuiBimbingan'])->name('guru.setujui-bimbingan');
    Route::post('/guru/tolak-bimbingan/{id}', [App\Http\Controllers\BimbinganController::class, 'tolakBimbingan'])->name('guru.tolak-bimbingan');
});

Route::group(['middleware' => ['checksiswastatus:siswa']], function () {
    // PERMOHONAN MAGANG SISWA
    Route::get('/siswa/preview-file/{id}', [App\Http\Controllers\PermohonanMagangController::class, 'preview'])->name('file.preview');
    Route::get('/siswa/permohonan-magang', [App\Http\Controllers\PermohonanMagangController::class, 'index'])->name('permohonan-magang.index');
    Route::get('/siswa/permohonan-magang/add', [App\Http\Controllers\PermohonanMagangController::class, 'add'])->name('permohonan-magang.add');
    Route::post('/siswa/permohonan-magang', [App\Http\Controllers\PermohonanMagangController::class, 'store'])->name('permohonan-magang.store');
    Route::delete('/siswa/permohonan-magang/{id}', [App\Http\Controllers\PermohonanMagangController::class, 'delete'])->name('permohonan-magang.destroy');

    // BIMBINGAN
    Route::get('/data_bimbingan_siswa', [App\Http\Controllers\SiswaController::class, 'data_bimbingan_siswa'])->name('data_bimbingan_siswa');
    Route::get('/siswa/bimbingan', [App\Http\Controllers\BimbinganController::class, 'index'])->name('siswa.bimbingan');
    Route::get('/siswa/bimbingan/add', [App\Http\Controllers\BimbinganController::class, 'add'])->name('siswa.bimbingan.add');
    Route::post('/siswa/bimbingan', [App\Http\Controllers\BimbinganController::class, 'store'])->name('siswa.bimbingan.store');
    Route::delete('/siswa/bimbingan/{id}', [App\Http\Controllers\BimbinganController::class, 'delete'])->name('siswa.bimbingan.destroy');
    Route::get('/siswa/preview-file-bimbingan/{id}', [App\Http\Controllers\BimbinganController::class, 'preview'])->name('siswa.file-preview');

    Route::post('/siswa/sidang', [App\Http\Controllers\BimbinganController::class, 'ajukan_sidang'])->name('siswa.ajukan-sidang');

});
