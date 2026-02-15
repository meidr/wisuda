<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOtpController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Tampilkan halaman OTP dan generate/kirim OTP via WhatsApp.
     */
    public function index()
    {
        // Jika sudah verified, langsung ke dashboard
        if (session('otp_admin_verified')) {
            return redirect()->route('admin.dashboard');
        }

        // Generate OTP (akan kirim WA jika belum ada OTP aktif)
        Otp::generate();

        $hp = Auth::user()->hp;
        // Sembunyikan sebagian nomor HP: 0812****5678
        $hpMasked = $hp ? substr($hp, 0, 4) . '****' . substr($hp, -4) : '-';

        return view('admin.auth.otp', compact('hpMasked'));
    }

    /**
     * Verifikasi kode OTP yang diinput admin.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|min:6|max:6',
        ], [
            'otp.required' => 'Kode OTP wajib diisi',
            'otp.min' => 'Kode OTP harus 6 digit',
            'otp.max' => 'Kode OTP harus 6 digit',
        ]);

        $verified = Otp::verify($request->otp);

        if ($verified) {
            session(['otp_admin_verified' => true]);
            return redirect()->route('admin.dashboard');
        }

        return back()->with([
            'message' => 'Kode OTP salah atau sudah kadaluarsa',
            'title' => 'danger',
        ]);
    }

    /**
     * Kirim ulang OTP.
     */
    public function resend()
    {
        try {
            Otp::resend();
            return redirect()->route('admin.otp')->with([
                'message' => 'OTP berhasil dikirim ulang ke WhatsApp',
                'title' => 'success',
            ]);
        } catch (\Throwable $th) {
            return redirect()->route('admin.otp')->with([
                'message' => 'Gagal mengirim ulang OTP: ' . $th->getMessage(),
                'title' => 'danger',
            ]);
        }
    }
}
