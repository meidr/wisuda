<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKuotaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kuota', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahun_id')->constrained('tahun');
            $table->enum('jenis', ['Laki-Laki', 'Perempuan']);
            $table->enum('jenjang', ['S1', 'Pasca']);
            $table->integer('kuota');
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
        Schema::dropIfExists('kuota');
    }
}
