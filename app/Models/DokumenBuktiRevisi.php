<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenBuktiRevisi extends Model
{
    use HasFactory;

    protected $table = 'dokumen_bukti_revisi';
    protected $guarded = [];

    private static $badgeMap = [
        'belum_validasi' => 'warning',
        'diterima' => 'success',
        'ditolak' => 'danger',
    ];

    private static $labelMap = [
        'belum_validasi' => 'Belum Validasi',
        'diterima' => 'Diterima',
        'ditolak' => 'Ditolak',
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    /**
     * Get status badge class for bukti
     */
    public function getStatusBuktiBadgeAttribute()
    {
        return self::$badgeMap[$this->status_bukti] ?? 'secondary';
    }

    /**
     * Get status badge class for revisi
     */
    public function getStatusRevisiBadgeAttribute()
    {
        return self::$badgeMap[$this->status_revisi] ?? 'secondary';
    }

    /**
     * Get status label for bukti
     */
    public function getStatusBuktiLabelAttribute()
    {
        return self::$labelMap[$this->status_bukti] ?? '-';
    }

    /**
     * Get status label for revisi
     */
    public function getStatusRevisiLabelAttribute()
    {
        return self::$labelMap[$this->status_revisi] ?? '-';
    }
}
