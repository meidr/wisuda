<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaDokumen extends Model
{
    use HasFactory;

    protected $table = "peserta_dokumen";
    protected $guarded = [];
    
    public function peserta(){
        return $this->belongsTo(Peserta::class);
    }
}
