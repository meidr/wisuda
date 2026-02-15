<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Prodi;
use App\Models\Tahun;
use App\Models\AsalPmb;
use App\Models\Peserta;
use App\Models\Pembayaran;
use App\Exports\ExcelExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Mfahmialif\Hijri\HijriDate;
use App\Http\Services\Elearning;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;


class PembayaranController extends Controller
{
    public function index()
    {
        $prodiS1 = Prodi::where('jenjang', 'S1')->get();
        $prodiPasca = Prodi::where('jenjang', '!=', 'S1')->orderBy('jenjang', 'asc')->get();
        $tahun = Tahun::all();
        return view(
            'admin.pembayaran.index',
            compact(
                'prodiS1',
                'prodiPasca',
                'tahun',
            )
        );
    }

    public function data(Request $request)
    {
        $search = request('search.value');
        $data = Pembayaran::join('peserta', 'peserta.id', '=', 'pembayaran.peserta_id')
            ->join('prodi', 'prodi.id', '=', 'peserta.prodi_id')
            ->join('status', 'status.id', '=', 'peserta.status_id')
            ->join('users', 'users.id', '=', 'peserta.user_id')
            ->join('tahun', 'tahun.id', '=', 'peserta.tahun_id')
            ->select(
                'pembayaran.*',
                'peserta.nim as peserta_nim',
                'peserta.nama as peserta_nama',
                'prodi.nama as prodi_nama',
                'users.jenis_kelamin as users_jk',
                'status.nama as status_nama',
                'status.warna as status_warna',
                'prodi.id as prodi_id',
                'tahun.nama as tahun_nama'
            );
        return DataTables::of($data)
            ->filter(function ($query) use ($search, $request) {
                $query->when($request->nim != "*" && $request->nim != "", function ($query) use ($request) {
                    $query->where('peserta.nim', $request->nim);
                });
                $query->when($request->tahun != "*" && $request->tahun != "", function ($query) use ($request) {
                    $query->where('tahun.id', $request->tahun);
                });
                $query->when($request->prodi_id != "*" && $request->prodi_id != "", function ($query) use ($request) {
                    if ($request->prodi_id == 'sarjana') {
                        $query->where('prodi.jenjang', 'S1');
                    } else if ($request->prodi_id == 'pascasarjana') {
                        $query->whereIn('prodi.jenjang', ['S2', 'S3']);
                    } else {
                        $query->where('peserta.prodi_id', $request->prodi_id);
                    }
                });
                $query->when($request->tanggal != "*" && $request->tanggal != "", function ($query) use ($request) {
                    list($tanggalMulai, $tanggalSelesai) = explode(" - ", $request->range_tanggal);
                    $tanggalMulai = explode("/", $tanggalMulai);
                    $tanggalMulai = Carbon::parse($tanggalMulai[2] . '-' . $tanggalMulai[1] . '-' . $tanggalMulai[0]);
                    $tanggalSelesai = explode("/", $tanggalSelesai);
                    $tanggalSelesai = Carbon::parse($tanggalSelesai[2] . '-' . $tanggalSelesai[1] . '-' . $tanggalSelesai[0]);
                    $query->whereBetween('pembayaran.created_at', [$tanggalMulai->startOfDay(), $tanggalSelesai->endOfDay()]);
                });
                $query->when($request->jenis_kelamin != "*" && $request->jenis_kelamin != "", function ($query) use ($request) {
                    $query->where('users.jenis_kelamin', $request->jenis_kelamin);
                });
                $query->where(function ($query) use ($search) {
                    $query->orWhere('pembayaran.created_at', 'LIKE', "%$search%");
                    $query->orWhere('tahun.nama', 'LIKE', "%$search%");
                    $query->orWhere('peserta.nim', 'LIKE', "%$search%");
                    $query->orWhere('peserta.nama', 'LIKE', "%$search%");
                    $query->orWhere('prodi.nama', 'LIKE', "%$search%");
                    $query->orWhere('users.jenis_kelamin', 'LIKE', "%$search%");
                    $query->orWhere('status.nama', 'LIKE', "%$search%");
                });
            })
            ->editColumn('jumlah', function ($row) {
                return \Helper::doubleToIdr($row->jumlah);
            })
            ->editColumn('created_at', function ($row) use ($request) {
                return date("d M Y, H:i:s", strtotime($row->created_at));
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button"
                        id="dropdownMenuButton" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        Klik
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a href="' . route('admin.pembayaran.kwitansi', ['pembayaran' => $row->id]) . '" target="_blank" type="button" class="dropdown-item"
                        >Kwitansi</a>
                        <div class="dropdown-divider"></div>
                        <button type="button" class="dropdown-item"
                            data-toggle="modal" data-target="#modal_edit_pembayaran"
                            data-id="' . $row->id . '"
                            data-jumlah="' . (integer) $row->jumlah . '"
                            data-peserta_nim="' . $row->peserta_nim . '"
                            data-jenis_pembayaran="' . $row->jenis_pembayaran . '"
                            data-keterangan="' . $row->keterangan . '"
                        >Edit</button>
                        <form action="" onsubmit="deleteData(event)" method="POST">
                        ' . method_field('delete') . csrf_field() . '
                            <input type="hidden" name="id" value="' . $row->id . '">
                            <input type="hidden" name="nim" value="' . $row->peserta_nim . '">
                            <input type="hidden" name="jumlah" value="' . \Helper::doubleToIdr($row->jumlah) . '">
                            <button type="submit" class="dropdown-item text-danger">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    function dataInfo(Request $request)
    {
        try {
            $pembayaranHariIniBanin = self::joinInfo();
            $pembayaranHariIniBanin = self::whereInfo($pembayaranHariIniBanin, $request, true, 'Laki-Laki');
            $pembayaranHariIniBanin = (int) $pembayaranHariIniBanin
                ->select(\DB::raw('SUM(pembayaran.jumlah) as value'))
                ->first()->value;

            $pembayaranHariIniBanat = self::joinInfo();
            $pembayaranHariIniBanat = self::whereInfo($pembayaranHariIniBanat, $request, true, 'Perempuan');
            $pembayaranHariIniBanat = (int) $pembayaranHariIniBanat
                ->select(\DB::raw('SUM(pembayaran.jumlah) as value'))
                ->first()->value;

            $pembayaranHariIni = $pembayaranHariIniBanat + $pembayaranHariIniBanin;

            $pembayaran = self::joinInfo();
            $pembayaran = self::whereInfo($pembayaran, $request, false, $request->jenis_kelamin);
            $pembayaran = $pembayaran
                ->select('pembayaran.peserta_id', 'peserta.nama')
                ->addSelect(\DB::raw('SUM(pembayaran.jumlah) as dibayar'))
                ->addSelect(\DB::raw("(SELECT jumlah FROM biaya WHERE biaya.jenjang = prodi.jenjang AND biaya.tahun_id = peserta.tahun_id LIMIT 1) as biaya"))
                ->groupBy('pembayaran.peserta_id', 'peserta.nama', 'biaya')
                ->get();

            $harusDiterima = 0;
            $belumDiterima = 0;
            $telahDiterima = 0;
            foreach ($pembayaran as $key => $value) {
                $sisa = $value->biaya - $value->dibayar;
                $harusDiterima += $value->biaya;
                $telahDiterima += $value->dibayar;
                $belumDiterima += $sisa >= 0 ? $sisa : 0;
            }
            return [
                'status' => true,
                'data' => compact(
                    'pembayaranHariIni',
                    'pembayaranHariIniBanin',
                    'pembayaranHariIniBanat',
                    'harusDiterima',
                    'belumDiterima',
                    'telahDiterima'
                ),
            ];
        } catch (\Throwable $th) {
            //throw $th;
            return [
                'status' => false,
                'error' => $th->getMessage()
            ];
        }
    }


    public static function joinInfo()
    {
        return Pembayaran::join('peserta', 'peserta.id', '=', 'pembayaran.peserta_id')
            ->join('prodi', 'prodi.id', '=', 'peserta.prodi_id')
            ->join('users', 'users.id', '=', 'peserta.user_id')
            ->join('tahun', 'tahun.id', '=', 'peserta.tahun_id');
    }
    public static function whereInfo($pembayaran, $request, $now, $jk)
    {
        return $pembayaran
            ->when($now, function ($q) {
                $q->whereBetween('pembayaran.created_at', [
                    \Carbon::now()->startOfDay(),
                    \Carbon::now()->endOfDay()
                ]);
            })
            // ->when($now == false, function ($q) use ($request) {
            //     $q->when($request->tanggal != "*" && $request->tanggal != "", function ($query) use ($request) {
            //         list($tanggalMulai, $tanggalSelesai) = explode(" - ", $request->range_tanggal);
            //         $tanggalMulai = explode("/", $tanggalMulai);
            //         $tanggalMulai = Carbon::parse($tanggalMulai[2] . '-' . $tanggalMulai[1] . '-' . $tanggalMulai[0]);
            //         $tanggalSelesai = explode("/", $tanggalSelesai);
            //         $tanggalSelesai = Carbon::parse($tanggalSelesai[2] . '-' . $tanggalSelesai[1] . '-' . $tanggalSelesai[0]);
            //         $query->whereBetween('pembayaran.created_at', [$tanggalMulai->startOfDay(), $tanggalSelesai->endOfDay()]);
            //     });
            // })
            ->when($jk != '*', function ($q) use ($jk) {
                $q->where('users.jenis_kelamin', $jk);
            })
            ->when($request->nim != "*" && $request->nim != "", function ($query) use ($request) {
                $query->where('peserta.nim', $request->nim);
            })
            ->when($request->tahun != "*" && $request->tahun != "", function ($query) use ($request) {
                $query->where('tahun.id', $request->tahun);
            })
            ->when($request->prodi_id != "*" && $request->prodi_id != "", function ($query) use ($request) {
                if ($request->prodi_id == 'sarjana') {
                    $query->where('prodi.jenjang', 'S1');
                } else if ($request->prodi_id == 'pascasarjana') {
                    $query->whereIn('prodi.jenjang', ['S2', 'S3']);
                } else {
                    $query->where('peserta.prodi_id', $request->prodi_id);
                }
            });
    }

    public function add(Request $request)
    {
        try {
            \DB::beginTransaction();
            $request->validate([
                'jumlah' => 'required',
                'peserta_id' => 'required',
                'jenis_pembayaran' => 'nullable',
                'keterangan' => 'nullable',
            ]);

            $peserta = Peserta::findOrFail($request->peserta_id);

            Pembayaran::create([
                'peserta_id' => $peserta->id,
                'jumlah' => $request->jumlah,
                'jenis_pembayaran' => $request->jenis_pembayaran,
                'keterangan' => $request->keterangan,
            ]);

            \DB::commit();
            return response()->json([
                'status' => true,
                'message' => 200,
                'data' => "Berhasil menambahkan pembayaran",
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            \DB::rollback();
            return response()->json([
                'status' => false,
                'message' => 500,
                'data' => "Gagal menambahkan pembayaran",
            ]);
        }
    }

    public function edit(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required',
                'jumlah' => 'required',
                'jenis_pembayaran' => 'nullable',
                'keterangan' => 'nullable',
            ]);

            Pembayaran::where('id', $request->id)
                ->update([
                    'jumlah' => $request->jumlah,
                    'jenis_pembayaran' => $request->jenis_pembayaran,
                    'keterangan' => $request->keterangan,
                ]);

            $data = [
                'message' => 200,
                'data' => 'Berhasil mengedit pembayaran',
                'req' => $request->all(),
            ];
        } catch (\Throwable $th) {
            $data = [
                'message' => 500,
                'data' => $th->getMessage(),
                'req' => $request->all(),
            ];
        }

        return $data;
    }

    public function delete(Request $request)
    {
        try {
            $dataValidated = $request->validate([
                'id' => 'required',
            ]);

            $delete = Pembayaran::where('id', $dataValidated['id'])->first();
            $delete->destroy($dataValidated['id']);

            $data = [
                "message" => 200,
                "data" => "Berhasil menghapus data pembayaran",
            ];
            return $data;
        } catch (\Throwable $th) {
            $data = [
                "message" => 500,
                "data" => $th->getMessage(),
            ];
            return $data;
        }
    }

    public function kwitansi(Pembayaran $pembayaran)
    {
        $now = \Carbon::now();
        $hijri = HijriDate::gregorianToHijri($now->year, $now->month, $now->day);
        $kui = (object) [
            'no' => $pembayaran->id,
            'dari' => @$pembayaran->peserta->nama,
            'username' => @$pembayaran->peserta->user->username,
            'nama' => $pembayaran->peserta->nama,
            'jumlah' => number_format($pembayaran->jumlah, 0, ',', '.'),
            'tgl' => \Carbon::parse($pembayaran->created_at)->format('d-m-Y, H:i:s'),
            'panitia' => \Auth::user(),
            'no_unik' => @$pembayaran->peserta->user->no_unik,
            'jenis_pembayaran' => @$pembayaran->jenis_pembayaran,
            'keterangan' => @$pembayaran->keterangan,
            'hijri' => $hijri
        ];
        $pdf = Pdf::loadView(
            'admin.pembayaran.kwitansi',
            compact('kui')
        );

        return $pdf->setPaper('a4', 'landscape')
            ->stream('Cetak Formulir.pdf');
    }

    public function registrasi(Request $request)
    {
        \DB::beginTransaction();
        try {
            $request->validate([
                'nim' => 'required',
                'nama' => 'required',
                'nama_ayah' => 'nullable',
                'judul' => 'nullable',
                'tanggal_sidang' => 'nullable',
                'tahun_id' => 'required',
                'jenis_kelamin' => 'required',
                'prodi_id' => 'required',
                'jenis_pembayaran' => 'required',
                'jumlah' => 'required',
                'ukuran_baju' => 'nullable',
                'keterangan' => 'nullable',
            ]);

            $dataJk = explode('_', $request->jenis_kelamin);
            $jenisKelamin = $dataJk[0];
            $kuota = $dataJk[1];

            $peserta = Peserta::where('nim', $request->nim)->first();
            $user = @$peserta->user;
            if (!$user) {
                if ($kuota <= 0) {
                    return abort(500, 'Kuota sudah habis 1');
                }
                $generateRandomString = \Helper::generateRandomString();
                $password = \Hash::make($generateRandomString);

                $user = new User();
                $user->password = $password;
                $user->no_unik = $generateRandomString;
                $user->role_id = 2;
            }
            $user->username = $request->nim;
            $user->nama = $request->nama;
            $user->jenis_kelamin = $jenisKelamin;
            $user->user_id = \Auth::user()->id;
            $user->save();

            if (!$peserta) {
                if ($kuota <= 0) {
                    return abort(500, 'Kuota sudah habis 2s');
                }
                $peserta = new Peserta();
            }
            $peserta->nim = $request->nim;
            $peserta->nama = $request->nama;
            $peserta->nama_ayah = $request->nama_ayah;
            $peserta->judul = $request->judul;
            $peserta->tanggal_sidang = $request->tanggal_sidang;
            $peserta->prodi_id = $request->prodi_id;
            $peserta->status_id = 1;
            $peserta->user_id = $user->id;
            $peserta->tahun_id = $request->tahun_id;
            $peserta->status_id = 1;
            $peserta->tanggal_daftar = now();
            $peserta->ukuran_baju = $request->ukuran_baju;
            $peserta->petugas_id = \Auth::user()->id;
            $peserta->save();

            $pembayaran = new Pembayaran();
            $pembayaran->peserta_id = $peserta->id;
            $pembayaran->jumlah = $request->jumlah;
            $pembayaran->jenis_pembayaran = $request->jenis_pembayaran;
            $pembayaran->keterangan = $request->keterangan;
            $pembayaran->save();

            \DB::commit();
            return [
                'status' => true,
                'message' => 200,
                'data' => "Berhasil menambahkan data pembayaran"
            ];
        } catch (\Throwable $th) {
            //throw $th;
            \DB::rollback();
            return [
                'status' => false,
                'message' => 500,
                'data' => $th->getMessage(),
                'req' => $request->all()
            ];
        }
    }

    public function export(Request $request)
    {
        $data = Pembayaran::join('peserta', 'peserta.id', '=', 'pembayaran.peserta_id')
            ->join('prodi', 'prodi.id', '=', 'peserta.prodi_id')
            ->join('status', 'status.id', '=', 'peserta.status_id')
            ->join('users', 'users.id', '=', 'peserta.user_id')
            ->join('tahun', 'tahun.id', '=', 'peserta.tahun_id')
            ->select(
                'tahun.nama as tahun',
                'pembayaran.created_at as tanggal',
                'peserta.nim as nim',
                'peserta.nama as nama',
                'users.jenis_kelamin as jenis_kelamin',
                'prodi.nama as prodi',
                'pembayaran.jumlah as jumlah',
                'pembayaran.jenis_pembayaran as jenis_pembayaran',
                'pembayaran.keterangan as keterangan',
            )->when($request->nim != "*" && $request->nim != "", function ($query) use ($request) {
                $query->where('peserta.nim', $request->nim);
            })->when($request->tahun != "*" && $request->tahun != "", function ($query) use ($request) {
                $query->where('tahun.id', $request->tahun);
            })->when($request->prodi_id != "*" && $request->prodi_id != "", function ($query) use ($request) {
                if ($request->prodi_id == 'sarjana') {
                    $query->where('prodi.jenjang', 'S1');
                } else if ($request->prodi_id == 'pascasarjana') {
                    $query->whereIn('prodi.jenjang', ['S2', 'S3']);
                } else {
                    $query->where('peserta.prodi_id', $request->prodi_id);
                }
            })->when($request->tanggal != "*" && $request->tanggal != "", function ($query) use ($request) {
                list($tanggalMulai, $tanggalSelesai) = explode(" - ", $request->range_tanggal);
                $tanggalMulai = explode("/", $tanggalMulai);
                $tanggalMulai = Carbon::parse($tanggalMulai[2] . '-' . $tanggalMulai[1] . '-' . $tanggalMulai[0]);
                $tanggalSelesai = explode("/", $tanggalSelesai);
                $tanggalSelesai = Carbon::parse($tanggalSelesai[2] . '-' . $tanggalSelesai[1] . '-' . $tanggalSelesai[0]);
                $query->whereBetween('pembayaran.created_at', [$tanggalMulai->startOfDay(), $tanggalSelesai->endOfDay()]);
            })->when($request->jenis_kelamin != "*" && $request->jenis_kelamin != "", function ($query) use ($request) {
                $query->where('users.jenis_kelamin', $request->jenis_kelamin);
            })->get();

        $except = [
            'id',
            'user_id',
            'tahun_id',
            'prodi_id',
            'status_id',
        ];

        $data = $data->makeHidden($except);
        $tahun = Tahun::find($request->tahun);
        $tahun = $tahun ? '-' . "$tahun->kode" : "";

        $prodi = "";
        if ($request->prodi_id == 'sarjana') {
            $prodi = "-sarjana";
        } else if ($request->prodi_id == 'pascasarjana') {
            $prodi = "-pascasarjana";
        } else {
            $prodi = Prodi::find($request->prodi_id);
            $prodi = $prodi ? '-' . \Helper::changeName($prodi->alias) : "";
        }

        $jenis_kelamin = $request->jenis_kelamin != "*" ? '-' . substr($request->jenis_kelamin, 0, 1) : "";

        if ($request->tanggal != '*') {
            list($tanggalMulai, $tanggalSelesai) = explode(" - ", $request->range_tanggal);
            $tanggal = '-' . \Helper::changeName($tanggalMulai) . '-' . \Helper::changeName($tanggalSelesai);
        } else {
            $tanggal = '';
        }

        $nama = $tanggal . $tahun . $prodi . $jenis_kelamin;

        return Excel::download(new ExcelExport($data), "Rekap Pembayaran$nama.xlsx");
    }
}
