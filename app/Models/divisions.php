<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class divisions extends Model
{
    use HasFactory;

    protected $primaryKey = 'division_id';

    protected $fillable = ['name'];

    /**
     * Relasi ke Employee (satu divisi memiliki banyak karyawan).
     */
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'division_id', 'division_id');
    }
}