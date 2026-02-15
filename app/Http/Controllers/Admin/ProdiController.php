<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Summernote;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;


class ProdiController extends Controller
{
    public function index()
    {
        return view('admin.prodi.index');
    }

    public function data(Request $request)
    {
        $search = request('search.value');
        $data = Prodi::select('*');
        return DataTables::of($data)
            ->filter(function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('nama', 'LIKE', "%$search%");
                    $query->orWhere('keterangan', 'LIKE', "%$search%");
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
                            data-nama="' . $row->nama . '"
                            data-warna="' . $row->warna . '"
                            data-keterangan="' . $row->keterangan . '"
                        >Edit</button>
                        <form action="" onsubmit="deleteData(event)" method="POST">
                        ' . method_field('delete') . csrf_field() . '
                            <input type="hidden" name="id" value="' . $row->id . '">
                            <input type="hidden" name="nama" value="' . $row->nama . '">
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
                'nama' => 'required',
                'warna' => 'nullable',
                'keterangan' => 'nullable',
            ]);

            $nama = strtolower($request->nama);
            $warna = $request->warna;
            $keterangan = $request->keterangan;

            $edit = Prodi::where([
                ['nama', $nama],
            ])->first();

            if ($edit) {
                $data = [
                    "message" => 500,
                    "data" => 'Data sudah ada',
                    "req" => $request->all(),
                ];
                return $data;
            }

            $new = new Prodi();
            $new->nama = $nama;
            $new->warna = $warna;
            $new->keterangan = $keterangan;
            $new->save();

            $data = [
                "message" => 200,
                "data" => 'Berhasil menambahkan data prodi',
                "req" => $request->all(),
            ];
        } catch (\Throwable $th) {
            $data = [
                "message" => 500,
                "data" => $th->getMessage(),
                "req" => $request->all(),
            ];
        }
        return $data;
    }

    public function edit(Request $request)
    {
        try {
            $dataValidated = $request->validate([
                'id' => 'required',
                'nama' => 'required',
                'warna' => 'nullable',
                'keterangan' => 'nullable',
            ]);

            $id = $request->id;
            $nama = strtolower($request->nama);
            $warna = $request->warna;
            $keterangan = $request->keterangan;

            $edit = Prodi::where([
                ['nama', $nama],
                ['id', '!=', $id]
            ])->first();

            if ($edit) {
                $data = [
                    "message" => 500,
                    "data" => 'Data sudah ada',
                    "req" => $request->all(),
                ];
                return $data;
            }

            $edit = Prodi::findOrFail($id);
            $edit->nama = $nama;
            $edit->warna = $warna;
            $edit->keterangan = $keterangan;
            $edit->save();

            $data = [
                'message' => 200,
                'data' => 'Berhasil mengedit data prodi',
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

            $delete = Prodi::where('id', $dataValidated['id'])->first();

            $delete->destroy($dataValidated['id']);
            $data = [
                "message" => 200,
                "data" => "Berhasil menghapus data",
            ];
            return $data;
        } catch (\Throwable $th) {
            $data = [
                "message" => 500,
                "data" => 'Gagal menghapus data, seluruh data peserta dengan tipe yang sama harus dihapus dulu',
            ];
            return $data;
        }
    }
}