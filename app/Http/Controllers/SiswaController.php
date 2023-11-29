<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Bimbingan;
use App\Models\User;
use App\Models\Jurusan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::orderby('nama', 'asc')
            ->paginate(request('perPage', 8));

        $totalsiswa = Siswa::count(); // Menghitung total guru

        return view('backend.siswa.index', ['siswa' => $siswa, 'totalsiswa' => $totalsiswa]);
    }

    public function add()
    {
        $siswa = Siswa::all();
        $jurusan = Jurusan::all();

        return view('backend.siswa.add', ['siswa' => $siswa, 'jurusan' => $jurusan]);
    }

    public function store(Request $data)
    {
        $data->validate([
            'nisn' => 'required',
            'nama' => 'required',
            'jurusan' => 'required',
            'tahun_awal' => 'required',
            'tahun_akhir' => 'required',
            'jeniskelamin' => 'required',
            'tanggal_lahir' => 'required',

            //CREATE USER
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Cek apakah username sudah dipakai
        $userExist = User::where('username', $data->username)->exists();
        $siswaExist = Siswa::where('nisn', $data->nisn)->exists();

        if ($userExist) {
            return redirect('siswa/add')->with("error", "Pembuatan user dengan $data->username sudah dipakai, gunakan username login lain");
        } elseif ($siswaExist) {
            return redirect('siswa/add')->with("error", "Data Guru dengan NISN $data->nisn sudah dipakai")->withInput();
        } else {
            // Mulai transaksi
            DB::beginTransaction();

            try {
                // Tambahkan data user
                $user = User::create([
                    'username' => $data->username,
                    'level_id' => '3',
                    'password' => Hash::make($data->password)
                ]);

                if ($user) {
                    // Tambahkan data siswa dengan menggunakan ID user yang dihasilkan
                    Siswa::create([
                        'user_id' => $user->id,
                        'nisn' => $data->nisn,
                        'nama' => $data->nama,
                        'jurusan_id' => $data->jurusan,
                        'tahun_awal' => $data->tahun_awal,
                        'tahun_akhir' => $data->tahun_akhir,
                        'no_hp' => $data->no_hp,
                        'jeniskelamin' => $data->jeniskelamin,
                        'tanggal_lahir' => $data->tanggal_lahir
                    ]);
                }

                // Commit transaksi
                DB::commit();

                // Redirect atau berikan notifikasi sukses
            } catch (\Exception $e) {
                // Rollback transaksi jika terjadi kesalahan
                DB::rollback();

                // Tangani kesalahan jika diperlukan
                return redirect('siswa/add')->with("error", "Terjadi kesalahan saat menyimpan data");
            }
        }

        return redirect('siswa')->with("success", "Data Siswa $data->nama dengan NISN $data->nisn berhasil disimpan");
    }

    public function delete($id)
    {
        // Temukan data guru berdasarkan ID
        $siswa = Siswa::find($id);

        // Jika data guru ditemukan
        if ($siswa) {
            // Temukan data user berdasarkan user_id pada data siswa
            $user = User::find($siswa->user_id);

            // Jika data user ditemukan, hapus data guru dan user
            if ($user) {
                // Hapus data guru
                $siswa->delete();

                // Hapus data user
                $user->delete();

                return redirect('siswa')->with("success", "Data Siswa $siswa->nama dan user terkait berhasil dihapus");
            }
        }

        return redirect('siswa')->with("error", "Data Siswa tidak ditemukan");
    }

    public function data_bimbingan_siswa()
    {
        // Mengambil user yang sedang login
        $user = Auth::user();
        $bimbingans = Bimbingan::where('magang_id', $user->id)->get();

        // Mengembalikan data ke tampilan
        return view('data_bimbingan_siswa', ['bimbingans' => $bimbingans]);
    }

    public function search(Request $data)
    {
        $totalsiswa = Siswa::count(); // Menghitung total siswa
        
        // keyword pencarian
        $cari = $data->cari;
        // mengambil data transaksi
        $siswa = Siswa::orderBy('nama', 'asc')
        ->where(function ($query) use ($cari) {
            $query->where('nisn', 'like', "%" . $cari . "%")
                ->orWhere('nama', 'like', "%" . $cari . "%")
                ->orWhere('no_hp', 'like', "%" . $cari . "%")
                ->orWhere('tahun_awal', 'like', "%" . $cari . "%")
                ->orWhere('tahun_akhir', 'like', "%" . $cari . "%")
                ->orWhere('jeniskelamin', 'like', "%" . $cari . "%")
                ->orWhereHas('jurusan', function ($subquery) use ($cari) {
                    $subquery->where('jurusan', 'like', "%" . $cari . "%");
                })
                ->orWhereHas('user', function ($subquery) use ($cari) {
                    $subquery->where('username', 'like', "%" . $cari . "%");
                });
        })
        ->paginate(8);

        // menambahkan keyword pencarian ke data kategori
        $siswa->appends($data->only('cari'));

        // passing data transaksi ke view transaksi.blade.php
        return view('backend.siswa.index', ['siswa' => $siswa, 'totalsiswa' => $totalsiswa]);
    }
}
