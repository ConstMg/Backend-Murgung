<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use Illuminate\Support\Facades\DB;
use App\Models\Login;

class KaryawanController
{
    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
