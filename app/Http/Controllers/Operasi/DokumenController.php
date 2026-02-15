<?php

namespace App\Http\Controllers\Operasi;

use App\Http\Controllers\Controller;
use App\Http\Services\BulkData;
use App\Http\Services\GoogleDrive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    private $dir = BulkData::dirGdrive['dokumen'];

    public function download(Request $request)
    {
        try {
            $dataValidated = $request->validate([
                'filename' => 'required',
                'dir' => 'required',
                'custom_name' => 'nullable'
            ]);
            
            $filename = $dataValidated['filename'];
            $dir = $dataValidated['dir'];
            $customName = isset($dataValidated['custom_name']) ? $dataValidated['custom_name'] : null;

            return GoogleDrive::download($filename, $dir, $customName);
        } catch (\Throwable $th) {
            // return redirect()->route('home');
            return $th->getMessage();
        }
    }

    public function downloadFile(Request $request)
    {
        try {
            $dataValidated = $request->validate([
                'filename' => 'required',
                'custom_name' => 'nullable',
            ]);

            $fileUrl = config('app.url') . 'dokumen/' . $request->filename;

            $filename = $request->custom_name != 'null' ? $request->custom_name . '.' . pathinfo($request->filename, PATHINFO_EXTENSION) : $request->filename;

            // Set the headers for file download
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            // Read the file and output it to the browser
            readfile($fileUrl);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function imageDelete(Request $request)
    {
        $namaFile = $request->get('dokumen');
        $delete = GoogleDrive::delete($namaFile, $this->dir);
        return response()->json([
            'name' => $namaFile,
        ]);
    }
}
