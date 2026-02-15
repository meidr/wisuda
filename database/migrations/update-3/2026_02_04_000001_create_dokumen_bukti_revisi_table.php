<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDokumenBuktiRevisiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dokumen_bukti_revisi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_id')->constrained('peserta')->onDelete('cascade');
            // Bukti fields
            $table->string('file_bukti')->nullable();
            $table->string('path_bukti')->nullable();
            $table->enum('status_bukti', ['belum_validasi', 'diterima', 'ditolak'])->default('belum_validasi');
            // Revisi fields
            $table->string('file_revisi')->nullable();
            $table->string('path_revisi')->nullable();
            $table->enum('status_revisi', ['belum_validasi', 'diterima', 'ditolak'])->default('belum_validasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dokumen_bukti_revisi');
    }
}
