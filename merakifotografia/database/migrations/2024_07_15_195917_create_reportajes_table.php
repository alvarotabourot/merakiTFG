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
        Schema::create('reportajes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('foto');
            $table->string('descripcion');
            $table->date('fecha');
            $table->foreignId('user_id');
            $table->foreignId('categoria_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportajes');
    }
};
