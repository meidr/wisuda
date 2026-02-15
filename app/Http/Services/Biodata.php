<?php

namespace App\Http\Services;

use App\Models\Dokumen;
use App\Models\ListDokumen;
use App\Models\OrangTua;

class Biodata
{
    /**
     * fungsi untuk cek kelengkapan data buodata calon mahasiswa
     * @param mixed $siswa
     * @return [status => true for bidata full]
     */
    public static function cekSiswa($siswa)
    {
        $data = [
            'tanggal_daftar',
            // 'nomor_pendaftaran',
            'nik',
            'nisn',
            'nis1',
            'nis2',
            'nama',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'nomor_hp',
            'alamat',
            'asal_sekolah',
            'alamat_asal_sekolah',
            'jurusan',
            'status',
            'tahun_pelajaran',
            // 'otp',
            // 'otpx',
            // 'otp_request',
            'password',
            'saudara',
            'anak_ke',
            // 'perwakilan',
            // 'created_at',
            // 'updated_at',
            // 'status_siswa',
            // 'hobi',
            // 'no_kamar',
            // 'cita_cita',
            // 'jenis_sekolah_sebelumnya',
            // 'status_sekolah_sebelumnya',
            // 'no_peserta_sekolah_sebelumnya',
            'propinsi',
            'kota',
            'kecamatan',
            // 'desa',
            // 'kodepos',
            // 'jurusan_kelas',
            // 'kota_lokasi_sekolah',
            // 'nomor_kk',
            // 'pendidikan_yang_ditempuh',
            // 'pendidikan_yang_ditempuh1',
            'strata',
            'prodi',
            'prodi_id',
            'prodi_nama',
            'from',
            'asalpmb',
            'tanggal_masuk',
            'status_masuk',
            'smt_masuk',
            'nama_asal_pt',
            'prodi_pt',
            'thnlulus_pt',
            'thnmasuk_pt',
            'kota_pt',
            // 'aktiv_tahun',
            // 'aktiv_nama_organ',
            // 'aktiv_jenis_organ',
            // 'prodi_yang_dipilih',
            // 'pindah_asal_pt',
            // 'pindah_alamat_pt',
            // 'pindah_prodi_pt',
            // 'pindah_pekerjaan',
            // 'pindah_status_kawin',
            // 'pindahnama_suais',
            'email',
            'kota_asal_sekolah',
            'jurusan_asal_sekolah',
            'tahun_lulus_asal_sekolah',
            // 'semester_masuk',
            // 'pekerjaan',
            // 'status_kawin',
            // 'nama_suami_istri',
            'kewarganegaraan',
            'riwayat_pendidikan',
            'agama',
            // 'tipe_nomor_id',
            // 'laki',
            // 'perem',
            // 'kembar',
            // 'gelom',
            // 'passkey',
            'prodi_id_pilihan_2',
            'prodi_id_pilihan_3',
            // 'prodi_id_diterima',
            'almamater',
            // 'jenis_pembayaran',
            // 'active_page'
        ];

        $siswa = $siswa->toArray();
        $cek = false;
        $dataNull = [];
        foreach ($data as $key => $value) {
            if ($siswa[$value] == null) {
                $cek = true;
                $dataNull[] = $value;
            }
        }

        if ($cek) {
            return [
                'status' => false,
                'data_null' => $dataNull
            ];
        }

        return [
            'status' => true,
            'data_null' => $dataNull
        ];
    }

    public static function cekOrangTua($siswa)
    {
        $data = [
            'siswa_id',
            'nama_ayah',
            'nomor_hp_ayah',
            'pendidikan_ayah',
            'pekerjaan_ayah',
            'penghasilan_ayah',
            // 'bangsa_ayah',
            // 'agama_ayah',
            'nama_ibu',
            'nomor_hp_ibu',
            'pendidikan_ibu',
            'pekerjaan_ibu',
            'penghasilan_ibu',
            // 'bangsa_ibu',
            // 'agama_ibu',
            'alamat_ortu',
            'nama_wali',
            'alamat_wali',
            'hubungan_wali',
            // 'status',
            'pekerjaan_wali',
            'nomor_hp_wali',
            'nomor_hp_lain',
            // 'agama_wali',
            // 'tempat_lahir',
            // 'tanggal_lahir',
            'pendidikan_wali',
            // 'created_at',
            // 'updated_at',
        ];

        $orangtua = OrangTua::where('siswa_id', $siswa->id)->first();
        $orangtua = isset($orangtua) ? $orangtua->toArray() : [];
        $cek = false;
        $dataNull = [];
        foreach ($data as $key => $value) {
            if (isset($orangtua[$value]) == null) {
                $cek = true;
                $dataNull[] = $value;
            }
        }

        if ($cek) {
            return [
                'status' => false,
                'data_null' => $dataNull
            ];
        }

        return [
            'status' => true,
            'data_null' => $dataNull
        ];

    }

    /**
     * fungsi untuk cek kelengkapan dokumen calon mahasiswa
     * @param mixed $siswa
     * @return [status => true for dokumen full]
     */
    public static function cekDokumen($siswa)
    {
        $listDokumen = ListDokumen::where('jenis', 'SEMUA')
            ->where('status', 'wajib')
            ->orWhere('jenis', $siswa->getProdi->strata)->get();

        $cek = false;
        $dataNull = [];
        foreach ($listDokumen as $key => $value) {
            $tipe = $value->tipe;

            if ($siswa->status_masuk == 'Baru') {
                if (strtolower($tipe) === 'transkip nilai') {
                    continue;
                }
            }

            $cekDokumen = Dokumen::where([
                ['siswa_id', $siswa->id],
                ['tipe', $tipe]
            ])->first();
            if (!$cekDokumen) {
                $cek = true;
                $dataNull[] = $tipe;

            }
        }

        if ($cek) {
            return [
                'status' => false,
                'data_null' => $dataNull
            ];
        }

        return [
            'status' => true,
            'data_null' => $dataNull
        ];
    }
}