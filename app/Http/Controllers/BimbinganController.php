<?php

namespace App\Http\Controllers;

use App\Models\Bimbingan;
use App\Models\Magang;
use App\Models\Siswa;
use App\Models\Sidang;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;

class BimbinganController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userId = $user->siswa->id;

        // Cari Magang yang sesuai dengan siswa yang sedang login
        $magang = Magang::where('siswa_id', $userId)->first();

        if ($magang) {
            // Jika Magang ditemukan, ambil ID-nya
            $magangId = $magang->id;

            // Gunakan ID Magang ini untuk mendapatkan bimbingan yang sesuai
            $bimbingan = Bimbingan::where('magang_id', $magangId)
                ->orderBy('id', 'desc')
                ->get();

            // Periksa apakah sudah ada data sidang untuk magang ini
            $existingSidang = Sidang::where('magang_id', $magangId)->first();

            // MENGHITUNG PROGRESS BIMBINGAN
            $totalBimbingan = $bimbingan->where('status', 1)->count();
            $maxProgress = 100;
            $progressPercentage = ($totalBimbingan > 6) ? $maxProgress : ($totalBimbingan / 6) * $maxProgress;

            // Menambahkan definisi untuk $progress_status
            $progress_status = ($totalBimbingan >= 6) ? 'Dapat Mengajukan Sidang' : 'Diperlukan Bimbingan';

            return view('backend.bimbingan.siswa.index', [
                'magang' => $magang,
                'existingSidang' => $existingSidang,
                'bimbingan' => $bimbingan,
                'progressPercentage' => $progressPercentage,
                'maxProgress' => $maxProgress,
                'progress_status' => $progress_status
            ]);
        } else {
            $permohonan_magang = Magang::where('siswa_id', $userId)->get();

            return redirect('siswa/permohonan-magang')->with('error', 'Menu Bimbingan tidak bisa di buka! Lakukan Permohonan Magang Terlebih Dahulu');
        }
    }

    public function list()
    {
        $user = Auth::user();
        $guruId = $user->guru->id;

        $magang = Magang::where('guru_id', $guruId)
            ->where('status', 1)
            ->get();


        return view('backend.bimbingan.guru.list', ['magang' => $magang]);
    }

    public function index_2($id)
    {
        $magang = Magang::find($id);

        if ($magang) {
            $magangId = $magang->id;

            $bimbingan = Bimbingan::where('magang_id', $magangId)
                ->orderBy('id', 'desc')
                ->get();

            $totalBimbingan = $bimbingan->where('status', 1)->count();
            $maxProgress = 100;
            $progressPercentage = ($totalBimbingan > 6) ? $maxProgress : ($totalBimbingan / 6) * $maxProgress;
            // Menambahkan definisi untuk $progress_status
            $progress_status = ($totalBimbingan >= 6) ? 'Siswa dapat Mengajukan Sidang' : 'Diperlukan Bimbingan';
            return view('backend.bimbingan.guru.index', [
                'magang' => $magang,
                'bimbingan' => $bimbingan,
                'progressPercentage' => $progressPercentage,
                'maxProgress' => $maxProgress,
                'progress_status' => $progress_status
            ]);
        }

        // Handle jika Magang tidak ditemukan
        return redirect()->back()->with('error', 'Magang tidak ditemukan.');
    }

    public function add()
    {
        $siswa = Siswa::all();

        return view('backend.bimbingan.siswa.add', ['siswa' => $siswa]);
    }

    public function store(Request $data)
    {
        $data->validate([
            'file_upload' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'komentar' => 'required'
        ], [
            'file_upload.mimes' => 'Hanya file PDF, DOC, atau DOCX yang diperbolehkan.',
            'komentar.required' => 'mohon isi kolom komentar'

        ]);

        $user = Auth::user();
        $userId = $user->siswa->id;

        // Cari Magang yang sesuai dengan siswa yang sedang login
        $magang = Magang::where('siswa_id', $userId)->first();

        // Jika Magang ditemukan, ambil ID-nya
        $magangId = $magang->id;

        $timestamp = time();
        $file = $data->file_upload;
        $extension = $file->getClientOriginalExtension();
        $filename = 'file_bimbingan' . $timestamp . '.' . $extension;
        $path = $file->storeAs('file_bimbingan', $filename); // Simpan file dengan nama yang unik

        Bimbingan::create([
            'magang_id' => $magangId,
            'file_upload' => $path, // Simpan path ke file yang telah diunggah
            'komentar' => $data->komentar,
            'status' => '2', //menunggu persetujuan
        ]);

        return redirect('siswa/bimbingan')->with("success", "Data Bimbingan telah disimpan!");
    }

    public function delete($id)
    {
        // Temukan data permohonan magang berdasarkan ID
        $bimbingan = Bimbingan::find($id);

        // Hapus file terkait
        Storage::delete($bimbingan->file_upload);

        // Hapus data permohonan magang
        $bimbingan->delete();

        return redirect('siswa/bimbingan')->with("success", 'Bimbingan Berhasil dihapus!');
    }

    public function preview($id)
    {
        // Cari Magang berdasarkan ID
        $bimbingan = Bimbingan::find($id);

        if (!$bimbingan) {
            abort(404);
        }

        // Dapatkan path file yang telah disimpan
        $filePath = storage_path('app/' . $bimbingan->file_upload);

        if (!file_exists($filePath)) {
            abort(404);
        }

        return response()->file($filePath);
    }

    public function respon($id)
    {
        // Cari Magang berdasarkan ID
        $bimbingan = Bimbingan::find($id);

        return view('backend.bimbingan.guru.edit', ['bimbingan' => $bimbingan]);
    }


    public function guru_respon(Request $request, $id)
    {
        // Cari Magang berdasarkan ID
        $bimbingan = Bimbingan::find($id);

        $bimbingan->status = $request->status;
        $bimbingan->respon = $request->respon;
        $bimbingan->update();

        return redirect()->route('guru.bimbingan-siswa', ['id' => $bimbingan->magang_id])->with('success', 'Bimbingan Berhasil diedit!');
    }

    public function setujuiBimbingan(Request $request, $id)
    {
        $responSetujui = $request->input('respon');

        $bimbingan = Bimbingan::find($id);

        if (!$bimbingan) {
            return redirect()->back()->with('error', 'Bimbingan tidak ditemukan.');
        }

        // Lakukan apa yang Anda perlukan dengan persetujuan, misalnya, simpan ke database
        $bimbingan->status = 1;
        $bimbingan->respon = $responSetujui;
        $bimbingan->save();

        return redirect()->back()->with('success', 'Bimbingan berhasil disetujui.');
    }

    public function tolakBimbingan(Request $request, $id)
    {
        $responDitolak = $request->input('respon');

        $bimbingan = Bimbingan::find($id);

        if (!$bimbingan) {
            return redirect()->back()->with('error', 'Bimbingan tidak ditemukan.');
        }

        // Lakukan apa yang Anda perlukan dengan persetujuan, misalnya, simpan ke database
        $bimbingan->status = 3;
        $bimbingan->respon = $responDitolak;
        $bimbingan->save();

        return redirect()->back()->with('success', 'Bimbingan berhasil ditolak.');
    }


    public function ajukan_sidang()
    {
        $user = Auth::user();
        $userId = $user->siswa->id;

        $magang = Magang::where('siswa_id', $userId)->first();
        $magangId = $magang->id;

        // Periksa apakah sudah ada data sidang untuk magang ini
        $existingSidang = Sidang::where('magang_id', $magangId)->first();

        if ($existingSidang) {
            return redirect('siswa/bimbingan')->with("error", "Anda sudah mengajukan sidang sebelumnya.");
        }

        Sidang::create([
            'magang_id' => $magangId,
        ]);

        return redirect('siswa/bimbingan')->with("success", "Sukses Mengajukan Sidang");
    }
}
