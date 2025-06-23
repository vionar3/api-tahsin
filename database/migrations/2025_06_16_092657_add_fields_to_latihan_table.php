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
        Schema::table('latihan', function (Blueprint $table) {
            $table->text('feedback_pengajar')->nullable()->after('recorder_audio');
            $table->decimal('nilai', 5, 2)->nullable()->after('feedback_pengajar');
            $table->enum('status', ['benar', 'salah'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('latihan', function (Blueprint $table) {
            $table->dropColumn('feedback_pengajar');
            $table->dropColumn('nilai');
            $table->dropColumn('status');
        });
    }
};
