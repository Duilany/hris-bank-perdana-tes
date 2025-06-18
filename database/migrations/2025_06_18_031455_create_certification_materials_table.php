<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    public function up(): void
    {
        Schema::create('certification_materials', function (Blueprint $table) {
            $table->id('certification_materials_id');
            $table->foreignId('certification_id')->constrained('certifications', 'certification_id')->cascadeOnDelete();
            $table->string('file_path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certification_materials');
    }
};
