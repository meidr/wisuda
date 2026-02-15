<?php

namespace App\Imports;

use App\Models\Prodi;
use App\Models\Urutan;
use App\Models\Peserta;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UrutanImport implements ToCollection, WithHeadingRow
{
    private $newData = 0;
    private $total = 0;
    private $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $request = $this->request;
        Urutan::where('tahun_id', $request->tahun_id)
            ->where('jenis_kelamin', $request->jenis_kelamin)
            ->delete();
        foreach ($collection as $row) {
            if ($row['jenis']) {
                $prodiId = null;
                $pesertaId = null;

                if ($row['jenis'] == 'peserta') {
                    $peserta = Peserta::join('users', 'peserta.user_id', '=', 'users.id')->where([
                        ['users.jenis_kelamin', $request->jenis_kelamin],
                        ['peserta.nim', $row['nim']]
                    ])->select('peserta.*')->first();
                    if (!$peserta) {
                        return abort(500, 'NIM ' . $row['nim'] . ' tidak ditemukan');
                    }

                    $urutan = Urutan::where('tahun_id', $request->tahun_id)
                        ->where('peserta_id', $peserta->id)
                        ->where('prodi_id', $peserta->prodi_id)
                        ->where('jenis', $row['jenis'])
                        ->where('jenis_kelamin', $row['jenis_kelamin'])
                        ->first();
                    $prodiId = $peserta->prodi_id;
                    $pesertaId = $peserta->id;

                } else {
                    $prodi = Prodi::where('alias', $row['prodi'])->first();
                    if (!$prodi) {
                        return abort(500, 'Prodi ' . $row['prodi'] . ' tidak ditemukan');
                    }
                    $urutan = Urutan::where('tahun_id', $request->tahun_id)
                        ->where('prodi_id', $prodi->id)
                        ->where('jenis', $row['jenis'])
                        ->where('jenis_kelamin', $row['jenis_kelamin'])
                        ->first();
                    $prodiId = $prodi->id;
                }

                if (!$urutan) {
                    $urutan = new Urutan;
                }
                $urutan->urutan = $row['urutan'];
                $urutan->tahun_id = $request->tahun_id;
                $urutan->peserta_id = $pesertaId;
                $urutan->prodi_id = $prodiId;
                $urutan->jenis = $row['jenis'];
                $urutan->jenis_kelamin = $row['jenis_kelamin'];
                $urutan->save();
            }
        }
    }

    public function getResponse()
    {
        return "$this->newData data baru dari $this->total total data";
    }
}
