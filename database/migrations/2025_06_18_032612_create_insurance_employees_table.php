<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    public function up(): void
    {
        Schema::create('insurance_employees', function (Blueprint $table) {
            $table->id('insurance_id');
            $table->foreignId('employee_id')->constrained('employees', 'id')->cascadeOnDelete();
            $table->string('insurance_number', 30)->unique();
            $table->enum('insurance_type', ['KES', 'TK', 'N-BPJS']); // KES: Kesehatan, TK: Tenaga Kerja, N-BPJS: di luar BPJS
            $table->date('start_date');
            $table->date('expiry_date')->nullable();
            $table->enum('status', ['AKTIF', 'NONAKTIF'])->default('AKTIF');
            $table->string('insurance_file')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insurance_employees');
    }
};
