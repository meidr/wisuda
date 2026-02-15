<?php

namespace App\Http\Controllers\Operasi;

use App\Http\Controllers\Controller;
use App\Models\Kalender;
use Illuminate\Http\Request;

class KalenderController extends Controller
{
    public function show()
    {
        return Kalender::all();
    }

    public function tambah(Request $request)
    {
        try {
            $dataValidated = $request->validate([
                'title' => 'required',
                'start' => 'required',
                'end' => 'required',
                'warna' => 'required'
            ]);

            Kalender::create([
                'user_id' => auth()->user()->id,
                'title' => $dataValidated['title'],
                'start' => $dataValidated['start'],
                'end' => $dataValidated['end'],
                'warna' => $dataValidated['warna']
            ]);

            $kalender = Kalender::latest()->first();
            $data = [
                "message" => 200,
                "data" => "Berhasil menambahkan data " . $dataValidated['title'],
                "kalender" => $kalender
            ];
        } catch (\Throwable $th) {
            $data = [
                "message" => 500,
                "data" => $th->getMessage()
            ];
        }
        return $data;
    }

    public function edit(Request $request, $id)
    {
        try {
            $dataValidated = $request->validate([
                'title' => 'required',
                'start' => 'required',
                'end' => 'required',
                'warna' => 'required'
            ]);

            $kalender = Kalender::findOrFail($id);
            $kalender
                ->update([
                    'title' => $dataValidated['title'],
                    'start' => $dataValidated['start'],
                    'end' => $dataValidated['end'],
                    'warna' => $dataValidated['warna']
                ]);

            $data = [
                "message" => 200,
                "data" => "Berhasil mengupdate data " . $dataValidated['title'],
                "kalender" => $kalender
            ];
        } catch (\Throwable $th) {
            $data = [
                "message" => 500,
                "data" => $th->getMessage()
            ];
        }
        return $data;
    }

    public function hapus($id)
    {
        try {
            Kalender::destroy($id);
            $data = [
                "message" => 200,
                "data" => "Berhasil menghapus data"
            ];
        } catch (\Throwable $th) {
            $data = [
                "message" => 500,
                "data" => $th->getMessage()
            ];
        }
        return $data;
    }
}
