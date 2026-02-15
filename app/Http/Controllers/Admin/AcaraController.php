<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tahun;
use App\Models\Urutan;
use App\Models\Peserta;
use Illuminate\Http\Request;
use App\Http\Services\Helper;
use App\Imports\UrutanImport;
use App\Models\PesertaDokumen;
use App\Http\Services\BulkData;
use App\Http\Services\GoogleDrive;
use App\Http\Controllers\Controller;

class AcaraController extends Controller
{
    public function index()
    {
        $tahun = Tahun::all();
        $tipe = Helper::getEnumValues('peserta', 'tipe');
        return view('admin.acara.index', compact('tahun', 'tipe'));
    }

    public function downloadFoto(Request $request)
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

            $dir = BulkData::dirGdrive['dokumen'];

            $request->dari = $request->dari - 1;

            $tanggal = \Carbon::now()->format('d-m-Y H:i:s');

            $peserta = Peserta::join('users', 'users.id', '=', 'peserta.user_id')
                ->where('peserta.tahun_id', $request->tahun_id)
                ->where('peserta.tipe', $request->tipe)
                ->when($request->jenis_kelamin != '*', function ($query) use ($request) {
                    $query->where('users.jenis_kelamin', $request->jenis_kelamin);
                })
                ->limit($request->kelipatan)
                ->offset($request->dari)
                ->select('peserta.*', 'users.jenis_kelamin')
                ->get();

            $files = [];
            foreach ($peserta as $key => $value) {

                $foto = PesertaDokumen::where('peserta_id', $value->id)->where('list_dokumen_id', 1)->first();
                if (!@$foto->path) {
                    $log[] = 'Failed download photo from ' . $value->id . ' ' . $value->nama . ' ' . $value->nim . ' ' . $value->prodi->nama;
                    continue;
                }
                $path = substr($dir, 1) . $foto->path;
                $files[] = [
                    'path' => $path,
                    'name' => $value->id,
                    'id' => $foto->id,
                ];
                $log[] = 'Success download photo from ' . $value->id . ' ' . $value->nama . ' ' . $value->nim . ' ' . $value->prodi->nama;
            }

            $directoryDownload = public_path('img/download-foto/');
            if (!file_exists($directoryDownload)) {
                mkdir($directoryDownload, 0755, true);
            }

            \DB::beginTransaction();
            GoogleDrive::downloadFiles($files, $directoryDownload, true, true);
            \DB::commit();
            return [
                'status' => true,
                'message' => 200,
                'req' => $request->all(),
                'log' => $log,
                'tanggal' => $tanggal,
                'data' => 'Berhasil download foto'
            ];
        } catch (\Throwable $th) {
            \DB::rollback();
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

    public function slideshow(Request $request)
    {
        $peserta = Urutan::leftJoin('peserta', 'peserta.id', '=', 'urutan.peserta_id')
            ->leftJoin('users', 'users.id', '=', 'peserta.user_id')
            ->leftJoin('peserta_dokumen', 'peserta_dokumen.peserta_id', '=', 'peserta.id')
            ->leftJoin('prodi', 'prodi.id', '=', 'peserta.prodi_id')
            ->leftJoin('prodi as urutan_prodi', 'urutan_prodi.id', '=', 'urutan.prodi_id')
            ->where('urutan.tahun_id', $request->tahun_id)
            ->when($request->jenis_kelamin, function ($query) use ($request) {
                $query->where('urutan.jenis_kelamin', $request->jenis_kelamin);
            })
            ->select(
                'peserta.*',
                'users.jenis_kelamin',
                'peserta_dokumen.file',
                'prodi.nama as prodi_nama',
                'prodi.alias as prodi_alias',
                'peserta_dokumen.id as peserta_dokumen_id',
                'peserta_dokumen.extension as peserta_dokumen_extension',
                'urutan.urutan',
                'urutan_prodi.nama as urutan_prodi_nama',
                'urutan_prodi.alias as urutan_prodi_alias',
                'urutan.peserta_id as urutan_peserta_id',
            )
            ->orderBy('urutan.urutan', 'asc')
            // ->limit(5)
            ->get();
        return view('admin.acara.slideshow', compact('peserta'));
    }

    public function storeUrutan(Request $request)
    {
        try {
            \DB::beginTransaction();
            $request->validate([
                'tahun_id' => 'required',
                'jenis_kelamin' => 'required',
                'file_excel' => 'required|mimes:xls,xlsx'
            ]);

            $fileExcel = $request->file('file_excel');

            $import = new UrutanImport($request);
            \Excel::import($import, $fileExcel);

            \DB::commit();
            return [
                'status' => true,
                'message' => 200,
                'data' => 'Berhasil',
                'req' => $request->all()
            ];
        } catch (\Illuminate\Validation\ValidationException $e) {
            \DB::rollBack();
            return response()->json([
                'message' => 500,
                'data' => implode(',', $e->errors()),
                'req' => $request->all()
            ]);
        } catch (\Throwable $th) {
            \DB::rollback();
            return [
                'status' => false,
                'message' => 500,
                'data' => $th->getMessage(),
                'req' => $request->all()
            ];
        }
    }
}
