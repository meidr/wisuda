<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Summernote;
use App\Models\Prodi;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;


class PenggunaController extends Controller
{
    public function index()
    {
        $role = Role::all();
        return view('admin.pengguna.index', compact('role'));
    }

    public function data(Request $request)
    {
        $search = request('search.value');
        $data = User::join('role', 'role.id', 'users.role_id')
            ->select('users.*', 'role.nama as role_nama');
        return DataTables::of($data)
            ->filter(function ($query) use ($search) {
                $query->when(\Auth::user()->jenis_kelamin != '*', function ($query) {
                    $query->where('users.jenis_kelamin', \Auth::user()->jenis_kelamin);
                });
                $query->where(function ($query) use ($search) {
                    $query->orWhere('users.username', 'LIKE', "%$search%");
                    $query->orWhere('users.nama', 'LIKE', "%$search%");
                    $query->orWhere('users.email', 'LIKE', "%$search%");
                    $query->orWhere('role.nama', 'LIKE', "%$search%");
                    $query->orWhere('users.jenis_kelamin', 'LIKE', "%$search%");
                    $query->orWhere('users.hp', 'LIKE', "%$search%");
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
                            data-username="' . $row->username . '"
                            data-nama="' . $row->nama . '"
                            data-email="' . $row->email . '"
                            data-role_id="' . $row->role_id . '"
                            data-jenis_kelamin="' . $row->jenis_kelamin . '"
                            data-hp="' . $row->hp . '"
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
            ->rawColumns(['action', 'isi'])
            ->toJson();
    }

    public function add(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required',
                'nama' => 'required',
                'password' => 'required',
                'email' => 'required',
                'role_id' => 'required',
                'jenis_kelamin' => 'required',
                'hp' => 'nullable',
            ]);

            $user = User::where('username', $request->username)->first();
            if ($user) {
                $data = [
                    "message" => 500,
                    "data" => 'Pengguna dengan username ' . $request->username . ' sudah ada',
                    "req" => $request->all(),
                ];

                return $data;
            }

            $new = new User;
            $new->username = $request->username;
            $new->nama = $request->nama;
            $new->email = $request->email;
            $new->password = \Hash::make($request->password);
            $new->role_id = $request->role_id;
            $new->jenis_kelamin = $request->jenis_kelamin;
            $new->no_unik = uniqid();
            $new->hp = $request->hp;
            $new->save();

            $data = [
                "message" => 200,
                "data" => 'Berhasil menambahkan pengguna',
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
            $request->validate([
                'id' => 'required',
                'username' => 'required',
                'nama' => 'required',
                'password' => 'nullable',
                'konfirmasi_password' => 'nullable',
                'email' => 'required',
                'role_id' => 'required',
                'jenis_kelamin' => 'required',
                'hp' => 'nullable',
            ]);

            $user = User::findOrFail($request->id);

            if ($request->has('password')) {
                if ($request->password != $request->konfirmasi_password) {
                    $data = [
                        'message' => 500,
                        'data' => 'Password dan Konfirmasi Password tidak sama',
                        'req' => $request->all(),
                    ];
                    return $data;
                }
                $user->password = \Hash::make($request->password);
            }

            $user->username = $request->username;
            $user->nama = $request->nama;
            $user->email = $request->email;
            $user->jenis_kelamin = $request->jenis_kelamin;
            $user->role_id = $request->role_id;
            $user->user_id = \Auth::user()->id;
            $user->hp = $request->hp;
            $user->save();

            $data = [
                'message' => 200,
                'data' => 'Berhasil mengedit pengguna',
                'req' => $request->all(),
            ];
        } catch (ModelNotFoundException $th) {
            $data = [
                'message' => 500,
                'data' => "Data pengguna tidak ada",
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

            $delete = User::find($request->id);
            $delete->delete();
            $data = [
                "message" => 200,
                "data" => "Berhasil menghapus pengguna",
            ];
            return $data;
        } catch (\Throwable $th) {
            $data = [
                "message" => 500,
                "data" => "Tidak bisa dihapus, masih ada data pesertanya",
            ];
            return $data;
        }
    }
}
