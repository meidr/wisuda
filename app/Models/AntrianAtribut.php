<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntrianAtribut extends Model
{
    use HasFactory;

    protected $table = 'antrian_atribut';
    protected $guarded = [];

    protected $casts = [
        'waktu_scan' => 'datetime',
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    /**
     * Generate unique queue number
     */
    public static function generateNomorAntrian($pesertaId)
    {
        $prefix = 'ATR';
        $date = now()->format('ymd');
        $count = self::whereDate('created_at', now()->toDateString())->count() + 1;
        return $prefix . $date . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}
