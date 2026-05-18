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
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_fasilitas')->nullable();
            $table->unsignedBigInteger('id_destinasi')->nullable();
            $table->foreign('id_fasilitas')->references('id')->on('fasilitas')->onDelete('cascade');
            $table->foreign('id_destinasi')->references('id')->on('destinasis')->onDelete('cascade');
            $table->string('path');
            $table->string('keterangan')->nullable();
            $table->string('type')->default('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
