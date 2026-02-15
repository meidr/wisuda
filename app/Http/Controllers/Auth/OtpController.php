<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\BulkData;
use App\Http\Services\Otp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OtpController extends Controller
{
    public function index(User $user)
    {
        $targetDate = Carbon::parse($user->otp_request)->addMinute()->format('Y-m-d H:i:s');
        return view('auth.otp.index', compact('siswa', 'targetDate'));
    }

    public function process(User $user, Request $request)
    {
        try {
            $request->validate([
                'nomor_hp' => 'required',
                'otp' => 'required'
            ], BulkData::messagesValidator);

            if ($request->nomor_hp != $user->nomor_hp) {
                abort(500, 'Nomor HP tidak sama dengan yang terdaftar');
            }

            if ($request->otp != $user->otp) {
                abort(500, 'Error, OTP tidak sama');
            }

            return view('auth.otp.set-password', compact('siswa'));
        } catch (ValidationException $e) {
            return back()->withInput()->withErrors($e->validator->errors());
        } catch (\Throwable $th) {
            return back()->with([
                'message' => $th->getMessage(),
                'title' => 'danger'
            ])->withInput();
        }
    }

    public function setPassword(User $user)
    {
        return view('auth.otp.set-password', compact('siswa'));
    }

    public function resend(User $user)
    {
        try {
            \DB::beginTransaction();

            $targetDate = Carbon::parse($user->otp_request)->addMinute();
            $currentDate = Carbon::parse(Carbon::now());

            if ($currentDate < $targetDate) {
                abort(500);
            }

            $data = [
                'nama' => $user->nama,
                'otp' => $user->otp,
                'nomor_hp' => $user->nomor_hp
            ];
            $now = date("Y-m-d H:i:s");
            $user->otp_request = $now;
            $user->save();

            $sendOtp = Otp::send($data);
            if (!$sendOtp) {
                abort(500);
            }

            \DB::commit();
            return redirect()->route('otp', ['siswa' => $user])->with([
                'message' => 'OTP berhasil dikirimkan ke whatsapp',
                'title' => 'success'
            ]);
        } catch (\Throwable $th) {
            \DB::rollback();
            return redirect()->route('otp', ['siswa' => $user])->with([
                'message' => 'OTP gagal dikirimkan, tunggu beberapa detik sampai muncul "Kirim lagi"',
                'title' => 'danger'
            ]);
        }
    }

    public function savePassword(User $user, Request $request)
    {
        try {
            $request->validate([
                'password' => 'required',
                'konfirmasi_password' => 'required|same:password'
            ], BulkData::messagesValidator);

            $password = \Hash::make($request->password);

            $user->password = $password;
            $user->passkey = $request->password;
            $user->save();

            return redirect()->route('login')->with([
                'message' => 'Berhasil set password akun, silahkan login dengan Prodi, NIK dan password',
                'title' => 'success',
                'data_otp' => $user
            ]);
        } catch (ValidationException $e) {
            return back()->withInput()->withErrors($e->validator->errors());
        } catch (\Throwable $th) {
            return back()->with([
                'message' => $th->getMessage(),
                'title' => 'danger'
            ])->withInput();
        }
    }
}
