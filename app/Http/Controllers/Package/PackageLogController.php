<?php

namespace App\Http\Controllers\Package;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PackageLogController extends Controller
{
    public function add($args)
    {
        DB::table('package_logs')->insert($args);
    }
}
