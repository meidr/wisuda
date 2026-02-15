<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesertaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peserta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('tahun_id')->constrained('tahun');
            $table->date('tanggal_daftar');
            $table->enum('mahasiswa', 'vip', 'vvip')->default('mahasiswa');
            $table->string('nama');
            $table->string('nim')->nullable();
            $table->string('judul')->nullable();
            $table->string('nama_ayah')->nullable();
            $table->date('tanggal_sidang')->nullable();
            $table->string('nama_arab')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('nomor_hp')->nullable();
            $table->string('alamat')->nullable();
            $table->string('email')->nullable();
            $table->string('bulan')->nullable();
            $table->foreignId('prodi_id')->constrained('prodi')->nullable();
            $table->enum('tipe_identitas', ['KTP', 'KK', 'SIM', 'Paspor'])->nullable();
            $table->string('nomor_identitas')->nullable();
            $table->string('propinsi')->nullable();
            $table->string('kota')->nullable();
            $table->enum('ukuran_baju', ['S', 'M', 'L', 'XL', 'XXL', 'XXXL'])->nullable();
            $table->foreignId('status_id')->constrained('status');
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
        Schema::dropIfExists('peserta');
    }
}
