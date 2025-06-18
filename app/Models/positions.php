<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class positions extends Model
{
    use HasFactory;

    protected $primaryKey = 'position_id';

    protected $fillable = ['title'];

    /**
     * Relasi ke Employee (satu posisi bisa diisi banyak karyawan).
     */
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'position_id', 'position_id');
    }
}