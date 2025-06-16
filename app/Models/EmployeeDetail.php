<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id', 'nama_lengkap', 'nik', 'tempat_lahir', 'tanggal_lahir',
        'alamat', 'no_hp', 'jenis_kelamin', 'agama', 'status_perkawinan'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
