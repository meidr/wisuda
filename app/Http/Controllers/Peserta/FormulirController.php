<?php

namespace App\Http\Controllers\Peserta;

use App\Models\User;
use App\Models\Prodi;
use App\Models\Status;
use App\Models\Peserta;
use App\Models\ListDokumen;
use Illuminate\Http\Request;
use App\Models\PesertaDokumen;
use App\Http\Services\BulkData;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Services\GoogleDrive;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class FormulirController extends Controller
{
    protected $dir = BulkData::dirGdrive['dokumen'];
    public function edit()
    {
        $peserta = Peserta::where('user_id', \Auth::user()->id)->first();
        $tipeIdentitas = \Helper::getEnumValues('peserta', 'tipe_identitas');

        $prodi = Prodi::all();
        $listDokumen = ListDokumen::all();

        return view('peserta.formulir.edit', compact('peserta', 'tipeIdentitas', 'prodi', 'listDokumen'));
    }

    public function update(Request $request)
    {
        try {
            \DB::beginTransaction();
            $request->validate([
                'nama_lengkap' => 'required',
                'nama_ayah' => 'required',
                'judul' => 'required',
                'tanggal_sidang' => 'required',
                // 'nim' => 'required',
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required',
                'jenis_kelamin' => 'nullable',
                'nomor_hp' => 'required',
                'tipe_identitas' => 'required',
                'nomor_identitas' => 'required',
                'propinsi' => 'nullable',
                'kota' => 'nullable',
                'alamat' => 'required',
                'prodi_id' => 'required',
                'ukuran_baju' => 'required',
            ]);

            $peserta = Peserta::where('user_id', \Auth::user()->id)->first();
            $peserta->nama = strtoupper($request->nama_lengkap);
            // $peserta->nim = strtoupper($request->nim);
            $peserta->nama_ayah = strtoupper($request->nama_ayah);
            $peserta->judul = strtoupper($request->judul);
            $peserta->tanggal_sidang = strtoupper($request->tanggal_sidang);
            $peserta->tempat_lahir = strtoupper($request->tempat_lahir);
            $peserta->tanggal_lahir = strtoupper($request->tanggal_lahir);
            $peserta->nomor_hp = strtoupper($request->nomor_hp);
            $peserta->tipe_identitas = strtoupper($request->tipe_identitas);
            $peserta->nomor_identitas = strtoupper($request->nomor_identitas);
            $peserta->propinsi = strtoupper($request->propinsi);
            $peserta->kota = strtoupper($request->kota);
            $peserta->alamat = strtoupper($request->alamat);
            $peserta->prodi_id = strtoupper($request->prodi_id);
            $peserta->ukuran_baju = strtoupper($request->ukuran_baju);
            $peserta->save();

            $user = User::where('id', $peserta->user_id)->first();
            $user->jenis_kelamin = $request->jenis_kelamin;
            $user->save();

            \DB::commit();

            return redirect()->route('peserta.dashboard')->with('success', 'Data peserta berhasil diperbarui');

        } catch (\Throwable $th) {
            //throw $th;
            \DB::rollback();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function dokumen(Request $request)
    {
        try {
            $request->validate([
                'id_dokumen' => 'required',
                'tipe' => 'required',
                'status' => 'nullable'
            ]);

            $listDokumen = ListDokumen::findOrFail($request->id_dokumen);
            $fileValidator = Validator::make($request->only('file'), [
                'file' => "required|file|mimes:$listDokumen->upload|max:20480",
            ], [
                'file.mimes' => "File harus bertipe $listDokumen->upload",
            ]);

            if ($fileValidator->fails()) {
                throw new ValidationException($fileValidator);
            }

            $file = $request->file('file');
            $peserta = Peserta::where('user_id', \Auth::user()->id)->first();
            // abort(500, $peserta);

            $dokumen = PesertaDokumen::where([
                ['peserta_id', $peserta->id],
                ['list_dokumen_id', $request->id_dokumen]
            ])->first();

            if (!$dokumen) {
                $dokumen = new PesertaDokumen;
            } else {
                // hapus dokumen lama
                if ($request->has('file')) {
                    $getFileLama = $dokumen->file;
                    if ($getFileLama != null) {
                        GoogleDrive::delete($getFileLama, $this->dir);
                    }

                }
            }

            $dokumen->peserta_id = $peserta->id;
            $dokumen->tanggal = now();
            $dokumen->list_dokumen_id = $request->id_dokumen;
            $upload = GoogleDrive::upload($file, strtoupper($request->tipe), $this->dir);
            // ambil path
            $path = GoogleDrive::getData($upload['name'], $this->dir);
            $getPath = $path['path'];
            $dokumen->path = $getPath;
            $dokumen->file = $upload['name'];

            $dokumen->save();

            $data = [
                'message' => 200,
                'data' => 'Berhasil mengupload dokumen',
            ];

        } catch (ValidationException $e) {
            $data = [
                'message' => 500,
                'data' => $e->validator->errors()->getMessages()['file']
            ];
        } catch (\Throwable $th) {
            $data = [
                'message' => 500,
                'data' => 'Gagal mengupload dokumen, format harus jpg/jpeg/png dan ukuran file maksimal 2mb',
            ];
        }

        return $data;
    }

    public function cetak($idPeserta, $noUnik)
    {
        $peserta = Peserta::find($idPeserta);
        if (!$peserta) {
            return abort(404);
        }

        $check = $peserta->user->no_unik == $noUnik ? true : false;
        if (!$check) {
            return abort(404);
        }

        $user = $peserta->user;
        $tipeIdentitas = \Helper::getEnumValues('peserta', 'tipe_identitas');
        $prodi = Prodi::all();

        $foto = PesertaDokumen::where('list_dokumen_id', 1)->where('peserta_id', $peserta->id)->first();
        // dd(GoogleDrive::showImage($foto->path));
        $pdf = Pdf::loadView(
            'peserta.formulir.cetak',
            compact('peserta', 'tipeIdentitas', 'prodi', 'foto')
        );

        return $pdf->setPaper('a4')
            ->stream('Cetak Formulir.pdf');
    }

    public function uploadBukti(Request $request)
    {
        try {
            $request->validate([
                'file_bukti' => 'required|file|mimes:jpg,jpeg,png,pdf|max:20480',
            ], [
                'file_bukti.required' => 'File bukti wajib diupload',
                'file_bukti.mimes' => 'File harus bertipe jpg, jpeg, png, atau pdf',
                'file_bukti.max' => 'Ukuran file maksimal 20MB',
            ]);

            $file = $request->file('file_bukti');
            $peserta = Peserta::where('user_id', \Auth::user()->id)->first();

            // Check if female
            if ($peserta->user->jenis_kelamin != 'Perempuan') {
                return [
                    'message' => 500,
                    'data' => 'Fitur ini hanya untuk mahasiswa perempuan',
                ];
            }

            $dokumen = \App\Models\DokumenBuktiRevisi::where('peserta_id', $peserta->id)->first();

            if (!$dokumen) {
                $dokumen = new \App\Models\DokumenBuktiRevisi;
                $dokumen->peserta_id = $peserta->id;
            } else {
                // Delete old file if exists
                if ($dokumen->file_bukti) {
                    GoogleDrive::delete($dokumen->file_bukti, $this->dir);
                }
            }

            $upload = GoogleDrive::upload($file, 'BUKTI', $this->dir);
            $path = GoogleDrive::getData($upload['name'], $this->dir);
            
            $dokumen->file_bukti = $upload['name'];
            $dokumen->path_bukti = $path['path'];
            $dokumen->status_bukti = 'belum_validasi';
            $dokumen->save();

            return [
                'message' => 200,
                'data' => 'Berhasil mengupload bukti',
            ];
        } catch (\Illuminate\Validation\ValidationException $e) {
            return [
                'message' => 500,
                'data' => $e->validator->errors()->first(),
            ];
        } catch (\Throwable $th) {
            return [
                'message' => 500,
                'data' => 'Gagal mengupload bukti: ' . $th->getMessage(),
            ];
        }
    }

    public function uploadRevisi(Request $request)
    {
        try {
            $request->validate([
                'file_revisi' => 'required|file|mimes:jpg,jpeg,png,pdf|max:20480',
            ], [
                'file_revisi.required' => 'File revisi wajib diupload',
                'file_revisi.mimes' => 'File harus bertipe jpg, jpeg, png, atau pdf',
                'file_revisi.max' => 'Ukuran file maksimal 20MB',
            ]);

            $file = $request->file('file_revisi');
            $peserta = Peserta::where('user_id', \Auth::user()->id)->first();

            // Check if female
            if ($peserta->user->jenis_kelamin != 'Perempuan') {
                return [
                    'message' => 500,
                    'data' => 'Fitur ini hanya untuk mahasiswa perempuan',
                ];
            }

            $dokumen = \App\Models\DokumenBuktiRevisi::where('peserta_id', $peserta->id)->first();

            if (!$dokumen) {
                $dokumen = new \App\Models\DokumenBuktiRevisi;
                $dokumen->peserta_id = $peserta->id;
            } else {
                // Delete old file if exists
                if ($dokumen->file_revisi) {
                    GoogleDrive::delete($dokumen->file_revisi, $this->dir);
                }
            }

            $upload = GoogleDrive::upload($file, 'REVISI', $this->dir);
            $path = GoogleDrive::getData($upload['name'], $this->dir);
            
            $dokumen->file_revisi = $upload['name'];
            $dokumen->path_revisi = $path['path'];
            $dokumen->status_revisi = 'belum_validasi';
            $dokumen->save();

            return [
                'message' => 200,
                'data' => 'Berhasil mengupload revisi',
            ];
        } catch (\Illuminate\Validation\ValidationException $e) {
            return [
                'message' => 500,
                'data' => $e->validator->errors()->first(),
            ];
        } catch (\Throwable $th) {
            return [
                'message' => 500,
                'data' => 'Gagal mengupload revisi: ' . $th->getMessage(),
            ];
        }
    }

    public function cetakAntrianAtribut($idPeserta, $noUnik)
    {
        $peserta = Peserta::find($idPeserta);
        if (!$peserta) {
            return abort(404);
        }

        $check = $peserta->user->no_unik == $noUnik ? true : false;
        if (!$check) {
            return abort(404);
        }

        // Check if female
        if ($peserta->user->jenis_kelamin != 'Perempuan') {
            return abort(403, 'Fitur ini hanya untuk mahasiswa perempuan');
        }

        // Check if bukti and revisi are uploaded and validated
        $dokumen = \App\Models\DokumenBuktiRevisi::where('peserta_id', $peserta->id)->first();
        if (!$dokumen || !$dokumen->file_bukti || !$dokumen->file_revisi) {
            return abort(403, 'Anda harus mengupload bukti dan revisi terlebih dahulu');
        }
        if ($dokumen->status_bukti != 'diterima' || $dokumen->status_revisi != 'diterima') {
            return abort(403, 'Bukti dan revisi Anda harus divalidasi dan diterima terlebih dahulu');
        }

        // Get or create antrian
        $antrian = \App\Models\AntrianAtribut::where('peserta_id', $peserta->id)->first();
        if (!$antrian) {
            $antrian = new \App\Models\AntrianAtribut;
            $antrian->peserta_id = $peserta->id;
            $antrian->nomor_antrian = \App\Models\AntrianAtribut::generateNomorAntrian($peserta->id);
            $antrian->save();
        }

        $pdf = Pdf::loadView(
            'peserta.formulir.tiket_antrian',
            compact('peserta', 'antrian')
        );

        return $pdf->setPaper('a6', 'portrait')
            ->stream('Tiket Antrian Atribut.pdf');
    }
}