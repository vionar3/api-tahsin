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
        Schema::table('progress', function (Blueprint $table) {
            $table->foreignId('id_latihan')->nullable()->constrained('latihan')->onDelete('cascade')->after('id_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('progress', function (Blueprint $table) {
            $table->dropForeign(['id_latihan']); // Menghapus foreign key
            $table->dropColumn('id_latihan'); // Menghapus kolom
        });
    }
};
