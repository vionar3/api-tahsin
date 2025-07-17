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
             $table->dropColumn(['feedback_pengajar', 'nilai', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('latihan', function (Blueprint $table) {
            $table->text('feedback_pengajar')->nullable();
            $table->integer('nilai')->nullable();
            $table->string('status', 20)->nullable();
        });
    }
};
