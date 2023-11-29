<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bimbingan extends Model
{
    protected $table = "bimbingan";
    protected $fillable = [
        "magang_id",
        "file_upload",
        "komentar",
        "status",
        "respon"
    ];


    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function magang()
    {
        return $this->belongsTo(Magang::class, 'magang_id');
    }
}
