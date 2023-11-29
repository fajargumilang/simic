<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = "siswa";
    protected $fillable = [
        "user_id",
        "nisn",
        "nama",
        "jurusan_id",
        "tahun_awal",
        "tahun_akhir",
        "no_hp",
        "jeniskelamin",
        "tanggal_lahir"
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function magang()
    {
        return $this->hasMany(Magang::class);
    }

    public function bimbingan()
    {
        return $this->hasMany(Bimbingan::class);
    }
}
