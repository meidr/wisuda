<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\BulkData;
use App\Http\Services\GoogleDrive;
use App\Http\Services\IsAdmin;
use App\Models\Prodi;
use App\Models\ListDokumen;
use App\Models\Peserta;
use App\Models\PesertaDokumen;
use App\Models\Tahun;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    protected $dir = BulkData::dirGdrive['dokumen'];
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (\Auth::check()) {
                if (IsAdmin::check()) {
                    return $next($request);
                } else {
                    return redirect()->route('home');
                }
            }
            return $next($request);
        });
        // $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        $tipeIdentitas = \Helper::getEnumValues('peserta', 'tipe_identitas');

        $prodi = Prodi::all();
        $listDokumen = ListDokumen::where('status', 'wajib')->get();

        return view('auth.register', compact('tipeIdentitas', 'prodi', 'listDokumen'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255', 'unique:users', 'regex:/^\S*$/'],
            'nama' => ['nullable', 'string', 'max:255'],
            'nim' => ['nullable', 'string', 'max:255'],
            'prodi_id' => ['required', 'string', 'max:255'],
            'tempat_lahir' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'string', 'max:255'],
            'nomor_hp' => ['required', 'string', 'max:255'],
            'tipe_identitas' => ['required', 'string', 'max:255'],
            'nomor_identitas' => ['required', 'string', 'max:255'],
            'propinsi' => ['nullable', 'string', 'max:255'],
            'kota' => ['nullable', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:255'],
            'file.*' => ['required', 'mimes:jpeg,png,jpg', 'max:20480'],
            'id_dokumen.*' => 'required',
        ], [
            'username.unique' => 'Username sudah terdaftar. Gunakan username yang lain',
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $create = $this->create($request->all());
        if ($create['status'] == false) {
            return redirect()->back()->withInput()->with('error', $create['message']);
        }

        $user = $create['user'];
        event(new Registered($user));

        if (\Auth::check()) {
            if (IsAdmin::check()) {
                return redirect()->route('admin.peserta')->with([
                    'type' => 'message',
                    'status' => 'success',
                    'message' => "Data peserta $user->nama berhasil ditambahkan"
                ]);
            }
        }

        $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return array
     */
    protected function create(array $data)
    {
        try {
            \DB::beginTransaction();
            $generateRandomString = \Helper::generateRandomString();
            $dataCreate = [
                'username' => $data['username'],
                'nama' => $data['nama'],
                'password' => \Hash::make($generateRandomString),
                'role_id' => 2,
                'jenis_kelamin' => $data['jenis_kelamin'],
                'status' => 'inactive',
                'no_unik' => $generateRandomString
            ];

            $user = User::create($dataCreate);

            $tahunId = Tahun::where('status', 'Y')->first();

            $pesertaData = [
                'user_id' => strtoupper($user['id']),
                'tahun_id' => $tahunId->id,
                'tanggal_daftar' => now(),
                'tempat_lahir' => strtoupper($data['tempat_lahir']),
                'nama' => strtoupper($user['nama']),
                'nim' => strtoupper($data['nim']),
                'tanggal_lahir' => strtoupper($data['tanggal_lahir']),
                'nomor_hp' => strtoupper($data['nomor_hp']),
                'tipe_identitas' => strtoupper($data['tipe_identitas']),
                'nomor_identitas' => strtoupper($data['nomor_identitas']),
                'propinsi' => strtoupper($data['propinsi']),
                'kota' => strtoupper($data['kota']),
                'alamat' => strtoupper($data['alamat']),
                'prodi_id' => strtoupper($data['prodi_id']),
                'status_id' => 3,
            ];

            $peserta = Peserta::create($pesertaData);

            $uploadData = request()->file('file');
            if (request()->has('file')) {
                for ($i = 0; $i < count($uploadData); $i++) {
                    $upload = $this->upload($uploadData[$i], 'FOTO');
                    PesertaDokumen::create([
                        'peserta_id' => $peserta['id'],
                        'tanggal' => now(),
                        'list_dokumen_id' => $data['id_dokumen'][$i],
                        'file' => $upload->file,
                        'path' => $upload->path
                    ]);
                }
            }

            \DB::commit();
            return [
                'status' => true,
                'user' => $user,
            ];
        } catch (\Throwable $th) {
            \DB::rollback();
            return [
                'status' => false,
                'message' => $th->getMessage()
            ];
        }
    }

    function upload($file, $tipe)
    {
        $uploadFile = GoogleDrive::upload($file, strtoupper($tipe), $this->dir);
        $path = GoogleDrive::getData($uploadFile['name'], $this->dir);
        $getPath = $path['path'];

        return (object) [
            'path' => $getPath,
            'file' => $uploadFile['name']
        ];
    }
}