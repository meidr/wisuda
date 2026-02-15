<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        DB::table('prodi')->insert([
            [
                'alias' => "ESY",
                'nama' => "Ekonomi Syariah",
                'jenjang' => "S1",
                'warna' => "success",
            ],
            [
                'alias' => "BKI",
                'nama' => "Bimbingan dan Konseling Islam",
                'jenjang' => "S1",
                'warna' => "success",
            ],
            [
                'alias' => "KPI",
                'nama' => "Komunikasi dan Penyiarah Islam",
                'jenjang' => "S1",
                'warna' => "success",
            ],
            [
                'alias' => "AS-HK",
                'nama' => "Hukum Keluarga Islam (Ahwal Al Syakhshiyah)",
                'jenjang' => "S1",
                'warna' => "success",
            ],
            [
                'alias' => "SPI",
                'nama' => "Sejarah Peradaban Islam",
                'jenjang' => "S1",
                'warna' => "success",
            ],
            [
                'alias' => "PAI",
                'nama' => "Pendidikan Agama Islam",
                'jenjang' => "S1",
                'warna' => "success",
            ],
            [
                'alias' => "MPI",
                'nama' => "Manajemen Pendidikan Islam",
                'jenjang' => "S1",
                'warna' => "success",
            ],
            [
                'alias' => "PBA",
                'nama' => "Pendidikan Bahasa Arab",
                'jenjang' => "S1",
                'warna' => "success",
            ],
            [
                'alias' => "PBAS2",
                'nama' => "Pendidikan Bahasa Arab S2",
                'jenjang' => "S2",
                'warna' => "primary",
            ],
            [
                'alias' => "MPIS2",
                'nama' => "Manajemen Pendidikan Islam S2",
                'jenjang' => "S2",
                'warna' => "primary",
            ],
            [
                'alias' => "PAIS3",
                'nama' => "Pendidikan Agama Islam S3",
                'jenjang' => "S3",
                'warna' => "danger",
            ],
        ]);
        DB::table('api')->insert([
            [
                'uri' => 'https://api.fonnte.com/send',
                'type' => 'notif_wa_fonnte',
                'token' => '8u98uP5WD5XHDCMre9Ux',
                'userkey' => null,
            ],
            [
                'uri' => 'https://console.zenziva.net/wareguler/api/sendWA/',
                'type' => 'notif_wa_zenziva',
                'token' => '50c4a36e0d5e244747ff3f62',
                'userkey' => '4b7c9a2bda06',
            ],
        ]);
        DB::table('status')->insert([
            [
                'nama' => 'terdaftar',
                'warna' => 'dark',
            ],
            [
                'nama' => 'terverifikasi',
                'warna' => 'primary',
            ],
            [
                'nama' => 'datang',
                'warna' => 'warning',
            ],
            [
                'nama' => 'selesai',
                'warna' => 'success',
            ],
            [
                'nama' => 'ditolak',
                'warna' => 'danger',
            ],
        ]);
        DB::table('setting')->insert([
            [
                'slug' => 'otp',
                'value' => 0,
            ],
            [
                'slug' => 'vendor_notifikasi',
                'value' => 'fonnte',
            ],
            [
                'slug' => 'isi_pesan_wa',
                'value' => 'assalamualaikum',
            ],
        ]);
        DB::table('tahun')->insert([
            // [
            //     'kode' => '23',
            //     'nama' => '2023',
            //     'status' => 'Y',
            // ],
            [
                'kode' => '24',
                'nama' => '2024',
                'status' => 'Y',
            ],
        ]);
        DB::table('role')->insert([
            [
                'nama' => 'admin',
                'prioritas' => 1,
            ],
        ]);
        DB::table('role')->insert([
            [
                'nama' => 'peserta',
                'prioritas' => 2,
            ],
        ]);

        DB::table('users')->insert([
            [
                'username' => 'admin',
                'nama' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('dalwa123'),
                'role_id' => 1,
                'jenis_kelamin' => 'Laki-Laki',
                'no_unik' => 'dalwa123'
            ],
            [
                'username' => 'peserta',
                'nama' => 'Peserta',
                'email' => 'calon@gmail.com',
                'password' => Hash::make('dalwa123'),
                'role_id' => 2,
                'jenis_kelamin' => 'Perempuan',
                'no_unik' => 'dalwa123'
            ],
            [
                'username' => 'peserta2',
                'nama' => 'Peserta 2',
                'email' => 'calon2@gmail.com',
                'password' => Hash::make('dalwa123'),
                'role_id' => 2,
                'jenis_kelamin' => 'Laki-Laki',
                'no_unik' => 'dalwa123'
            ],
        ]);

        DB::table('list_dokumen')->insert([
            [
                'tipe' => 'Foto Resmi Background Merah',
                'status' => 'wajib',
                'upload' => 'png,jpg,jpeg',
            ],
            [
                'tipe' => 'Kwitansi Lunas Jamiah',
                'status' => 'wajib',
                'upload' => 'pdf',
            ],
        ]);

        DB::table('peserta')->insert([
            [
                'user_id' => 2,
                'tahun_id' => 1,
                'nama' => 'Ini Peserta',
                'nim' => '20201',
                'alamat' => 'malang',
                'tanggal_daftar' => \Carbon::parse('2023-01-30'),
                'prodi_id' => 3,
                'status_id' => 1,
            ],
            [
                'user_id' => 3,
                'tahun_id' => 1,
                'nama' => 'Ini Peserta 2',
                'nim' => '20202',
                'alamat' => 'malang 2',
                'tanggal_daftar' => \Carbon::parse('2024-02-30'),
                'prodi_id' => 2,
                'status_id' => 1,
            ],
        ]);

        DB::table('jadwal')->insert([
            [
                'tahun_id' => 1,
                'mulai' => \Carbon::parse('2024-05-24'),
                'berakhir' => \Carbon::parse('2024-10-10'),
            ]
        ]);

        DB::table('kuota')->insert([
            [
                'tahun_id' => 1,
                'jenis' => "Laki-Laki",
                'kuota' => 10
            ],
            [
                'tahun_id' => 1,
                'jenis' => "Perempuan",
                'kuota' => 20
            ],
        ]);

        DB::table('biaya')->insert([
            [
                'tahun_id' => 1,
                'jenjang' => "S1",
                'jumlah' => 3000000
            ],
            [
                'tahun_id' => 1,
                'jenjang' => "S2",
                'jumlah' => 3000000
            ],
            [
                'tahun_id' => 1,
                'jenjang' => "S3",
                'jumlah' => 3000000
            ],
        ]);
    }
}