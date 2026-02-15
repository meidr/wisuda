<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Summernote;
use App\Models\ListDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;


class ListDokumenController extends Controller
{
    public function index()
    {
        return view('admin.list-dokumen.index');
    }

    public function data(Request $request)
    {
        $search = request('search.value');
        $data = ListDokumen::select('*');
        return DataTables::of($data)
            ->filter(function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('tipe', 'LIKE', "%$search%");
                    $query->orWhere('status', 'LIKE', "%$search%");
                    $query->orWhere('upload', 'LIKE', "%$search%");
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
                            data-tipe="' . $row->tipe . '"
                            data-status="' . $row->status . '"
                            data-upload="' . $row->upload . '"
                        >Edit</button>
                        <form action="" onsubmit="deleteData(event)" method="POST">
                        ' . method_field('delete') . csrf_field() . '
                            <input type="hidden" name="id" value="' . $row->id . '">
                            <input type="hidden" name="tipe" value="' . $row->tipe . '">
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
                'tipe' => 'required',
                'status' => 'nullable',
                'upload' => 'nullable',
            ]);

            $tipe = strtoupper($request->tipe);
            $status = $request->status;
            $upload = $request->upload;

            $listDokumen = ListDokumen::where([
                ['tipe', $tipe],
            ])->first();

            if ($listDokumen) {
                $data = [
                    "message" => 500,
                    "data" => 'Data sudah ada',
                    "req" => $request->all(),
                ];
                return $data;
            }

            $new = new ListDokumen();
            $new->tipe = $tipe;
            $new->status = $status;
            $new->upload = $upload;
            $new->save();

            $data = [
                "message" => 200,
                "data" => 'Berhasil menambahkan List Dokumen',
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
                'tipe' => 'required',
                'status' => 'nullable',
                'upload' => 'nullable',
            ]);

            $id = $request->id;
            $tipe = strtoupper($request->tipe);
            $status = $request->status;
            $upload = $request->upload;

            $listDokumen = ListDokumen::where([
                ['tipe', $tipe],
                ['id', '!=', $id]
            ])->first();

            if ($listDokumen) {
                $data = [
                    "message" => 500,
                    "data" => 'Data sudah ada',
                    "req" => $request->all(),
                ];
                return $data;
            }

            $edit = ListDokumen::findOrFail($id);
            $edit->tipe = $tipe;
            $edit->status = $status;
            $edit->upload = $upload;
            $edit->save();

            $data = [
                'message' => 200,
                'data' => 'Berhasil mengedit list dokumen',
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

            $delete = ListDokumen::where('id', $dataValidated['id'])->first();
            $delete->destroy($dataValidated['id']);
            $data = [
                "message" => 200,
                "data" => "Berhasil menghapus data",
            ];
            return $data;
        } catch (\Throwable $th) {
            $data = [
                "message" => 500,
                "data" => 'Gagal menghapus data, masih ada data yang terkait di peserta',
            ];
            return $data;
        }
    }
}