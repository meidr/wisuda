<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\File;

class Summernote
{
    /**
     * @param $isi : $request->isi
     * @param $lokasi : "upload/informasi/"
     * @return mixed dom->saveHTML();
     */
    public static function generate($isi, $lokasi)
    {
        $dom = new \DomDocument();
        @$dom->loadHTML($isi, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images = $dom->getElementsByTagName('img');

        foreach ($images as $k => $img) {
            $dataImage = $img->getAttribute('src');
            if (explode(":", $dataImage)[0] == "data") {
                $fileName = $img->getAttribute('data-filename');
                list($type, $dataImage) = explode(';', $dataImage);
                list(, $dataImage) = explode(',', $dataImage);
                $dataImage = base64_decode($dataImage);
                // $extensi = explode('/', $type)[1];
                $image_name = 'Foto' . date('YmdHis') . uniqid() . $fileName;
                $path = public_path($lokasi . $image_name);

                // Save the decoded image using the move method
                file_put_contents($path, $dataImage);
                // Update the img element's src attribute
                $img->removeAttribute('src');
                $img->setAttribute('src', asset($lokasi . $image_name));
            }
        }
        return $dom->saveHTML();
    }

    /**
     * @param $edit : data edit from eluquent, MUST HAVE column isi
     * @param $isi : $request->isi
     * @param $lokasi : "upload/informasi/"
     * @return mixed dom->saveHTML();
     */
    public static function generateForEdit($editIsi, $isiRequest, $lokasi)
    {

        // isiLama dan isiBaru untuk pencarian isiDelete -> isiDelete file yang dihapus
        $isiLama = [];
        $isiBaru = [];
        $isiDelete = [];
        if ($editIsi != '' && $editIsi != null) {
            $isi = $editIsi;
            $dom = new \DomDocument();
            @$dom->loadHTML($isi, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $images = $dom->getElementsByTagName('img');

            foreach ($images as $k => $img) {
                $isiLama[] = [
                    "src" => $img->getAttribute('src'),
                    "filename" => $img->getAttribute('data-filename'),
                ];
            }
        }

        $isi = $isiRequest;
        $dom = new \DomDocument();
        @$dom->loadHTML($isi, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images = $dom->getElementsByTagName('img');

        foreach ($images as $k => $img) {
            $dataImage = $img->getAttribute('src');
            if (explode(":", $dataImage)[0] == "data") {

                $fileName = $img->getAttribute('data-filename');
                list($type, $dataImage) = explode(';', $dataImage);
                list(, $dataImage) = explode(',', $dataImage);
                $dataImage = base64_decode($dataImage);
                // $extensi = explode('/', $type)[1];
                $image_name = 'Foto' . date('YmdHis') . uniqid() . $fileName;
                $path = public_path($lokasi . $image_name);
                // Save the decoded image using the move method
                file_put_contents($path, $dataImage);

                // Update the img element's src attribute
                $img->removeAttribute('src');
                $img->setAttribute('src', asset($lokasi . $image_name));
            } else {
                // isi isiBaru
                $isiBaru[] = [
                    "src" => $img->getAttribute('src'),
                    "filename" => $img->getAttribute('data-filename'),
                ];
            }
        }

        // TIdak ada di isiBaru, maka masukkan ke isiDelete
        foreach ($isiLama as $il) {
            $checkDelete = false;
            foreach ($isiBaru as $ib) {
                if ($il['src'] == $ib['src']) {
                    $checkDelete = true;
                }
            }
            if (!$checkDelete) {
                $isiDelete[] = $il;
            }
        }

        // delete isiDelete
        if (count($isiDelete) > 0) {
            foreach ($isiDelete as $k => $img) {
                $dataImage = rawurldecode($img['src']);
                $extensi = explode('.', $img['filename']);
                $extensi = end($extensi);
                $filename = pathinfo($dataImage, PATHINFO_FILENAME);
                if ($filename != null) {
                    File::delete(public_path($lokasi . $filename . '.' . $extensi));
                }
            }
        }

        $isi = $dom->saveHTML();
        return $isi;
    }

    /**
     * @param $edit : data edit from eluquent, MUST HAVE column isi
     * @param $isi : $request->isi
     * @param $lokasi : "upload/informasi/"
     */
    public static function deleteImage($isi, $lokasi)
    {
        // delete image summernote
        $dom = new \DomDocument();
        @$dom->loadHTML($isi, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images = $dom->getElementsByTagName('img');

        foreach ($images as $k => $img) {
            $dataImage = rawurldecode($img->getAttribute('src'));
            $extensi = explode('.', $img->getAttribute('data-filename'));
            $extensi = end($extensi);
            $filename = pathinfo($dataImage, PATHINFO_FILENAME);
            if ($filename != null) {
                File::delete(public_path($lokasi . $filename . '.' . $extensi));
            }
            // $dataImage = $img->getAttribute('src');
            // $dataImage = str_replace(config('app.url'), '', $dataImage);
            // $dataImage = public_path($dataImage);
            // $dataImage = rawurldecode($dataImage);
            // if (File::exists($dataImage)) {
            //     File::delete($dataImage);
            // }
        }
    }
}