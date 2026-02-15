<?php

namespace App\Http\Services;

use App\Models\Prodi;
use App\Models\Jadwal as JadwalModel;

class Jadwal
{
    /**
     * Get openned prodi's data
     * @return array prodi
     */
    public static function getProdi()
    {
        $prodi = Prodi::orderBy('strata', 'asc')->get();
        $jadwal = JadwalModel::all();
        $listDeleteJadwal = [];
        foreach ($jadwal as $key => $value) {
            $now = \Carbon::now();
            $buka = \Carbon::parse($value->buka)->startOfDay();
            $tutup = \Carbon::parse($value->tutup)->endOfDay();
            if (!($now >= $buka && $now <= $tutup)) {
                $listDeleteJadwal[] = $value->prodi_id;
            }
        }

        foreach ($prodi as $key => $value) {
            if (in_array($value->id, $listDeleteJadwal)) {
                unset($prodi[$key]);
            }
        }

        return $prodi;
    }

    /**
     * Check permitted registered prodi
     * @param mixed $prodiId
     * @return boolean true for permitted and false for not permitted
     */
    public static function checkPermitted($prodiId)
    {
        $prodi = Jadwal::getProdi();
        foreach ($prodi as $key => $value) {
            if ($prodiId == $value->id) {
                return true;
            }
        }

        return false;
    }
}