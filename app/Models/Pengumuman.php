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
        'user_id', // atau 'dibuat_oleh' sesuai kolommu
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
