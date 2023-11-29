<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Magang extends Model
{
    protected $table = "magang";
    protected $fillable = [
        "siswa_id",
        "guru_id",
        "status",
        "namaperusahaan",
        "awalmagang",
        "akhirmagang",
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function bimbingan()
    {
        return $this->hasMany(Bimbingan::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sidang()
    {
        return $this->hasMany(Sidang::class);
    }
}
