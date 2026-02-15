<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUrutanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urutan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahun_id')->nullable()->constrained('tahun');
            $table->foreignId('peserta_id')->nullable()->constrained('peserta');
            $table->foreignId('prodi_id')->nullable()->constrained('prodi');
            $table->integer('urutan');
            $table->enum('jenis', ['peserta', 'batas']);
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan']);
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
        Schema::dropIfExists('urutan');
    }
}
