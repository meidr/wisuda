<?php
namespace App\Http\Controllers\Operasi;

use App\Http\Controllers\Controller;
use App\Http\Services\Mahasiswa;
use App\Http\Services\MahasiswaPasca;
use App\Models\Peserta;
use Illuminate\Http\Request;

class PesertaController extends Controller
{
    public function autocomplete(Request $request)
    {
        $query = (string) $request->term;
        if ($request->tipe == 'sarjana') {
            $siswa = Mahasiswa::all(null, 100, $query, null, null, null);
        } else {
            $siswa = MahasiswaPasca::all(null, 100, $query, null, null, null);
        }

        return array_map(function ($item) {
            return "$item->nim - $item->nama";

        }, $siswa);

        return $siswa;
        // where('nim', 'LIKE', "%$query%")
        //     ->orWhere('nama', 'LIKE', "%$query%")
        //     ->select(\DB::raw("CONCAT(nim,' - ',nama) as nimnama"))
        //     ->limit(100)->pluck('nimnama')->toArray();
    }

    public function getData(Request $request)
    {
        try {
            $request->validate([
                'search' => 'required',
                'tipe'   => 'required',
            ]);

            $responseSiswa = null;
            $siswa         = Peserta::where('nim', '=', $request->search)
                ->with('prodi', 'tahun', 'user', 'status')
                ->first();

            if ($siswa) {
                return response()->json([
                    'status'  => true,
                    'request' => $request->all(),
                    'data'    => $siswa,
                ]);
            }

            if ($request->tipe == 'sarjana') {
                $siswa = Mahasiswa::nim($request->search);
            } else {
                $siswa = MahasiswaPasca::nim($request->search);
            }

            if ($siswa->status) {
                return response()->json([
                    'status'  => true,
                    'request' => $request->all(),
                    'data'    => $siswa->data->data,
                ]);
            } else {
                return response()->json([
                    'status'  => false,
                    'request' => $request->all(),
                    'data'    => $siswa->message,
                    'code'    => $siswa->code,
                ]);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => false,
                'data'   => 'Tidak ada data, silahkan diisi manual jika dibutuhkan',
                'err'    => $th->getMessage(),
            ]);
        }
    }
}
