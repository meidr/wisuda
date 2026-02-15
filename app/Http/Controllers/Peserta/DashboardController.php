<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Services\GoogleDrive;
use App\Models\User;
use App\Models\Peserta;
use App\Models\ListDokumen;
use Illuminate\Http\Request;
use App\Models\PesertaDokumen;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Services\PesertaService;

class DashboardController extends Controller
{
    public function index()
    {
        $peserta = Peserta::where('user_id', \Auth::user()->id)->first();
        $listDokumen = ListDokumen::all();

        $cek = PesertaService::cekKelengkapan($peserta);
        if (!$cek) {
            return redirect()->route("peserta.formulir.edit")->with('warning', 'Mohon lengkapi DATA DIRI dan DOKUMEN terlebih dahulu');
        }
        $foto = PesertaDokumen::where('peserta_id', @$peserta->id)->first();
        $showFoto = GoogleDrive::showImage(@$foto->path);
        return view('peserta.dashboard.index', compact('peserta', 'listDokumen', 'foto', 'showFoto'));
    }

    public function changePassword(Request $request)
    {
        try {
            $request->validate([
                'id_edit' => 'required',
                'password' => 'required'
            ]);

            $user = User::findOrFail($request->id_edit);

            $user->password = Hash::make($request->password);
            $user->no_unik = $request->password;
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 200,
                'data' => "Berhasil mengupdate password",
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            $data = [
                'status' => false,
                'message' => 500,
                'data' => "Gagal mengupdate password",
                'cel' => $user
            ];
        }
        return $data;
    }
}