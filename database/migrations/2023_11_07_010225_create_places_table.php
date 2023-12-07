<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code_name');
            $table->string('altitude');
            $table->string('latitude');
            $table->integer('radius');
            $table->string('image') -> nullable();
            $table->timestamps();
        });
    }

     // Obtener la URL completa del avatar
     public function getUrlAttribute()
     {
         return Storage::disk('buildings') -> url($this-> file_name);
     }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('places');
    }
};
