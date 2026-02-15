<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function all(Request $request)
    {
        try {
            $dataValidated = $request->validate([
                'limit' => 'nullable',
                'offset' => 'nullable',
                'order' => 'nullable',
                'dir' => 'nullable',
                'search' => 'nullable',
                'where' => 'nullable',
            ]);

            $offset = isset($dataValidated['offset']) ? $dataValidated['offset'] : null;
            $limit = isset($dataValidated['limit']) ? $dataValidated['limit'] : null;
            $search = isset($dataValidated['search']) ? $dataValidated['search'] : null;
            $order = isset($dataValidated['order']) ? $dataValidated['order'] : null;
            $dir = isset($dataValidated['dir']) ? $dataValidated['dir'] : null;
            $where = isset($dataValidated['where']) ? $dataValidated['where'] : null;

            // $where = [
            //     ['siswa.id', 1000]
            // ];
            // $where = json_encode($where);

            $siswa = Siswa::leftJoin('prodi as prodi_1', 'prodi_1.id', '=', 'siswa.prodi_id')
                ->leftJoin('prodi as prodi_2', 'prodi_2.id', '=', 'siswa.prodi_id_pilihan_2')
                ->leftJoin('prodi as prodi_3', 'prodi_3.id', '=', 'siswa.prodi_id_pilihan_3')
                ->leftJoin('status', 'status.id', '=', 'siswa.status')
                ->select('siswa.*')
                ->when($search, function ($q) use ($search) {
                    $q->where(function ($q) use ($search) {
                        $q->orWhere('siswa.nik', 'LIKE', "%$search%");
                        $q->orWhere('siswa.nama', 'LIKE', "%$search%");
                        $q->orWhere('siswa.jenis_kelamin', 'LIKE', "%$search%");
                        $q->orWhere('prodi_1.nama', 'LIKE', "%$search%");
                        ;
                    });
                })
                ->when($where, function ($q) use ($where) {
                    $where = json_decode($where);
                    $q->where($where);
                })
                ->when($order, function ($q) use ($order, $dir) {
                    $q->orderBy($order, $dir);
                })
                ->when($offset, function ($q) use ($offset) {
                    $q->offset($offset);
                })
                ->when($limit, function ($q) use ($limit) {
                    $q->limit($limit);
                })
                ->with('getProdi', 'getProdi2', 'getProdi3', 'getStatus', 'getOrangTua', 'getDokumen', 'getBayar')
                ->get();
            $data = [
                "status" => true,
                "data" => $siswa,
                'count' => $siswa->count(),
                "message" => "success",
                "code" => 200,
            ];
            return $data;
        } catch (\Throwable $th) {
            $data = [
                "status" => false,
                "data" => [],
                "message" => $th->getMessage(),
                "code" => 500,
            ];
            return $data;
        }

    }

    public function count(Request $request)
    {
        try {
            $dataValidated = $request->validate([
                'limit' => 'nullable',
                'offset' => 'nullable',
                'order' => 'nullable',
                'dir' => 'nullable',
                'search' => 'nullable',
                'where' => 'nullable',
            ]);

            $offset = isset($dataValidated['offset']) ? $dataValidated['offset'] : null;
            $limit = isset($dataValidated['limit']) ? $dataValidated['limit'] : null;
            $search = isset($dataValidated['search']) ? $dataValidated['search'] : null;
            $order = isset($dataValidated['order']) ? $dataValidated['order'] : null;
            $dir = isset($dataValidated['dir']) ? $dataValidated['dir'] : null;
            $where = isset($dataValidated['where']) ? $dataValidated['where'] : null;

            // $where = [
            //     ['siswa.id', 1000]
            // ];
            // $where = json_encode($where);

            $siswa = Siswa::leftJoin('prodi as prodi_1', 'prodi_1.id', '=', 'siswa.prodi_id')
                ->leftJoin('prodi as prodi_2', 'prodi_2.id', '=', 'siswa.prodi_id_pilihan_2')
                ->leftJoin('prodi as prodi_3', 'prodi_3.id', '=', 'siswa.prodi_id_pilihan_3')
                ->leftJoin('status', 'status.id', '=', 'siswa.status')
                ->select('siswa.*')
                ->when($search, function ($q) use ($search) {
                    $q->where(function ($q) use ($search) {
                        $q->orWhere('siswa.nik', 'LIKE', "%$search%");
                        $q->orWhere('siswa.nama', 'LIKE', "%$search%");
                        $q->orWhere('siswa.jenis_kelamin', 'LIKE', "%$search%");
                        $q->orWhere('prodi_1.nama', 'LIKE', "%$search%");
                        ;
                    });
                })
                ->when($where, function ($q) use ($where) {
                    $where = json_decode($where);
                    $q->where($where);
                })
                ->count();

            $data = [
                "status" => true,
                "data" => $siswa,
                'count' => $siswa,
                "message" => "success",
                "code" => 200,
            ];
            return $data;
        } catch (\Throwable $th) {
            $data = [
                "status" => false,
                "data" => [],
                "message" => $th->getMessage(),
                "code" => 500,
            ];
            return $data;
        }

    }

    public function find(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required',
            ]);

            $siswa = Siswa::where('id', $request->id)
                ->with('getProdi', 'getProdi2', 'getProdi3', 'getStatus', 'getOrangTua', 'getDokumen', 'getBayar')
                ->first();

            $data = [
                "status" => true,
                "data" => $siswa,
                'count' => 1,
                "message" => "success",
                "code" => 200,
            ];
            return $data;
        } catch (\Throwable $th) {
            $data = [
                "status" => false,
                "data" => [],
                "message" => $th->getMessage(),
                "code" => 500,
            ];
            return $data;
        }

    }

}
