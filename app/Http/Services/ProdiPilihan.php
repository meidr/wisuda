<?php

namespace App\Http\Services;

use App\Models\Prodi;

class ProdiPilihan
{
    public static function getPilihan3()
    {
        $prodi = Prodi::where('strata', 'S1')
            ->where(function ($q) {
                $q->orWhere('id', 5);
                $q->orWhere('id', 6);
                $q->orWhere('id', 7);
                $q->orWhere('id', 8);
            })
            ->get();
        return $prodi;
    }
    public static function getPilihan2()
    {
        $prodi = Prodi::where('strata', 'S1')
            ->where(function ($q) {
                $q->orWhere('id', 2);
                $q->orWhere('id', 1);
                $q->orWhere('id', 3);
                $q->orWhere('id', 4);
            })
            ->get();
        return $prodi;
    }
}