<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up(): void
    {
        Schema::create('ruangan', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 10);
            $table->string('nama');
            $table->integer('kapasitas');
            $table->timestamps();
        });
    }
    /**
     * Rollback migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruangan');
    }
};
