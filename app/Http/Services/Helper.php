<?php
namespace App\Http\Services;

use App\Models\Jadwal;
use App\Models\Tahun;
use ZipArchive;

class Helper
{
    public static function idrToDouble($idrString)
    {
        $idrString = preg_replace("/[^0-9]/", "", $idrString);

        // Convert the string to a double
        $idrDecimal = (double) $idrString;
        return $idrDecimal;
    }
    public static function doubleToIdr($idrString)
    {
        return 'Rp ' . number_format($idrString, 0, ',', '.');

    }

    public static function terbilang($nilai)
    {
        if ($nilai < 0) {
            $hasil = "minus " . trim(Helper::penyebut($nilai));
        } else {
            $hasil = trim(Helper::penyebut($nilai));
        }
        return $hasil;
    }

    public static function penyebut($nilai)
    {
        $nilai = abs($nilai);
        $huruf = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
        $temp  = "";

        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = Helper::penyebut($nilai - 10) . " Belas";
        } else if ($nilai < 100) {
            $temp = Helper::penyebut($nilai / 10) . " Puluh" . Helper::penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " Seratus" . Helper::penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = Helper::penyebut($nilai / 100) . " Ratus" . Helper::penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " Seribu" . Helper::penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = Helper::penyebut($nilai / 1000) . " Ribu" . Helper::penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = Helper::penyebut($nilai / 1000000) . " Juta" . Helper::penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = Helper::penyebut($nilai / 1000000000) . " Milyar" . Helper::penyebut(fmod($nilai, 1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = Helper::penyebut($nilai / 1000000000000) . " Triliun" . Helper::penyebut(fmod($nilai, 1000000000000));
        }
        return $temp;
    }

    public static function getUppercaseChars($inputString)
    {
        $uppercaseChars = '';

        // Loop through each character in the string
        for ($i = 0; $i < strlen($inputString); $i++) {
            $char = $inputString[$i];

            // Check if the character is uppercase
            if (ctype_upper($char)) {
                // Append the uppercase character to the result string
                $uppercaseChars .= $char;
            }
        }

        return $uppercaseChars;
    }

    public static function changeFormatSymbol($string)
    {
        $charactersToReplace = ['\\', '/', ':', '*', '?', '<', '>', '|'];
        $replacement         = '-';

        $newString = \Str::replace($charactersToReplace, $replacement, $string);
        return $newString;
    }

    public static function formatNumber($angka)
    {
        return number_format($angka, 0, ",", ".");
    }

    /**
     * Summary of getEnumValues
     * @param mixed $table
     * @param mixed $column
     * @param mixed $deleteColumn [array]
     * @return array
     */
    public static function getEnumValues($table, $column, $deleteColumn = false)
    {
        $type = \DB::select(\DB::raw("SHOW COLUMNS FROM $table WHERE Field = '$column'"))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enum = [];

        foreach (explode(',', $matches[1]) as $value) {
            $v = trim($value, "'");
            array_push($enum, $v);
        }

        if ($deleteColumn != false) {
            foreach ($deleteColumn as $column) {
                $key = array_search($column, $enum);
                if ($key !== false) {
                    unset($enum[$key]);
                }

            }
            $enum = array_values($enum);
        }
        return $enum;
    }

    public static function getColorCode($color)
    {
        switch ($color) {
            case 'primary':
                $code = '#3B71CA';
                break;
            case 'success':
                $code = '#14A44D';
                break;
            case 'warning':
                $code = '#E4A11B';
                break;
            case 'danger':
                $code = '#DC4C64';
                break;
            case 'secondary':
                $code = '#9FA6B2';
                break;
            case 'dark':
                $code = '#332D2D';
                break;
            default:
                $code = '#54B4D3';
        }
        return $code;
    }

    public static function changeName($string)
    {
        $charactersToReplace = ['\\', '/', ':', '*', '?', '<', '>', '|', '-', '_'];
        $replacement         = ' ';

        $newString = \Str::replace($charactersToReplace, $replacement, $string);
        return \Str::upper($newString);
    }

    public static function checkRegister()
    {
        $tahun = Tahun::aktif();

        $jadwal = Jadwal::where('tahun_id', $tahun->id)->first();

        $mulai    = \Carbon::parse($jadwal->mulai)->startOfDay();
        $berakhir = \Carbon::parse($jadwal->berakhir)->endOfDay();
        $sekarang = \Carbon::now();

        $dibuka = true;
        if ($sekarang->lt($mulai) || $sekarang->gt($berakhir)) {
            $dibuka = false;
        }

        return $dibuka;
    }

    public static function generateRandomString($length = 8)
    {
        return rand(12345, 54321);
        // $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // $charactersLength = strlen($characters);
        // $randomString = '';
        // for ($i = 0; $i < $length; $i++) {
        //     $randomString .= $characters[rand(0, $charactersLength - 1)];
        // }
        // return $randomString;
    }

    public static function compressToZip(array $files, $zipFilePath)
    {
        $zip = new ZipArchive();

        if ($zip->open($zipFilePath, ZipArchive::CREATE) === true) {
            foreach ($files as $file) {
                $zip->addFile($file['path'], $file['name']);
            }
            $zip->close();
            return true;
        }

        return false;
    }

    public static function generateUsername(int $length = 10)
    {
        $chars          = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charsLength    = strlen($chars);
        $randomUsername = '';

        for ($i = 0; $i < $length; $i++) {
            $randomUsername .= $chars[random_int(0, $charsLength - 1)];
        }

        return $randomUsername;
    }

     public static function getExtension($mimeType)
    {
        $extension = '';
        switch ($mimeType) {
            // Format Dokumen Microsoft Office
            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                $extension = '.docx'; // Word Document (modern)
                break;
            case 'application/msword':
                $extension = '.doc'; // Word Document (legacy)
                break;
            case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
                $extension = '.xlsx'; // Excel Spreadsheet
                break;
            case 'application/vnd.ms-excel':
                $extension = '.xls'; // Excel Spreadsheet (legacy)
                break;
            case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
                $extension = '.pptx'; // PowerPoint Presentation
                break;
            case 'application/vnd.ms-powerpoint':
                $extension = '.ppt'; // PowerPoint Presentation (legacy)
                break;

            // Format PDF
            case 'application/pdf':
                $extension = '.pdf'; // PDF Document
                break;

            // Format Dokumen Teks
            case 'text/plain':
                $extension = '.txt'; // Plain Text
                break;
            case 'application/rtf':
                $extension = '.rtf'; // Rich Text Format
                break;
            case 'application/vnd.oasis.opendocument.text':
                $extension = '.odt'; // OpenDocument Text (LibreOffice)
                break;
            case 'application/vnd.oasis.opendocument.spreadsheet':
                $extension = '.ods'; // OpenDocument Spreadsheet (LibreOffice)
                break;
            case 'application/vnd.oasis.opendocument.presentation':
                $extension = '.odp'; // OpenDocument Presentation (LibreOffice)
                break;

            // Format HTML dan Markup
            case 'text/html':
                $extension = '.html'; // HTML Document
                break;
            case 'application/xhtml+xml':
                $extension = '.xhtml'; // XHTML Document
                break;

            // Format XML
            case 'application/xml':
                $extension = '.xml'; // XML Document
                break;

            // Format Gambar
            case 'image/jpeg':
                $extension = '.jpg'; // JPEG Image
                break;
            case 'image/png':
                $extension = '.png'; // PNG Image
                break;
            case 'image/gif':
                $extension = '.gif'; // GIF Image
                break;
            case 'image/bmp':
                $extension = '.bmp'; // BMP Image
                break;
            case 'image/webp':
                $extension = '.webp'; // WebP Image
                break;
            case 'image/tiff':
                $extension = '.tiff'; // TIFF Image
                break;
            case 'image/svg+xml':
                $extension = '.svg'; // SVG Image
                break;

            // Tambahan format dokumen lainnya
            case 'application/epub+zip':
                $extension = '.epub'; // ePub Document
                break;
            case 'application/x-mobipocket-ebook':
                $extension = '.mobi'; // Mobi Document (eBook)
                break;

            // Format default jika tidak ditemukan
            default:
                $extension = ''; // Jika tipe MIME tidak dikenali
                break;
        }
        return $extension;
    }
}
