<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;

class Otp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $status)
    {
        $otp = Setting::where('slug', 'otp')->first()->value;
        $siswa = $request->route('siswa');
        switch ($status) {
            case 0:
                if ($otp != $status) {
                    return redirect()->route('login');
                }
                break;
            case 1:
                if ($otp != $status) {
                    return redirect()->route('otp.setPassword', ['siswa' => $siswa]);
                }
                break;

            default:
                return redirect()->route('login');
        }
        return $next($request);
    }
}
