<?php

namespace App\Http\Controllers;

use App\Models\Brosur;
use App\Models\Faq;
use App\Models\Informasi;
use App\Models\Jadwal;
use App\Models\Setting;
use App\Models\Tahun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RootController extends Controller
{
    public function root()
    {
        $tahun = Tahun::aktif();

        $jadwal = Jadwal::where('tahun_id', $tahun->id)->first();

        $mulai = \Carbon::parse($jadwal->mulai)->startOfDay();
        $berakhir = \Carbon::parse($jadwal->berakhir)->endOfDay();
        $sekarang = \Carbon::now();

        return view(
            'root',
            compact(
                'tahun',
                'jadwal',
            )
        );
    }

    // Home Admin
    public function home()
    {
        if (\Auth::user()->role_id == 2) {
            return redirect()->route('peserta.dashboard');
        }
        return redirect()->route('admin.dashboard');
    }

    public function pengembangan()
    {
        return view('pengembangan');
    }
}