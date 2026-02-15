<?php

namespace App\Http\Services;

use App\Models\Setting;

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
            $tanggal = \Carbon::now()->format('d-m-Y H:i:s');
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
}