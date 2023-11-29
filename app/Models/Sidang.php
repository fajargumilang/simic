<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sidang extends Model
{
    protected $table = "sidang";
    protected $fillable = [
        "magang_id",
        "jadwal_sidang",
        "penguji"
    ];

    public function magang()
    {
        return $this->belongsTo(Magang::class, 'magang_id');
    }
}
