<?php

namespace App\Http\Middleware;

use App\Http\Services\IsAdmin;
use Closure;
use App\Models\Tahun;
use App\Models\Jadwal as JadwalModel;
use Illuminate\Http\Request;

class Jadwal
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!\Auth::check()) {
            return redirect()->route('root')->with('error', 'Pendaftaran hanya bisa dilakukan oleh operator');
        }
        
        if (!IsAdmin::check()) {
            return redirect()->route('root')->with('error', 'Pendaftaran hanya bisa dilakukan oleh operator');
        }
        // if (\Auth::check()) {
        //     if (IsAdmin::check()) {
        //         return $next($request);
        //     }
        // }
        // $tahunAktif = Tahun::aktif();
        // $jadwal = JadwalModel::where('tahun_id', $tahunAktif->id)->first();
        // if ($jadwal == null) {
        //     return redirect()->route('root')->with('error', 'Pendaftaran Belum Dibuka');
        // }

        // $mulai = \Carbon::parse($jadwal->mulai)->startOfDay();
        // $berakhir = \Carbon::parse($jadwal->berakhir)->endOfDay();
        // $sekarang = \Carbon::now();

        // if ($sekarang->lt($mulai) || $sekarang->gt($berakhir)) {
        //     return redirect()->route('root')->with('error', 'Pendaftaran Sudah Ditutup');
        // }
        return $next($request);
    }
}
