<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class SearchingController extends Controller
{
    public function index(Request $request)
    {
        try {
            $dataValidated = $request->validate([
                'search' => 'required',
            ]);

            $search = $dataValidated['search'];
            $search = str_replace('-', '', $search);
            $search = str_replace(' ', '', $search);
            $search = str_replace('/', '', $search);

            $routeCollection = Route::getRoutes()->get();
            $data = [];
            $listSearch = [];
            foreach ($routeCollection as $rc) {
                $uri = $rc->uri();
                $uri = str_replace('-', '', $uri);
                $uri = str_replace(' ', '', $uri);
                $uri = str_replace('/', '', $uri);
                if (str_contains($uri, $search) && str_contains($uri, 'operasi') == false) {
                    $check = false;
                    foreach ($listSearch as $ls) {
                        if ($ls != $uri) {
                            if (str_contains($uri, $ls) && str_contains($uri, 'operasi') == false) {
                                $check = true;
                            }

                        }
                    }
                    if (!$check) {
                        $listSearch[] = $uri;
                        $data[] = $rc->uri();
                    }
                }
            }
            return view('admin.searching.index', compact('listSearch', 'data'));

        } catch (\Throwable $th) {
            $listSearch = [];
            $data = [];
            return view('admin.searching.index', compact('listSearch', 'data'));
        }
    }

    public function autocomplete(Request $request)
    {
        try {
            $dataValidated = $request->validate([
                'q' => 'required',
            ]);

            $search = $dataValidated['q'];
            $search = str_replace('-', '', $search);
            $search = str_replace(' ', '', $search);
            $search = str_replace('/', '', $search);

            $routeCollection = Route::getRoutes()->get();
            $data = [];
            $listSearch = [];
            foreach ($routeCollection as $rc) {
                $uri = $rc->uri();
                $uri = str_replace('-', '', $uri);
                $uri = str_replace(' ', '', $uri);
                $uri = str_replace('/', '', $uri);
                if (str_contains($uri, $search) && str_contains($uri, 'operasi') == false) {
                    $check = false;
                    foreach ($listSearch as $ls) {
                        if ($ls != $uri) {
                            if (str_contains($uri, $ls) && str_contains($uri, 'operasi') == false) {
                                $check = true;
                            }

                        }
                    }
                    if (!$check) {
                        $listSearch[] = $uri;
                        $data[] = $rc->uri();
                    }
                }
            }
            return $data;
        } catch (\Throwable $th) {
            $data = ["Error"];
            return $data;
        }
    }
}
