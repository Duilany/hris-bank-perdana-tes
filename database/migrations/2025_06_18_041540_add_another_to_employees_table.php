<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('npwp', 25)->nullable()->unique()->after('nik');
            $table->foreignId('division_id')->nullable()->constrained('divisions', 'division_id')->onDelete('set null')->after('cv_file');
            $table->foreignId('position_id')->nullable()->constrained('positions', 'position_id')->onDelete('set null')->after('division_id');

            if (Schema::hasColumn('employees', 'divisi')) {
                $table->dropColumn('divisi');
            }
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // Drop foreign key constraints first
            $table->dropForeign(['division_id']);
            $table->dropForeign(['position_id']);

            // Drop the columns
            $table->dropColumn('division_id');
            $table->dropColumn('position_id');
            $table->dropColumn('npwp');

            // Re-add 'divisi' column
            $table->string('divisi')->nullable()->after('user_id');
        });
    }
};
