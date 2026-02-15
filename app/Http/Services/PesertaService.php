<?php

namespace App\Http\Services;

use App\Models\ListDokumen;
use App\Models\PesertaDokumen;

class PesertaService
{
    public static function cekKelengkapan($peserta)
    {
        // $listDataPeserta = \DB::getSchemaBuilder()->getColumnListing('peserta');
        $exclude = ["created_at", "updated_at", "email", "bulan", "nama_arab", "prodi", "jenis_kelamin"];
        $listDokumen = ListDokumen::where('status', 'wajib')->get();
        foreach ($peserta->toArray() as $key => $value) {
            if (in_array($key, $exclude)) {
                continue;
            }
            if ($value == null || $value == "") {
                return false;
            }
        }
        foreach ($listDokumen as $key => $value) {
            $dokumen = PesertaDokumen::where('peserta_id', $peserta->id)
                ->where('list_dokumen_id', $value->id)->first();
            if (!$dokumen) {
                return false;
            }
        }
        return true;
    }
}