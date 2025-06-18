<?php

// app/Models/Pengumuman.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumuman';

    protected $fillable = [
        'judul',
        'isi',
        'user_id',
        'tipe',
        'attachment', // untuk menyimpan file PDF/gambar
        'label', // untuk menyimpan label pengumuman
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function polling()
{
    return $this->hasOne(Polling::class);
}
}
