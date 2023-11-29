<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Sidang;

class SidangController extends Controller
{
    public function index()
    {
        $sidang = Sidang::all();
        $guru = Guru::all();

        return view('backend.sidang.index', ['sidang' => $sidang, 'guru' => $guru]);
    }


    public function jadwal_sidang(Request $request, $id)
    {
        $sidang = Sidang::find($id);

        if (!$sidang) {
            return redirect()->back()->with('error', 'Sidang tidak ditemukan.');
        }
        $sidang->jadwal_sidang = $request->input('jadwal');

        // Ambil nilai penguji dari input teks jika "others" dipilih
        $penguji = $request->input('penguji');

        if ($penguji === 'others') {
            $otherPenguji = $request->input('otherPenguji');
            $sidang->penguji = $otherPenguji;
        } else {
            $sidang->penguji = $penguji;
        }

        // Lakukan apa yang Anda perlukan dengan persetujuan, misalnya, simpan ke database
        $sidang->save();

        return redirect()->back()->with('success', 'Sidang berhasil dijadwalkan.');
    }

    public function edit($id)
    {
        // Cari Magang berdasarkan ID
        $sidang = Sidang::find($id);
        $guru = Guru::all();
        return view('backend.sidang.edit', ['sidang' => $sidang, 'guru' => $guru]);
    }


    public function update(Request $request, $id)
    {

        $sidang = Sidang::find($id);

        if (!$sidang) {
            return redirect()->back()->with('error', 'Sidang tidak ditemukan.');
        }
        $sidang->jadwal_sidang = $request->input('jadwal_sidang');

        // Ambil nilai penguji dari input teks jika "others" dipilih
        $penguji = $request->input('penguji');

        if ($penguji === 'others') {
            $otherPenguji = $request->input('otherPenguji');
            $sidang->penguji = $otherPenguji;
        } else {
            $sidang->penguji = $penguji;
        }

        // Lakukan apa yang Anda perlukan dengan persetujuan, misalnya, simpan ke database
        $sidang->save();

        return redirect()->route('admin.sidang-siswa')->with('success', 'Sidang atas nama ' . $sidang->magang->siswa->nama .' dengan NISN '. $sidang->magang->siswa->nisn . ' berhasil diedit!');
    }
}
