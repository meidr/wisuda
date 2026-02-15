<?php
/*
|--------------------------------------------------------------------------
| Environment Variable for API
|--------------------------------------------------------------------------
/ you can call it with: config('api.key')
|
 */

use App\Http\Services\BulkData;

return [
    "key" => env('API_KEY')
];
