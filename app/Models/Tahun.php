<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tahun extends Model
{
    use HasFactory;
    
    protected $table = "tahun";
    protected $guarded = [];

    public static function aktif()
    {
        return self::where('status', 'Y')->first();
    }
}
