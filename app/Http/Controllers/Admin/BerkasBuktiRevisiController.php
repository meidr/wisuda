<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\BulkData;
use App\Http\Services\GoogleDrive;
use App\Models\DokumenBuktiRevisi;
use App\Models\Peserta;
use App\Models\Prodi;
use App\Models\Tahun;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BerkasBuktiRevisiController extends Controller
{
    protected $dir = BulkData::dirGdrive['dokumen'];

    public function index()
    {
        $tahun = Tahun::all();
        $prodi = Prodi::all();

        return view('admin.berkas_bukti_revisi.index', compact('tahun', 'prodi'));
    }

    /**
     * Get badge class based on status
     */
    private function getStatusBadge($status)
    {
        switch ($status) {
            case 'belum_validasi':
                return 'warning';
            case 'diterima':
                return 'success';
            case 'ditolak':
                return 'danger';
            default:
                return 'secondary';
        }
    }

    /**
     * Get label based on status
     */
    private function getStatusLabel($status)
    {
        switch ($status) {
            case 'belum_validasi':
                return 'Belum Validasi';
            case 'diterima':
                return 'Diterima';
            case 'ditolak':
                return 'Ditolak';
            default:
                return '-';
        }
    }

    public function data(Request $request)
    {
        $search = request('search.value');
        
        // Only get female students (Perempuan)
        $data = Peserta::join('users', 'users.id', '=', 'peserta.user_id')
            ->join('tahun', 'tahun.id', '=', 'peserta.tahun_id')
            ->leftJoin('prodi', 'prodi.id', '=', 'peserta.prodi_id')
            ->leftJoin('dokumen_bukti_revisi', 'dokumen_bukti_revisi.peserta_id', '=', 'peserta.id')
            ->where('users.jenis_kelamin', 'Perempuan')
            ->select(
                'peserta.*',
                'users.jenis_kelamin as jenis_kelamin',
                'tahun.nama as tahun_nama',
                'prodi.nama as prodi_nama',
                'dokumen_bukti_revisi.id as dokumen_id',
                'dokumen_bukti_revisi.file_bukti',
                'dokumen_bukti_revisi.path_bukti',
                'dokumen_bukti_revisi.status_bukti',
                'dokumen_bukti_revisi.file_revisi',
                'dokumen_bukti_revisi.path_revisi',
                'dokumen_bukti_revisi.status_revisi'
            );

        return DataTables::of($data)
            ->filter(function ($query) use ($search, $request) {
                $query->when($request->tahun_id != "*", function ($query) use ($request) {
                    $query->where('peserta.tahun_id', $request->tahun_id);
                });
                $query->when($request->prodi_id != "*", function ($query) use ($request) {
                    $query->where('peserta.prodi_id', $request->prodi_id);
                });
                $query->when($request->status_bukti != "*", function ($query) use ($request) {
                    if ($request->status_bukti == 'belum_upload') {
                        $query->whereNull('dokumen_bukti_revisi.file_bukti');
                    } else {
                        $query->where('dokumen_bukti_revisi.status_bukti', $request->status_bukti);
                    }
                });
                $query->when($request->status_revisi != "*", function ($query) use ($request) {
                    if ($request->status_revisi == 'belum_upload') {
                        $query->whereNull('dokumen_bukti_revisi.file_revisi');
                    } else {
                        $query->where('dokumen_bukti_revisi.status_revisi', $request->status_revisi);
                    }
                });
                $query->where(function ($query) use ($search) {
                    $query->orWhere('peserta.nama', 'LIKE', "%$search%");
                    $query->orWhere('peserta.nim', 'LIKE', "%$search%");
                });
            })
            ->editColumn('nama', function ($row) {
                return "<b>$row->nama</b>";
            })
            ->editColumn('prodi_nama', function ($row) {
                return $row->prodi_nama ?? '-';
            })
            ->editColumn('nim', function ($row) {
                return $row->nim ?? '-';
            })
            ->addColumn('status_bukti_badge', function ($row) {
                if (!$row->file_bukti) {
                    return '<span class="badge badge-secondary">Belum Upload</span>';
                }
                $badge = $this->getStatusBadge($row->status_bukti);
                $label = $this->getStatusLabel($row->status_bukti);
                return '<span class="badge badge-' . $badge . '">' . $label . '</span>';
            })
            ->addColumn('status_revisi_badge', function ($row) {
                if (!$row->file_revisi) {
                    return '<span class="badge badge-secondary">Belum Upload</span>';
                }
                $badge = $this->getStatusBadge($row->status_revisi);
                $label = $this->getStatusLabel($row->status_revisi);
                return '<span class="badge badge-' . $badge . '">' . $label . '</span>';
            })
            ->addColumn('action', function ($row) {
                $linkBukti = $row->path_bukti ? GoogleDrive::link($row->path_bukti) : '#';
                $linkRevisi = $row->path_revisi ? GoogleDrive::link($row->path_revisi) : '#';
                
                $actionBtn = '
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button"
                        id="dropdownMenuButton" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        Klik
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                
                if ($row->file_bukti) {
                    $actionBtn .= '
                        <button type="button" class="dropdown-item btn-validasi-bukti"
                            data-toggle="modal" data-target="#modal_validasi_bukti"
                            data-id="' . $row->id . '"
                            data-nama="' . $row->nama . '"
                            data-nim="' . $row->nim . '"
                            data-link="' . $linkBukti . '"
                            data-status="' . $row->status_bukti . '"
                        >Validasi Bukti</button>';
                }
                
                if ($row->file_revisi) {
                    $actionBtn .= '
                        <button type="button" class="dropdown-item btn-validasi-revisi"
                            data-toggle="modal" data-target="#modal_validasi_revisi"
                            data-id="' . $row->id . '"
                            data-nama="' . $row->nama . '"
                            data-nim="' . $row->nim . '"
                            data-link="' . $linkRevisi . '"
                            data-status="' . $row->status_revisi . '"
                        >Validasi Revisi</button>';
                }
                
                if (!$row->file_bukti && !$row->file_revisi) {
                    $actionBtn .= '<span class="dropdown-item text-muted">Belum ada dokumen</span>';
                }
                
                $actionBtn .= '
                    </div>
                </div>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'status_bukti_badge', 'status_revisi_badge', 'nama'])
            ->toJson();
    }

    public function validasiBukti(Request $request)
    {
        try {
            $request->validate([
                'peserta_id' => 'required',
                'status' => 'required|in:belum_validasi,diterima,ditolak',
            ]);

            $dokumen = DokumenBuktiRevisi::where('peserta_id', $request->peserta_id)->first();
            
            if (!$dokumen) {
                return [
                    'message' => 500,
                    'data' => 'Dokumen tidak ditemukan',
                ];
            }

            $dokumen->status_bukti = $request->status;
            $dokumen->save();

            return [
                'message' => 200,
                'data' => 'Status bukti berhasil diupdate',
            ];
        } catch (\Throwable $th) {
            return [
                'message' => 500,
                'data' => $th->getMessage(),
            ];
        }
    }

    public function validasiRevisi(Request $request)
    {
        try {
            $request->validate([
                'peserta_id' => 'required',
                'status' => 'required|in:belum_validasi,diterima,ditolak',
            ]);

            $dokumen = DokumenBuktiRevisi::where('peserta_id', $request->peserta_id)->first();
            
            if (!$dokumen) {
                return [
                    'message' => 500,
                    'data' => 'Dokumen tidak ditemukan',
                ];
            }

            $dokumen->status_revisi = $request->status;
            $dokumen->save();

            return [
                'message' => 200,
                'data' => 'Status revisi berhasil diupdate',
            ];
        } catch (\Throwable $th) {
            return [
                'message' => 500,
                'data' => $th->getMessage(),
            ];
        }
    }
}

