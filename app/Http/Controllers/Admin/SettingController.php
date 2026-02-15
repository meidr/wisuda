<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Helper;
use App\Http\Services\Message;
use App\Models\Api;
use App\Models\Peserta;
use App\Models\Setting;
use App\Models\Tahun;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Milon\Barcode\Facades\DNS2DFacade;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::get()->pluck('value', 'slug');
        $fonnte = Api::where('type', 'notif_wa_fonnte')->first();
        $zenziva = Api::where('type', 'notif_wa_zenziva')->first();
        $satuconnect = Api::where('type', 'notif_wa_satuconnect')->first();

        $tahun = Tahun::all();
        $tipe = Helper::getEnumValues('peserta', 'tipe');

        return view('admin.setting.index', compact('setting', 'fonnte', 'zenziva', 'satuconnect', 'tahun', 'tipe'));
    }

    public function save(Request $request)
    {
        try {
            DB::beginTransaction();
            $dataValidated = $request->validate([
                'otp' => 'nullable',
                'isi_pesan_wa' => 'nullable',
                'vendor_notifikasi' => 'nullable',
                'userkey_zenziva' => 'nullable',
                'passkey_zenziva' => 'nullable',
                'passkey_fonnte' => 'nullable',
            ]);

            $setting = $request->only('vendor_notifikasi', 'isi_pesan_wa');
            foreach ($setting as $slug => $value) {
                Setting::where('slug', $slug)
                    ->update([
                        'value' => $value
                    ]);
            }

            Api::where('type', 'notif_wa_fonnte')
                ->update([
                    'token' => $request->passkey_fonnte
                ]);

            Api::where('type', 'notif_wa_zenziva')
                ->update([
                    'userkey' => $request->userkey_zenziva,
                    'token' => $request->passkey_zenziva
                ]);


            DB::commit();
            return [
                "status" => true,
                "message" => 200,
                "data" => 'Berhasil update setting whatsapp',
                "req" => $request->all()
            ];
        } catch (\Throwable $th) {
            //throw $th;
            return [
                "status" => false,
                "message" => 500,
                "data" => $th->getMessage(),
            ];
        }
    }

    public function tes(Request $request)
    {
        try {
            //code...
            $request->validate([
                'nomor_hp' => 'required'
            ]);

            $send = Message::send([
                'nomor_hp' => $request->nomor_hp,
                'peserta_id' => null,
                'password' => 'prodidalwa',
            ]);

            if (!$send) {
                abort(500, 'Gagal kirim pesan');
            }

            return [
                "status" => true,
                "message" => 200,
                "data" => 'Berhasil',
                "req" => $request->all()
            ];
        } catch (\Throwable $th) {
            //throw $th;
            return [
                "status" => true,
                "message" => 500,
                "data" => $th->getMessage(),
                "req" => $request->all()
            ];
        }
    }

    public function generateQr(Request $request)
    {
        $log = [];
        try {
            $request->validate([
                'tahun_id' => 'required',
                'dari' => 'required',
                'kelipatan' => 'required',
                'sampai' => 'required',
                'jenis_kelamin' => 'required',
                'tipe' => 'required',
            ]);

            $dari = $request->dari - 1;

            $tanggal = Carbon::now()->format('d-m-Y H:i:s');

            $lokasiSave = public_path('/img/qr/');
            if (!file_exists($lokasiSave)) {
                mkdir($lokasiSave, 0755, true);
            }

            $peserta = Peserta::join('users', 'users.id', '=', 'peserta.user_id')
                ->where('peserta.tahun_id', $request->tahun_id)
                ->where('peserta.tipe', $request->tipe)
                ->when($request->jenis_kelamin != '*', function ($query) use ($request) {
                    $query->where('users.jenis_kelamin', $request->jenis_kelamin);
                })
                ->limit($request->kelipatan)
                ->offset($dari)
                ->select('peserta.*', 'users.jenis_kelamin')
                ->get();

            $generatedFiles = [];
            $qrPolos = "/img/qr_polos.png";
            foreach ($peserta as $key => $value) {
                $img = Image::make(asset($qrPolos));
                $img->text($value->nim, 120, 55, function ($font) {
                    $font->file(public_path("/font/FranklinGothic.ttf"));
                    $font->size(12);
                    $font->color('#000000');
                });
                $nama = Str::limit($value->nama, 30);
                $img->text(strtoupper($nama), 120, 75, function ($font) {
                    $font->file(public_path("/font/FranklinGothic.ttf"));
                    $font->size(12);
                    $font->color('#000000');
                });
                $img->text(strtoupper(@$value->prodi->alias), 120, 95, function ($font) {
                    $font->file(public_path("/font/FranklinGothic.ttf"));
                    $font->size(12);
                    $font->color('#000000');
                });
                $img->insert(DNS2DFacade::getBarcodePNG((string) $value->id, 'QRCODE', 4.6, 4.6), 'bottom-left', 14, 21);

                $jenisKelamin = $value->jenis_kelamin === '*' ? 'semua' : $value->jenis_kelamin;
                $name = $jenisKelamin . '-' . $value->id . '-' . $value->nim . '-' . strtoupper($value->nama) . '.jpg';
                $path = $lokasiSave . $name;
                $img->save($path);

                $generatedFiles[] = [
                    'path' => $path,
                    'name' => $name
                ];
                $log[] = 'Success generated QR ' . $value->nama . ' ' . $value->nim . ' ' . @$value->prodi->nama;
            }

            // $directoryZip = public_path('img/qr-compress/');
            // $dari = $request->dari + 1;
            // $sampai = intval($request->dari + 1) + intval($request->kelipatan) - 1;
            // $zipPath = $directoryZip . "QR $dari - $sampai.zip";
            // if (!file_exists($directoryZip)) {
            //     mkdir($directoryZip, 0755, true);
            // }
            // $zip = Helper::compressToZip($generatedFiles, $zipPath);

            // if ($zip) {
            //     File::deleteDirectory($lokasiSave);
            //     return response()->download($zipPath)->deleteFileAfterSend(true);
            // }
            return [
                'status' => true,
                'message' => 200,
                'req' => $request->all(),
                'log' => $log,
                'tanggal' => $tanggal,
                'data' => 'Berhasil Generate QR'
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'message' => 500,
                'log' => $log,
                'tanggal' => $tanggal,
                'data' => $th->getMessage(),
                'req' => $request->all(),
            ];
        }
    }

    public function getPeserta(Request $request)
    {
        try {
            $request->validate([
                'tahun_id' => 'required',
                'jenis_kelamin' => 'required',
                'tipe' => 'required',
            ]);

            $peserta = Peserta::join('users', 'users.id', '=', 'peserta.user_id')
                ->where('peserta.tahun_id', $request->tahun_id)
                ->where('peserta.tipe', $request->tipe)
                ->when($request->jenis_kelamin != '*', function ($query) use ($request) {
                    $query->where('users.jenis_kelamin', $request->jenis_kelamin);
                })->count();

            return [
                'status' => true,
                'message' => 200,
                'req' => $request->all(),
                'data' => $peserta
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'message' => 500,
                'data' => $th->getMessage(),
                'req' => $request->all(),
            ];
        }
    }
}
