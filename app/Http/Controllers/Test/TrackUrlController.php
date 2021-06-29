<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrackUrlController extends Controller
{
    public static function store($args)
    {
        DB::table('track_urls')->insert($args);
    }
}
