<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Summernote;
use App\Models\Tahun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;


class TahunController extends Controller
{
    public function index()
    {
        return view('admin.tahun.index');
    }

    public function data(Request $request)
    {
        $search = request('search.value');
        $data = Tahun::select('*');
        return DataTables::of($data)
            ->filter(function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('nama', 'LIKE', "%$search%");
                    $query->orWhere('kode', 'LIKE', "%$search%");
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
                            data-kode="' . $row->kode . '"
                            data-status="' . $row->status . '"
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
            \DB::beginTransaction();
            $request->validate([
                'nama' => 'required',
                'kode' => 'nullable',
                'status' => 'nullable',
            ]);

            $nama = strtolower($request->nama);
            $kode = $request->kode;
            $status = $request->status;

            $check = Tahun::where([
                ['kode', $kode],
            ])->first();

            if ($check) {
                $data = [
                    "message" => 500,
                    "data" => 'Data sudah ada',
                    "req" => $request->all(),
                ];
                return $data;
            }

            if ($status == "Y") {
                Tahun::where('status', 'Y')->update([
                    'status' => 'N',
                ]);
            }

            $new = new Tahun();
            $new->nama = $nama;
            $new->kode = $kode;
            $new->status = $status;
            $new->save();

            $data = [
                "message" => 200,
                "data" => 'Berhasil menambahkan Tahun',
                "req" => $request->all(),
            ];
            \DB::commit();
        } catch (\Throwable $th) {
            \DB::rollBack();
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
            \DB::beginTransaction();
            $request->validate([
                'id' => 'required',
                'nama' => 'required',
                'kode' => 'nullable',
                'status' => 'nullable',
            ]);

            $id = $request->id;
            $nama = strtolower($request->nama);
            $kode = $request->kode;
            $status = $request->status;

            $editData = Tahun::where([
                ['kode', $kode],
                ['id', '!=', $id]
            ])->first();

            if ($editData) {
                $data = [
                    "message" => 500,
                    "data" => 'Data sudah ada',
                    "req" => $request->all(),
                ];
                return $data;
            }

            if ($status == "Y") {
                Tahun::where('status', 'Y')->update([
                    'status' => 'N',
                ]);
            }

            $editData = Tahun::findOrFail($id);
            $editData->nama = $nama;
            $editData->kode = $kode;
            $editData->status = $status;
            $editData->save();

            $data = [
                'message' => 200,
                'data' => 'Berhasil mengedit Tahun',
                'req' => $request->all(),
            ];
            \DB::commit();
        } catch (\Throwable $th) {
            \DB::rollback();
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

            $delete = Tahun::where('id', $dataValidated['id'])->first();

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