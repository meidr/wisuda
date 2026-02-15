<?php

namespace App\Http\Services;

class BulkData
{
    public const dirGdrive = [
        "dokumen" => "/14Xpy43zfaWi5C7GmOKjYC0zyCmg72I0f/",
        "root" => "/",
    ];
    public const jenisKelamin = [
        "Laki-Laki",
        "Perempuan"
    ];
    public const jenisKelaminAssoc = [
        "Laki-Laki" => "Laki-Laki",
        "Perempuan" => "Perempuan"
    ];
    public const pekerjaan = [
        "PIMPINAN PONDOK",
        "USTADZ",
        "GURU",
        "Lainnya"
    ];
    public const pendidikanAsal = [
        "Pondok Pesantren / Madrasah",
        "Sekolah Umum (Negeri/Swasta)",
        "Lainnya"
    ];

    public const statusValueNama = [
        [
            "value" => 1,
            "nama" => "AKTIF"
        ],
        [
            "value" => 0,
            "nama" => "TIDAK AKTIF"
        ]
    ];
    public const vendor = ["fonnte", "zenziva", "satuconnect"];
}
