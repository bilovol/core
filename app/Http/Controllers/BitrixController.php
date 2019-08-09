<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request,
    Illuminate\Support\Facades\Log;

class BitrixController extends Controller
{
    public function login(Request $request)
    {
        Log::info($request->all());
    }
}
