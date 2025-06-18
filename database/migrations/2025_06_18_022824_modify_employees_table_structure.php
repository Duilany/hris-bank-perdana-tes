<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Stringable;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // Gunakan schema builder terpisah untuk mengubah struktur kolom nik
            Schema::table('employees', function (Blueprint $table) {
                $table->string('nip', 20)->unique()->nullable(false)->change();
            });

            // Lanjutkan proses rename kolom lain jika ada
            if (Schema::hasColumn('employees', 'nip')) {
                $table->renameColumn('nip', 'nik');
            }
            if (Schema::hasColumn('employees', 'tanggal_masuk')) {
                $table->renameColumn('tanggal_masuk', 'hire_date');
            }

            // Tambahkan kolom-kolom baru
            $table->string('full_name', 100)->after('nik');
            $table->enum('gender', ['L', 'P'])->after('full_name');
            $table->string('birth_place', 50)->after('gender');
            $table->date('birth_date')->after('birth_place');
            $table->integer('age')->after('birth_date');
            $table->enum('marital_status', ['TK', 'K0', 'K1', 'K2', 'K3'])->after('age');
            $table->text('ktp_address')->after('marital_status');
            $table->text('current_address')->after('ktp_address');
            $table->string('city', 50)->after('current_address');
            $table->string('province', 50)->after('city');
            $table->string('phone_number', 20)->after('province');
            $table->string('email', 100)->unique()->after('phone_number');
            $table->date('separation_date')->nullable()->after('hire_date');
            $table->string('cv_file')->after('separation_date');

            // Hapus kolom-kolom sisa yang tidak terpakai
            if (Schema::hasColumn('employees', 'jabatan')) {
                $table->dropColumn('jabatan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // 1. Tambahkan kembali kolom-kolom yang dihapus
            $table->string('jabatan')->nullable()->after('user_id');

            // 2. Hapus kolom-kolom baru
            $table->dropColumn([
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
                'separation_date',
                'cv_file'
            ]);

            // 3. Kembalikan perubahan pada kolom nik
            $table->dropColumn(['nik']);
            $table->string('nik')->nullable()->change();

            // 4. Kembalikan nama kolom seperti semula
            $table->renameColumn('employee_id', 'id');
            $table->renameColumn('nik', 'nip');
            $table->renameColumn('hire_date', 'tanggal_masuk');
        });
    }
};