<?php

namespace App\Http\Middleware;

use App\Models\Otp;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOtp
{
    /**
     * Handle an incoming request.
     * Redirect ke halaman OTP jika admin belum verifikasi OTP di session ini.
     * Jika sudah ada OTP verified yang belum expired di DB, skip OTP.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && !session('otp_admin_verified')) {
            // Cek apakah ada OTP yang sudah diverifikasi dan belum expired
            $verifiedOtp = Otp::where('user_id', Auth::id())
                ->whereNotNull('verified_at')
                ->where('expires_at', '>', now())
                ->exists();

            if ($verifiedOtp) {
                // Auto-set session, tidak perlu OTP lagi
                session(['otp_admin_verified' => true]);
                return $next($request);
            }

            return redirect()->route('admin.otp');
        }

        return $next($request);
    }
}
