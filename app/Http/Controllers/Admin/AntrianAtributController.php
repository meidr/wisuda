<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AntrianAtribut;
use App\Models\Peserta;
use App\Models\Prodi;
use App\Models\Tahun;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AntrianAtributController extends Controller
{
    public function index()
    {
        $tahun = Tahun::all();
        $prodi = Prodi::all();
        
        return view('admin.antrian_atribut.index', compact('tahun', 'prodi'));
    }

    public function dataTable(Request $request)
    {
        $search = request('search.value');
        
        // Get female students (Perempuan) with their antrian data
        $data = Peserta::join('users', 'users.id', '=', 'peserta.user_id')
            ->join('tahun', 'tahun.id', '=', 'peserta.tahun_id')
            ->leftJoin('prodi', 'prodi.id', '=', 'peserta.prodi_id')
            ->leftJoin('antrian_atribut', 'antrian_atribut.peserta_id', '=', 'peserta.id')
            ->where('users.jenis_kelamin', 'Perempuan')
            ->select(
                'peserta.*',
                'tahun.nama as tahun_nama',
                'prodi.nama as prodi_nama',
                'antrian_atribut.id as antrian_id',
                'antrian_atribut.nomor_antrian',
                'antrian_atribut.status',
                'antrian_atribut.waktu_scan'
            );

        return DataTables::of($data)
            ->addIndexColumn()
            ->filter(function ($query) use ($search, $request) {
                $query->when($request->tahun_id != "*", function ($query) use ($request) {
                    $query->where('peserta.tahun_id', $request->tahun_id);
                });
                $query->when($request->prodi_id != "*", function ($query) use ($request) {
                    $query->where('peserta.prodi_id', $request->prodi_id);
                });
                $query->when($request->status != "*", function ($query) use ($request) {
                    if ($request->status == 'belum_cetak') {
                        $query->whereNull('antrian_atribut.nomor_antrian');
                    } else {
                        $query->where('antrian_atribut.status', $request->status);
                    }
                });
                $query->where(function ($query) use ($search) {
                    $query->orWhere('peserta.nama', 'LIKE', "%$search%");
                    $query->orWhere('peserta.nim', 'LIKE', "%$search%");
                    $query->orWhere('antrian_atribut.nomor_antrian', 'LIKE', "%$search%");
                });
            })
            ->editColumn('nim', function ($row) {
                return $row->nim ?? '-';
            })
            ->editColumn('prodi_nama', function ($row) {
                return $row->prodi_nama ?? '-';
            })
            ->editColumn('nomor_antrian', function ($row) {
                return $row->nomor_antrian ?? '<span class="text-muted">Belum Cetak</span>';
            })
            ->addColumn('status_badge', function ($row) {
                if (!$row->nomor_antrian) {
                    return '<span class="badge badge-secondary">Belum Cetak</span>';
                }
                if ($row->status == 'selesai') {
                    return '<span class="badge badge-success">Selesai</span>';
                }
                return '<span class="badge badge-warning">Menunggu</span>';
            })
            ->editColumn('waktu_scan', function ($row) {
                if ($row->waktu_scan) {
                    return date('d/m/Y H:i', strtotime($row->waktu_scan));
                }
                return '-';
            })
            ->addColumn('action', function ($row) {
                if (!$row->nomor_antrian) {
                    return '<span class="text-muted">-</span>';
                }
                if ($row->status == 'selesai') {
                    return '<span class="badge badge-success"><i class="fas fa-check"></i> Sudah</span>';
                }
                return '<button type="button" class="btn btn-sm btn-success" onclick="konfirmasiFromTable(' . $row->id . ')">
                    <i class="fas fa-check"></i> Konfirmasi
                </button>';
            })
            ->rawColumns(['nomor_antrian', 'status_badge', 'action'])
            ->toJson();
    }

    public function konfirmasi(Request $request)
    {
        try {
            $request->validate([
                'peserta_id' => 'required',
                'nama' => 'required'
            ]);

            // Check if peserta exists
            $peserta = Peserta::find($request->peserta_id);
            if (!$peserta) {
                return [
                    'status' => false,
                    'message' => 'Peserta tidak ditemukan'
                ];
            }

            // Check if already scanned
            $antrian = AntrianAtribut::where('peserta_id', $request->peserta_id)->first();
            
            if (!$antrian) {
                return [
                    'status' => false,
                    'message' => 'Nomor antrian tidak ditemukan untuk peserta ini'
                ];
            }

            if ($antrian->status == 'selesai') {
                $waktu = $antrian->waktu_scan ? $antrian->waktu_scan->format('d-m-Y H:i') : '-';
                return [
                    'status' => false,
                    'message' => 'Antrian sudah dikonfirmasi sebelumnya pada ' . $waktu
                ];
            }

            // Update status
            $antrian->status = 'selesai';
            $antrian->waktu_scan = now();
            $antrian->save();

            $nama = strtoupper($request->nama);
            $nomorAntrian = $antrian->nomor_antrian;
            
            return [
                'status' => true,
                'message' => "Konfirmasi antrian atribut<br><b>$nomorAntrian</b><br>untuk<br><b>$nama</b> berhasil"
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'error' => $th->getMessage(),
                'message' => 'Gagal mengkonfirmasi antrian atribut'
            ];
        }
    }

    public function getData(Request $request)
    {
        try {
            $search = $request->search;
            
            // Search by peserta_id or nomor_antrian
            $antrian = AntrianAtribut::where('peserta_id', $search)
                ->orWhere('nomor_antrian', $search)
                ->first();

            if (!$antrian) {
                // Try searching by peserta id directly
                $peserta = Peserta::find($search);
                if ($peserta) {
                    $antrian = $peserta->antrianAtribut;
                }
            }

            if (!$antrian) {
                return [
                    'status' => false,
                    'message' => 'Data antrian tidak ditemukan'
                ];
            }

            $peserta = $antrian->peserta;
            
            return [
                'status' => true,
                'data' => [
                    'id' => $peserta->id,
                    'nama' => $peserta->nama,
                    'nim' => $peserta->nim,
                    'prodi' => $peserta->getProdi,
                    'nomor_antrian' => $antrian->nomor_antrian,
                    'status_antrian' => $antrian->status,
                    'waktu_scan' => $antrian->waktu_scan ? $antrian->waktu_scan->format('d-m-Y H:i') : null,
                    'user' => $peserta->user,
                ]
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'message' => 'Gagal mengambil data: ' . $th->getMessage()
            ];
        }
    }

    public function autocomplete(Request $request)
    {
        $term = $request->term;
        
        // Search female students only
        $data = Peserta::join('users', 'users.id', '=', 'peserta.user_id')
            ->leftJoin('antrian_atribut', 'antrian_atribut.peserta_id', '=', 'peserta.id')
            ->where('users.jenis_kelamin', 'Perempuan')
            ->where(function ($query) use ($term) {
                $query->where('peserta.nama', 'LIKE', "%$term%")
                    ->orWhere('peserta.nim', 'LIKE', "%$term%")
                    ->orWhere('antrian_atribut.nomor_antrian', 'LIKE', "%$term%");
            })
            ->select('peserta.id', 'peserta.nama', 'peserta.nim', 'antrian_atribut.nomor_antrian')
            ->limit(10)
            ->get();

        $result = [];
        foreach ($data as $row) {
            $label = $row->nim ? "{$row->nim} - {$row->nama}" : $row->nama;
            if ($row->nomor_antrian) {
                $label .= " ({$row->nomor_antrian})";
            }
            $result[] = [
                'value' => $row->id,
                'label' => $label
            ];
        }

        return response()->json($result);
    }
}

