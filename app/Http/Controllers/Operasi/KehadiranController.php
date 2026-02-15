<?php
namespace App\Http\Controllers\Operasi;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use Illuminate\Http\Request;

class KehadiranController extends Controller
{
    public function autocomplete(Request $request)
    {
        $query = (string) $request->term;
        $siswa = Peserta::where('nim', 'LIKE', "%$query%")
            ->orWhere('nama', 'LIKE', "%$query%")
            ->select(\DB::raw("CASE
                    WHEN nim IS NULL OR nim = ''
                    THEN nama
                    ELSE CONCAT(nim, ' - ', nama)
                  END as label"),
                'id as value')
            ->limit(100)->get();
        return $siswa;
    }

    public function getData(Request $request)
    {
        try {
            $request->validate([
                'search' => 'required',
            ]);

            $siswa = Peserta::where('id', '=', $request->search)
                ->with('prodi', 'tahun', 'user', 'status', 'kehadiran')
                ->first();

            if ($siswa == null) {
                return response()->json([
                    'status' => false,
                    'data'   => "Tidak ada data",
                ]);
            }
            return response()->json([
                'status' => true,
                'data'   => $siswa,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'data'   => 'Tidak ada data',
                'err'    => $th->getMessage(),
            ]);
        }
    }
}
