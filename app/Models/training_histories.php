<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class training_histories extends Model
{
    use HasFactory;
    
    protected $table = 'training_history';

    protected $primaryKey = 'training_id';

    protected $fillable = [
        'employee_id',
        'training_name',
        'provider',
        'description',
        'start_date',
        'end_date',
        'cost',
        'location',
        'certificate_number',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'cost' => 'decimal:2'
        ];
    }
    
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

        public function trainingMaterials(): HasMany
    {
        return $this->hasMany(training_materials::class, 'training_id');
    }
}