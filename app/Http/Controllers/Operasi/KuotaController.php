<?php

namespace App\Http\Controllers\Operasi;

use App\Models\Kuota;
use App\Models\Peserta;
use Illuminate\Http\Request;
use App\Http\Services\ProdiPilihan;
use App\Http\Controllers\Controller;

class KuotaController extends Controller
{
    public function show()
    {
        return true;
    }

    public function getData(Request $request)
    {
        try {
            $request->validate([
                'tahun_id' => 'required',
                'jenjang' => 'required',
            ]);

            $kuota = Kuota::where('tahun_id', $request->tahun_id)
                ->where('jenjang', $request->jenjang)
                ->get();

            foreach ($kuota as $k) {
                $isi = Peserta::join('users', 'users.id', 'peserta.user_id')
                    ->join('prodi', 'prodi.id', 'peserta.prodi_id')
                    ->where('peserta.tahun_id', $request->tahun_id)
                    ->where('users.jenis_kelamin', $k->jenis)
                    ->where(function ($q) use ($request) {
                        if ($request->jenjang == 'S1') {
                            $q->where('prodi.jenjang', 'S1');
                        } else {
                            $q->orWhere('prodi.jenjang', 'S2');
                            $q->orWhere('prodi.jenjang', 'S3');
                        }
                    })
                    ->count();
                $k->isi = $isi;
                $k->kuota = $k->kuota - $isi;
            }

            return response()->json([
                'status' => true,
                'data' => $kuota,
                'request' => $request->all()
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => false,
                'data' => null,
                'err' => $th->getMessage(),
                'request' => $request->all()
            ]);
        }
    }
}
