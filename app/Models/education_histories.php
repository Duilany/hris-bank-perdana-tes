<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class education_histories extends Model
{
    use HasFactory;
    
    // Memberitahu Eloquent bahwa nama tabelnya adalah 'education_history'
    protected $table = 'education_history';

    protected $primaryKey = 'education_id';

    protected $fillable = [
        'employee_id',
        'education_level',
        'institution_name',
        'institution_address',
        'major',
        'start_year',
        'end_year',
        'gpa_or_score',
        'certificate_number',
    ];

    protected function casts(): array
    {
        return [
            'gpa_or_score' => 'decimal:2',
        ];
    }
    
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}