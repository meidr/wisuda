<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Urutan extends Model
{
    use HasFactory;

    protected $table = 'urutan';

    protected $guarded = [];

    public function peserta(){
        return $this->belongsTo(Peserta::class, 'peserta_id', 'id');
    }
}
