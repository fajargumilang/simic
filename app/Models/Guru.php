<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = "guru";
    protected $fillable = [
        "user_id",
        "nuptk",
        "nama",
        "no_hp",
        "jeniskelamin",
        "tanggal_lahir",
    ];

    
    
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
