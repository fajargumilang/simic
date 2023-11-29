<?php

namespace App\Http\Controllers;

use App\Models\Magang;
use App\Models\Siswa;
use App\Models\Guru;

use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;

class MagangController extends Controller
{

    public function index()
    {
        $siswa = Siswa::all();
        $guru = Guru::all();
        $magang = Magang::where('status', '1')
            ->orderBy('id', 'desc')
            ->get();
        return view('backend.magang.index', ['magang' => $magang, 'guru' => $guru, 'siswa' => $siswa]);
    }

    public function list_approve()
    {
        $permohonan_magang = Magang::orderBy('id', 'desc')->get();

        return view('backend.magang.list_approve', ['permohonan_magang' => $permohonan_magang]);
    }

    // ============================ PERSETUJUAN DAN PENOLAKAN PERMOHONAN MAGANG SISWA ============================


    // PERSETUJUAN PERMOHONAN MAGANG (STATUS)
    // 2 = MENUNGGU PERMOHONAN 
    // 1 = DISETUJUI MANDATORY "UPLOAD BUKTI DITERIMA DARI PERUSAHAAN MAGANG" UNTUK DAPAT BIMBINGAN
    // 3 = DITOLAK

    public function approve($id)
    {
        $persetujuan = Magang::findOrFail($id);
        $persetujuan->status = '1';
        $persetujuan->save();

        return redirect('admin/permohonan-magang')->with('success', 'Magang ' . $persetujuan->siswa->nama . ' dengan nisn ' . $persetujuan->siswa->nisn . ' telah disetujui');
    }


    public function reject($id)
    {
        $penolakan = Magang::findOrFail($id);
        $penolakan->status = '3';
        $penolakan->save();

        return redirect('admin/permohonan-magang')->with('success', 'Magang ' . $penolakan->siswa->nama . ' dengan nisn ' . $penolakan->siswa->nisn . ' telah ditolak');
    }

    public function simpanGuru(Request $request, $id)
    {
        // Validasi dan pastikan user yang memiliki izin untuk melakukan ini

        // Ambil nilai guru_id dari permintaan
        $guruId = $request->input('guru_id');

        // Temukan magang berdasarkan ID
        $magang = Magang::find($id);

        if (!$magang) {
            // Handle jika magang tidak ditemukan
            return redirect()->back()->with('error', 'Magang tidak ditemukan.');
        }

        // Setel nilai guru_id berdasarkan yang dipilih
        $magang->guru_id = $guruId;

        // Simpan perubahan ke dalam database
        $magang->save();

        // Redirect atau berikan respons sukses sesuai kebutuhan
        return redirect('admin/magang')->with('success', 'Guru pembimbing berhasil dipilih.');
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
