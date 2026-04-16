<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('aspirasis', function (Blueprint $table) {
            // Hapus foreign key dulu sebelum mengubah kolom
            $table->dropForeign(['nis']);
            $table->dropIndex(['nis']);

            // Ubah nis menjadi nullable
            $table->unsignedBigInteger('nis')->nullable()->change();

            // Tambahkan kembali index dan foreign key dengan nullable
            $table->index('nis');
            $table->foreign('nis')
                ->references('nis')
                ->on('siswas')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('aspirasis', function (Blueprint $table) {
            $table->dropForeign(['nis']);
            $table->dropIndex(['nis']);
            $table->unsignedBigInteger('nis')->nullable(false)->change();
            $table->index('nis');
            $table->foreign('nis')
                ->references('nis')
                ->on('siswas')
                ->onDelete('cascade');
        });
    }
};