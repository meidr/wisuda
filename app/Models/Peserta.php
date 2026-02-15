<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;
    protected $table   = "peserta";
    protected $guarded = [];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getProdi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id', 'id');
    }
    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id', 'id');
    }
    public function tahun()
    {
        return $this->belongsTo(Tahun::class);
    }
    public function kehadiran()
    {
        return $this->hasMany(Kehadiran::class);
    }
    public function urutan()
    {
        return $this->hasMany(Urutan::class);
    }

    public function dokumenBuktiRevisi()
    {
        return $this->hasOne(DokumenBuktiRevisi::class);
    }

    public function antrianAtribut()
    {
        return $this->hasOne(AntrianAtribut::class);
    }
}
