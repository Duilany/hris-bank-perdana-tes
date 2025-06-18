<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class training_materials extends Model
{
    use HasFactory;

    protected $primaryKey = 'certification_materials_id';

    protected $fillable = [
        'certification_id',
        'file_path',
    ];

    public function trainingHistory(): BelongsTo
    {
        return $this->belongsTo(training_histories::class, 'training_id');
    }
}
