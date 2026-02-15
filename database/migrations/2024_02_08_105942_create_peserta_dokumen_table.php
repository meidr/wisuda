<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesertaDokumenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peserta_dokumen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_id')->constrained('peserta');
            $table->date('tanggal');
            $table->foreignId('list_dokumen_id')->constrained('list_dokumen');
            $table->string('file')->nullable();
            $table->string('path')->nullable();
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
        Schema::dropIfExists('peserta_dokumen');
    }
}
