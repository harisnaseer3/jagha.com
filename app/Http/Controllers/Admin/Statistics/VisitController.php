<?php

namespace App\Http\Controllers\Admin\Statistics;

use App\Events\LogErrorEvent;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisitController extends Controller
{
    public static function record()
    {
        // Check to see if we're a returning visitor.
        $d = Carbon::now()->format('Y-m-d');


        $result = DB::connection('mysql2')->table('visit')->select('ID','last_counter')
            ->where('last_counter', $d)
            ->first();

        if ($result && $result->last_counter == $d) {
            DB::connection('mysql2')->table('visit')
                ->where('ID', $result->ID)
                ->increment('visit');
        } else {
            try {
                DB::connection('mysql2')->table('visit')->insert([
                    'last_visit' => Carbon::now()->toDateTimeString(),
                    'last_counter' => $d,
                    'visit' => 1
                ]);
            }catch(\Exception $e){
//                dd($e->getMessage());
                event(new LogErrorEvent($e->getMessage(), 'Error in visit controller record method'));

            }

        }
    }
}
