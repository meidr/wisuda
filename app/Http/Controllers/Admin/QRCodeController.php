<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kehadiran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QRCodeController extends Controller
{
    public function index()
    {
        return view('admin.qr_code.index');
    }

    public function konfirmasi(Request $request){
        try {
            $dataValidated = $request->validate([
                'jenis' => 'required',
                'peserta_id' => 'required',
                'status' => 'required',
                'nama' => 'required'
            ]);

            $check = Kehadiran::where('peserta_id', $request->peserta_id)
                ->where('jenis', $request->jenis)
                ->exists();
            if ($check) {
                return [
                    'status' => false, 
                    'message' => 'Kehadiran '.$request->jenis.' sudah di konfirmasi sebelumnya'
                ];
            }

            unset($dataValidated['nama']);
            Kehadiran::create($dataValidated);

            $jenis = strtoupper($request->jenis);
            $nama = strtoupper($request->nama);
            return [
                'status' => true, 
                'message' => "Konfirmasi kehadiran<br><b>$jenis</b> dari<br><b>$nama</b> berhasil"
            ];
        } catch (\Throwable $th) {
            $jenis = strtoupper($request->jenis);
            $nama = strtoupper($request->nama);
            return [
                'status' => false, 
                'error' => $th->getMessage(),
                'message' => "Konfirmasi kehadiran<br><b>$jenis</b> dari<br><b>$nama</b> gagal"
            ];
        }
    }
}