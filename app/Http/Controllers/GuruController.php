<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use App\Models\Magang;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {

        $guru = Guru::orderby('nama', 'asc')
        ->paginate(request('perPage', 8));


        $totalguru = Guru::count(); // Menghitung total guru



        return view('backend.guru.index', ['guru' => $guru, 'totalguru' => $totalguru]);
    }

    public function add()
    {
        $guru = Guru::all();

        return view('backend.guru.add', ['guru' => $guru]);
    }

    public function store(Request $data)
    {
        $data->validate([
            'nuptk' => 'required',
            'nama' => 'required',
            'jeniskelamin' => 'required',
            'tanggal_lahir' => 'required',

            //CREATE USER
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Cek apakah username sudah dipakai
        $userExist = User::where('username', $data->username)->exists();
        $guruExist = Guru::where('nuptk', $data->nuptk)->exists();

        if ($userExist) {
            return redirect('guru/add')->with("error", "Pembuatan user dengan $data->username sudah dipakai, gunakan username login lain");
        } elseif ($guruExist) {
            return redirect('guru/add')->with("error", "Data Guru dengan NUPTK $data->nuptk sudah dipakai")->withInput();
        } else {
            // Mulai transaksi
            DB::beginTransaction();

            try {
                // Tambahkan data user
                $user = User::create([
                    'username' => $data->username,
                    'level_id' => '2',
                    'password' => Hash::make($data->password)
                ]);

                if ($user) {
                    // Tambahkan data guru dengan menggunakan ID user yang dihasilkan
                    Guru::create([
                        'user_id' => $user->id,
                        'nuptk' => $data->nuptk,
                        'nama' => $data->nama,
                        'no_hp' => $data->no_hp,
                        'jeniskelamin' => $data->jeniskelamin,
                        'tanggal_lahir' => $data->tanggal_lahir,
                    ]);
                }

                // Commit transaksi
                DB::commit();

                // Redirect atau berikan notifikasi sukses
            } catch (\Exception $e) {
                // Rollback transaksi jika terjadi kesalahan
                DB::rollback();

                // Tangani kesalahan jika diperlukan
                return redirect('guru/add')->with("error", "Terjadi kesalahan saat menyimpan data");
            }
        }
        return redirect('guru')->with([
            'success' => "Data Guru $data->nama dengan NUPTK $data->nuptk berhasil disimpan",
        ]);
    }


    public function delete($id)
    {
        // Temukan data guru berdasarkan ID
        $guru = Guru::find($id);

        // Jika data guru ditemukan
        if ($guru) {
            // Temukan data user berdasarkan user_id pada data guru
            $user = User::find($guru->user_id);

            // Jika data user ditemukan, hapus data guru dan user
            if ($user) {
                // Hapus data guru
                $guru->delete();

                // Hapus data user
                $user->delete();

                return redirect('guru')->with("success", "Data Guru $guru->nama dan user terkait berhasil dihapus");
            }
        }

        return redirect('guru')->with("error", "Data Guru tidak ditemukan");
    }

    public function search(Request $data)
    {
        // keyword pencarian
        $totalguru = Guru::count(); // Menghitung total guru

        $cari = $data->cari;
        // mengambil data transaksi
        $guru = Guru::orderBy('nama', 'asc')
        ->where(function ($query) use ($cari) {
            $query->where('nuptk', 'like', "%" . $cari . "%")
                ->orWhere('nama', 'like', "%" . $cari . "%")
                ->orWhere('no_hp', 'like', "%" . $cari . "%")
                ->orWhere('jeniskelamin', 'like', "%" . $cari . "%")
                ->orWhereHas('user', function ($subquery) use ($cari) {
                    $subquery->where('username', 'like', "%" . $cari . "%");
                });
        })
        ->paginate(8);

        // menambahkan keyword pencarian ke data kategori
        $guru->appends($data->only('cari'));

        // passing data transaksi ke view transaksi.blade.php
        return view('backend.guru.index', ['guru' => $guru, 'totalguru' => $totalguru]);
    }

}
