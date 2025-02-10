<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('alamat')->after('nama_lengkap');
            $table->date('tgl_lahir')->nullable()->after('alamat');
            $table->string('nama_wali')->nullable()->after('tgl_lahir');
            $table->string('no_telp_wali')->after('nama_wali'); 
            $table->enum('peran', ['santri', 'pengajar'])->after('no_telp_wali');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('alamat');
            $table->dropColumn('tgl_lahir');
            $table->dropColumn('nama_wali');
            $table->dropColumn('no_telp_wali');
            $table->dropColumn('peran');
        });
    }
};
