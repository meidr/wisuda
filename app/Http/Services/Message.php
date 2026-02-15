<?php

namespace App\Http\Services;

use App\Models\Peserta;
use App\Models\Setting;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class Message
{
    /**
     * Send Message
     * @param array $data, $data[nomor_hp, peserta_id]
     * @return boolean true or false, true for success send Message
     */
    public static function send($data)
    {
        try {
            $vendor = Setting::where('slug', 'vendor_notifikasi')->first()->value;

            $tanggal = Carbon::now()->format('d-m-Y H:i:s');

            if ($data['peserta_id'] == null) {
                $peserta = (object) [
                    'nama' => 'Fulan',
                    'user' => (object) [
                        'username' => 'fulan'
                    ]
                ];
                $urlFormulir = 'google.com';
            } else {
                $peserta = Peserta::findOrFail($data['peserta_id']);
                $urlFormulir = route('peserta.formulir.cetak', ['idPeserta' => @$peserta->id, 'noUnik' => @$peserta->user->no_unik]);
            }

            $admin = Auth::user()->nama;

            // Send message
            $search = ['{admin}', '{nama}', '{username}', '{password}', '{urlFormulir}', '{tanggal}'];
            $replace = [$admin, $peserta->nama, $peserta->user->username, $data['password'], $urlFormulir, $tanggal];
            $message = str_replace(
                $search,
                $replace,
                Setting::where('slug', 'isi_pesan_wa')->first()->value
            );
            $telepon = $data['nomor_hp'];

            $param_notif = [
                'message' => $message,
                'phone' => $telepon,
            ];

            // select vendor send message
            if (empty($vendor) || $vendor == 'fonnte') {
                $param_notif['vendor'] = 'fonnte';
                $param_notif['type'] = 'notif_wa_fonnte';
            } elseif ($vendor == 'pingnotif') {
                $param_notif['vendor'] = 'pingnotif';
                $param_notif['type'] = 'notif_wa_pingnotif';
            } elseif ($vendor == 'zenziva') {
                $param_notif['vendor'] = 'zenziva';
                $param_notif['type'] = 'notif_wa_zenziva';
            } elseif ($vendor == 'satuconnect') {
                $param_notif['vendor'] = 'satuconnect';
                $param_notif['type'] = 'notif_wa_satuconnect';
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
