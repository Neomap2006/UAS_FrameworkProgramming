<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('landing_programs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('icon')->nullable()->comment('Font Awesome class, misal: fa-solid fa-graduation-cap');
            $table->string('image')->nullable()->comment('Path gambar di storage: programs/nama-file.jpg');
            $table->integer('position')->default(0)->index();
            $table->boolean('status')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('landing_programs');
    }
};
