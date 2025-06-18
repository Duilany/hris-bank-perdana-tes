<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Employee extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'nik',
        'npwp',
        'full_name',
        'gender',
        'birth_place',
        'birth_date',
        'age',
        'marital_status',
        'ktp_address',
        'current_address',
        'city',
        'province',
        'phone_number',
        'email',
        'status',
        'hire_date',
        'separation_date',
        'cv_file',
        'division_id',
        'position_id',
    ];

    protected $with = ['user', 'division', 'position'];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'hire_date' => 'date',
            'separation_date' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function division(): BelongsTo
    {
        return $this->belongsTo(divisions::class, 'division_id');
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(positions::class, 'position_id');
    }
    public function educationHistory(): HasMany
    {
        return $this->hasMany(education_histories::class, 'employee_id');
    }

    public function workExperiences(): HasMany
    {
        return $this->hasMany(work_experiences::class, 'employee_id');
    }

    public function certifications(): HasMany
    {
        return $this->hasMany(certifications::class, 'employee_id');
    }

    public function trainingHistory(): HasMany
    {
        return $this->hasMany(training_histories::class, 'employee_id');
    }

    public function healthRecords(): HasOne
    {
        return $this->hasOne(health_records::class, 'employee_id');
    }

    public function insuranceEmployees(): HasMany
    {
        return $this->hasMany(insurance_employees::class, 'employee_id');
    }
}