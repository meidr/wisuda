<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Summernote;
use App\Models\Kuota;
use App\Models\Tahun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;


class KuotaController extends Controller
{
    public function index()
    {
        $tahun = Tahun::orderBy('id', 'desc')->get();
        return view('admin.kuota.index', compact('tahun'));
    }

    public function data(Request $request)
    {
        $search = request('search.value');
        $data = Kuota::join('tahun', 'tahun.id', '=', 'kuota.tahun_id')
            ->select('kuota.*', 'tahun.nama as tahun_nama');
        return DataTables::of($data)
            ->filter(function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('kuota.jenis', 'LIKE', "%$search%");
                    $query->orWhere('kuota.kuota', 'LIKE', "%$search%");
                    $query->orWhere('tahun.nama', 'LIKE', "%$search%");
                });
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
                        <button type="button" class="dropdown-item"
                            data-toggle="modal" data-target="#modal_edit"
                            data-id="' . $row->id . '"
                            data-tahun_id="' . $row->tahun_id . '"
                            data-jenis="' . $row->jenis . '"
                            data-jenjang="' . $row->jenjang . '"
                            data-kuota="' . $row->kuota . '"
                        >Edit</button>
                        <form action="" onsubmit="deleteData(event)" method="POST">
                        ' . method_field('delete') . csrf_field() . '
                            <input type="hidden" name="id" value="' . $row->id . '">
                            <input type="hidden" name="nama" value="' . $row->jenis . '">
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

    public function add(Request $request)
    {
        try {
            $request->validate([
                'tahun_id' => 'required',
                'jenis' => 'required',
                'jenjang' => 'required',
                'kuota' => 'required',
            ]);

            $jenis = strtolower($request->jenis);
            $jenjang = $request->jenjang;
            $kuota = $request->kuota;

            $cek = Kuota::where([
                ['tahun_id', $request->tahun_id],
                ['jenis', $request->jenis],
                ['jenjang', $request->jenjang],
            ])->first();

            if ($cek) {
                $data = [
                    "message" => 500,
                    "data" => 'Data sudah ada, bisa diedit',
                    "req" => $request->all(),
                ];
                return $data;
            }

            $new = new Kuota();
            $new->tahun_id = $request->tahun_id;
            $new->jenis = $jenis;
            $new->jenjang = $jenjang;
            $new->kuota = $kuota;
            $new->save();

            $data = [
                "message" => 200,
                "data" => 'Berhasil menambahkan Kuota',
                "req" => $request->all(),
            ];
        } catch (\Throwable $th) {
            $data = [
                "message" => 500,
                "data" => $th->getMessage(),
                "req" => $request->all(),
                "kuota" => $kuota
            ];
        }
        return $data;
    }

    public function edit(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required',
                'tahun_id' => 'required',
                'jenis' => 'required',
                'jenjang' => 'required',
                'kuota' => 'nullable',
            ]);

            $id = $request->id;
            $tahunId = $request->tahun_id;
            $jenis = strtolower($request->jenis);
            $jenjang = $request->jenjang;
            $kuota = $request->kuota;

            $cek = Kuota::where([
                ['tahun_id', $tahunId],
                ['jenis', $jenis],
                ['jenjang', $jenjang],
                ['id', '!=', $id]
            ])->first();

            if ($cek) {
                $data = [
                    "message" => 500,
                    "data" => 'Data sudah ada, bisa diedit',
                    "req" => $request->all(),
                ];
                return $data;
            }

            $edit = Kuota::findOrFail($id);
            $edit->tahun_id = $tahunId;
            $edit->jenis = $jenis;
            $edit->jenjang = $jenjang;
            $edit->kuota = $kuota;
            $edit->save();

            $data = [
                'message' => 200,
                'data' => 'Berhasil mengedit Kuota',
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

            $kuota = Kuota::where('id', $dataValidated['id'])->first();

            $kuota->destroy($dataValidated['id']);
            $data = [
                "message" => 200,
                "data" => "Berhasil menghapus data",
            ];
            return $data;
        } catch (\Throwable $th) {
            $data = [
                "message" => 500,
                "data" => 'Gagal menghapus data',
            ];
            return $data;
        }
    }
}