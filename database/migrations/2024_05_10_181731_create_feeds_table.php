<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feeds', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('kategori', ['Aspirasi', 'Pengaduan', 'Informasi']);
            $table->string('judul', 255);
            $table->text('deskripsi');
            $table->string('file_path')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feeds');
    }
};
