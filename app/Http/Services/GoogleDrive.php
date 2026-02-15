<?php

namespace App\Http\Services;

use App\Models\PesertaDokumen;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class GoogleDrive
{
    public static function getData($filename, $dir = '/')
    {
        $recursive = false; // Get subdirectories also?
        $contents = collect(Storage::disk('google')->listContents($dir, $recursive));
        $file = $contents
            ->where('type', '=', 'file')
            ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
            ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
            ->first(); // there can be duplicate file names!
        if ($file) {
            if ($file['dirname'] != "") {
                $file['path'] = str_replace($file['dirname'] . '/', '', $file['path']);
            }
        }
        return $file;
    }

    public static function getAllData($dir = '/')
    {
        $recursive = false; // Get subdirectories also?
        $contents = collect(Storage::disk('google')->listContents($dir, $recursive));

        return $contents;
    }

    public static function delete($filename, $dir = '/')
    {
        try {
            $recursive = false; // Get subdirectories also?
            $contents = collect(Storage::disk('google')->listContents($dir, $recursive));
            $file = $contents
                ->where('type', '=', 'file')
                ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
                ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
                ->first(); // there can be duplicate file names!
            if ($file) {
                Storage::disk('google')->delete($file['path']);
            }

            $response = [
                "status" => true,
                "message" => "success delete",
                "name" => $file['name'],
            ];
            return $response;
        } catch (\Throwable $th) {
            $response = [
                "status" => false,
                "message" => "failed delete",
                "name" => null,
            ];
            return $response;
        }
    }

    public static function download($filename, $dir = '/', $customName = false)
    {
        $recursive = false; // Get subdirectories also?
        $contents = collect(Storage::disk('google')->listContents($dir, $recursive));
        $file = $contents
            ->where('type', '=', 'file')
            ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
            ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
            ->first(); // there can be duplicate file names!
        $rawData = Storage::disk('google')->get($file['path']);
        $filename = $customName ? $customName . '.' . pathinfo($filename, PATHINFO_EXTENSION) : $filename;
        return response($rawData, 200)
            ->header('ContentType', $file['mimetype'])
            ->header('Content-Disposition', "attachment; filename=$filename");
    }

    public static function downloadFiles(array $files, $destinationDir, $extension = false, $peserta = false)
    {
        $downloadedFiles = [];

        foreach ($files as $file) {
            $fileContent = Storage::disk('google')->get($file['path']);
            if ($extension != false) {
                $mimeType = Storage::disk('google')->mimeType($file['path']);
                $extension = Helper::getExtension($mimeType);
                $fileName = $file['name'] . $extension;

                PesertaDokumen::where('id', $file['id'])->update([
                    'extension' => $extension
                ]);
            } else {
                $fileName = $file['name'];
            }
            $destinationPath = $destinationDir . '/' . $fileName;

            // Save the path locally
            file_put_contents($destinationPath, $fileContent);
            $downloadedFiles[] = ['path' => $destinationPath, 'name' => $fileName];
        }

        return $downloadedFiles;
    }

    public static function downloadFile($file, $destinationDir)
    {
        try {
            $fileContent = Storage::disk('google')->get($file['path']);
            $destinationPath = $destinationDir . '/' . $file['name'];

            // Save the path locally
            file_put_contents($destinationPath, $fileContent);
            $downloadedFiles = ['path' => $destinationPath, 'name' => $file['name']];

            return [
                'status' => true,
                'message' => $downloadedFiles
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'message' => 'failed download ' . $file['name'] . '-' . $th->getMessage()
            ];
        }
    }

    public static function directDownload($filename, $dir = '/', $customName = false)
    {
        if ($customName != false) {
            return route('operasi.dokumen.download') . "?filename=$filename&dir=$dir&custom_name=$customName";
        }
        return route('operasi.dokumen.download') . "?filename=$filename&dir=$dir";
    }

    public static function link($path)
    {
        $link = null;
        if ($path != null) {
            $link = "https://drive.google.com/file/d/" . $path . "/view";
        }
        return $link;
    }

    public static function showImage($path)
    {
        $link = null;
        if ($path != null) {
            $link = "https://drive.google.com/thumbnail?id=$path&sz=w1000";
        }
        return $link;
    }

    public static function upload($file, $kategori = 'UNCATEGORIZED', $dir = '/')
    {
        try {
            // $extensi = $file->extension();
            // $namaDokumen = 'File' . date('YmdHis') . uniqid() . '.' . $extensi;
            $namaOriginal = $file->getClientOriginalName();
            $namaDokumen = $kategori . '-' . date('YmdHis') . '-' . uniqid() . '-' . $namaOriginal;
            // $content = file_get_contents($file->getRealPath());
            $content = File::get($file->getRealPath());
            $namaDokumen = Helper::changeFormatSymbol($namaDokumen);
            Storage::disk('google')->put($dir . $namaDokumen, $content);

            $response = [
                "status" => true,
                "message" => "success upload",
                "name" => $namaDokumen,
            ];
            return $response;
        } catch (\Throwable $th) {
            $response = [
                "status" => false,
                "message" => $th->getMessage(),
                "name" => null,
            ];
            return $response;
        }
    }

    public function edit($newfile, $oldfile, $dir = '/')
    {
        try {
            $file = $newfile;
            $extensi = $file->extension();
            $namaDokumen = 'File' . date('YmdHis') . uniqid() . '.' . $extensi;
            $content = File::get($file->getRealPath());
            $upload = Storage::disk('google')->put($namaDokumen, $content);
            if ($upload) {
                if ($oldfile != null) {
                    $recursive = false; // Get subdirectories also?
                    $contents = collect(Storage::disk('google')->listContents($dir, $recursive));
                    $file = $contents
                        ->where('type', '=', 'file')
                        ->where('filename', '=', pathinfo($oldfile, PATHINFO_FILENAME))
                        ->where('extension', '=', pathinfo($oldfile, PATHINFO_EXTENSION))
                        ->first(); // there can be duplicate file names!
                    Storage::disk('google')->delete($file['path']);
                }
            }
            $response = [
                "status" => true,
                "message" => "success edit",
            ];
            return $response;
        } catch (\Throwable $th) {
            $response = [
                "status" => false,
                "message" => "failed edit",
            ];
            return $response;
        }
    }

}
