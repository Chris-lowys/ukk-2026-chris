<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aspirasis', function (Blueprint $table) {
            $table->id('id_aspirasi');
            $table->unsignedBigInteger('nis');
            $table->unsignedBigInteger('id_kategori');
            $table->string('lokasi', 50);
            $table->string('ket', 50);
            $table->enum('status', ['Menunggu', 'Diproses', 'Selesai'])->default('Menunggu');
            $table->string('feedback', 255)->nullable();
            $table->string('lampiran')->nullable();
            $table->timestamps();

            // Tambah index manual sebelum foreign key
            $table->index('nis');
            $table->index('id_kategori');

            $table->foreign('nis')
                ->references('nis')
                ->on('siswas')
                ->onDelete('cascade');

            $table->foreign('id_kategori')
                ->references('id_kategori')
                ->on('kategoris')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aspirasis');
    }
};