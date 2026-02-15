<?php

namespace App\Http\Controllers;

use App\Http\Services\WhatsApp;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TestingController extends Controller
{
    public function index()
    {
        return 'testing';
    }
}
