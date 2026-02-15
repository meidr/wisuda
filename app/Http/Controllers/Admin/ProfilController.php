<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function index()
    {
        $foto = auth()->user()->foto;
        return view('admin/profil/index', compact('foto'));
    }

    public function edit()
    {
        return view('admin/profil/edit');
    }

    public function editProses(Request $request)
    {
        try {
            $dataValidated = $request->validate([
                'nama' => 'nullable',
                'email' => 'required',
                'password' => 'nullable',
                'konfirmasi_password' => 'nullable',
            ]);

            if (isset($dataValidated['password'])) {
                // Update dengan Password
                if ($dataValidated['password'] == $dataValidated['konfirmasi_password']) {
                    $user = User::find(auth()->user()->id);
                    $user->update([
                        'nama' => $dataValidated['nama'],
                        'email' => $dataValidated['email'],
                        'password' => Hash::make($dataValidated['password']),
                        'user_id' => \Auth::user()->id,
                    ]);
                    return redirect()->route('admin.profil')->with('message', 'Berhasil Mengupdate Profile');
                } else {
                    return redirect()->route('admin.profil')->with('failed', 'Gagal Mengupdate Profile Error Password');
                }
            } else {
                // Update tanpa Password
                $user = User::find(auth()->user()->id);
                $user->update([
                    'nama' => $dataValidated['nama'],
                    'email' => $dataValidated['email'],
                    'user_id' => \Auth::user()->id,
                ]);
                return redirect()->route('admin.profil')->with('message', 'Berhasil Mengupdate Profile');
            }
        } catch (\Throwable $th) {
            return redirect()->route('admin.profil')->with('failed', 'Gagal Mengupdate Profile Error Password' . $th->getMessage());
        }
    }

    public function upload()
    {
        $foto = auth()->user()->foto;
        return view('admin/profil/upload', compact('foto'));
    }

    public function crop(Request $request)
    {
        try {
            //code...
            $request->validate([
                'file' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Adjust mime types and max size as needed
            ]);
            $lokasi = '/foto/';
            $foto = $request->file('foto');
            $extensi = $request->file('foto')->extension();
            $new_image_name = 'Foto' . date('YmdHis') . uniqid() . '.' . $extensi;
    
            $upload = $foto->move(public_path($lokasi), $new_image_name);
            if ($upload) {
                $foto = auth()->user()->foto;
                if ($foto != null) {
                    File::delete(public_path('/foto/' . $foto));
                }
                // update new foto
                User::where('id', auth()->user()->id)->update(['foto' => $new_image_name]);
    
                return response()->json([
                    'status' => 1, 'msg' => 'Berhasil upload foto',
                    'name' => $new_image_name,
                ]);
            } else {
                return response()->json(['status' => 0, 'msg' => 'Gagal Upload']);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'msg' => 'Gagal Upload']);
        }
    }
}
