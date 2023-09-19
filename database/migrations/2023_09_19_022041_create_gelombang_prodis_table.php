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
        Schema::create('gelombang_prodis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gelombang_id')->nullable(); 
            $table->foreign('gelombang_id')->references('id')->on('gelombangs'); 
            $table->unsignedBigInteger('prodi_id')->nullable(); 
            $table->foreign('prodi_id')->references('id')->on('prodis'); 
            $table->integer('kuota');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gelombang_prodis');
    }
};
