<?php

namespace App\Http\Services;

use App\Models\Otp as ModelsOtp;
use App\Models\Setting;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Otp
{
    /**
     * Send otp
     * @param array $data, $data['name', 'otp', 'nomor_hp']
     * @return boolean true or false, true for success send otp
     */
    public static function send($data)
    {
        try {
            $vendor = Setting::where('slug', 'vendor_notifikasi')->first()->value;

            $nama = $data['nama'];
            $otp = $data['otp'];
            $tanggal = Carbon::now()->format('d-m-Y H:i:s');
            $message = "Assalamu'alaikum *$nama*\n\nTerima kasih telah membuat akun PMB UII Dalwa kode OTP anda adalah *$otp*\n\nSilahkan melanjutkan proses pendaftaran, jika ada kendala silahkan hubungi kami di contact person yang tertera di WEB (OTP ini dikirim secara otomatis)  .  terima kasih dan semoga sehat selalu.\n$tanggal\n\nTTD Panitia PMB";
            // $message = 'Halo ' . $data['nama'] . ' kode OTPmu adalah ' . $data['otp'];
            $telepon = $data['nomor_hp'];

            $param_notif = [
                'message' => $message,
                'phone' => $telepon,
            ];

            if (empty($vendor) || $vendor == 'fonnte') {
                $param_notif['vendor'] = 'fonnte';
                $param_notif['type'] = 'notif_wa_fonnte';
            } elseif ($vendor == 'pingnotif') {
                $param_notif['vendor'] = 'pingnotif';
                $param_notif['type'] = 'notif_wa_pingnotif';
            } elseif ($vendor == 'zenziva') {
                $param_notif['vendor'] = 'zenziva';
                $param_notif['type'] = 'notif_wa_zenziva';
            } elseif ($vendor == 'sms') {
                $param_notif['vendor'] = 'sms';
            }

            $notif = WhatsApp::_notif($param_notif);
            if (!$notif) {
                return false;
            } else {
                return true;
            }
        } catch (\Throwable $th) {
            return false;
        }
    }

    public static function generate()
    {

        $otp = ModelsOtp::where('user_id', Auth::user()->id)
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (! $otp) {
            $code = rand(100000, 999999);
            $whatsapp = WhatsApp::_notif([
                'phone'   => Auth::user()->hp,
                'message' => str_replace('{otp}', $code, WhatsApp::$templateOtp2),
            ]);
            if (!$whatsapp) {
                return false;
            }
            $otp  = ModelsOtp::create([
                'user_id'    => Auth::user()->id,
                'hp'         => Auth::user()->hp,
                'otp'        => bcrypt($code),
                'expires_at' => now()->addMinutes(5),
            ]);
        }

        return $otp;
    }

    public static function verify($otpInput)
    {
        $otp = ModelsOtp::where('user_id', Auth::user()->id)
            ->where('expires_at', '>', now())
            ->latest() // In case multiple OTPs exist, get the latest one
            ->first();

        if ($otp && Hash::check($otpInput, $otp->otp)) {
            $otp->verified_at = now();
            $otp->save();
            return true;
        }

        return false;
    }

    public static function resend()
    {
        ModelsOtp::where('user_id', Auth::user()->id)
            ->where('expires_at', '>', now())
            ->whereNull('verified_at')
            ->delete();

        return self::generate();
    }
}
