<?php

namespace App\Http\Controllers;

use App\Models\Magang;
use App\Models\Siswa;
use App\Models\Guru;
use Illuminate\Support\Facades\Storage;


use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class PermohonanMagangController extends Controller
{

    // USER SISWA

    public function index()
    {
        $user = Auth::user();
        $userId = $user->siswa->id;

        $permohonan_magang = Magang::where('siswa_id', $userId)
            ->orderBy('id', 'desc')
            ->get();

        return view('backend.permohonan-magang.index', ['permohonan_magang' => $permohonan_magang]);
    }

    public function add()
    {
        $siswa = Siswa::all();
        $guru = Guru::all();

        return view('backend.permohonan-magang.add', ['siswa' => $siswa, 'guru' => $guru]);
    }

    public function store(Request $data)
    {
        $data->validate([
            'file_upload' => 'required|file|mimes:pdf|max:2048',
            'namaperusahaan' => 'required',
            'awalmagang' => 'required|date',
            'akhirmagang' => 'required|date|after_or_equal:awalmagang',
        ], [
            'file_upload.mimes' => 'Hanya file PDF yang diperbolehkan.',
            'akhirmagang.after_or_equal' => 'Tanggal Selesai Magang harus setelah atau sama dengan Tanggal Mulai Magang.',
        ]);
        $loggedInUser = Auth::user();
        $siswaId = $loggedInUser->siswa->id;

        $timestamp = time();
        $file = $data->file_upload;
        $extension = $file->getClientOriginalExtension();
        $filename = 'surat_balasan_' . $timestamp . '.' . $extension;
        $path = $file->storeAs('surat_balasan', $filename); // Simpan file dengan nama yang unik

        Magang::insert([
            'siswa_id' => $siswaId,
            'status' => '2',
            'namaperusahaan' => $data->namaperusahaan,
            'awalmagang' => $data->awalmagang,
            'akhirmagang' => $data->akhirmagang,
            'file_upload' => $path, // Simpan path ke file yang telah diunggah
        ]);

        return redirect('siswa/permohonan-magang')->with("success", "Data Permohonan Magang pada Perusahaan $data->namaperusahaan berhasil disimpan");
    }

    public function delete($id)
    {
        // Temukan data permohonan magang berdasarkan ID
        $permohonan_magang = Magang::find($id);

        // Hapus file terkait
        Storage::delete($permohonan_magang->file_upload);

        // Hapus data permohonan magang
        $permohonan_magang->delete();

        return redirect('siswa/permohonan-magang')->with("success", 'Permohonan Magang ' . $permohonan_magang->siswa->nama . ' pada perusahaan ' . $permohonan_magang->namaperusahaan . ' telah dihapus');
    }

    public function preview($id)
    {
        // Cari Magang berdasarkan ID
        $magang = Magang::find($id);

        if (!$magang) {
            abort(404);
        }

        // Dapatkan path file yang telah disimpan
        $filePath = storage_path('app/' . $magang->file_upload);

        if (!file_exists($filePath)) {
            abort(404);
        }

        return response()->file($filePath);
    }
}
