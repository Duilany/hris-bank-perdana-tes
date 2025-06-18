<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use PhpParser\Node\Stmt\Return_;

class certifications extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'certification_id';

    protected $fillable = [
        'employee_id',
        'certification_name',
        'issuer',
        'description',
        'date_obtained',
        'expiry_date',
        'cost',
        'certificate_file',
    ];

    protected function casts(): array
    {
        return [
            'date_obtained' => 'date',
            'expiry_date' => 'date',
            'cost' => 'decimal:2'
        ];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function certificationMaterials(): HasMany
    {
        return $this->hasMany(certification_materials::class, 'certification_id');
    }
}