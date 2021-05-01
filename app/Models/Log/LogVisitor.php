<?php

namespace App\Models\Log;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 * @mixin Builder
 */
class LogVisitor extends Model
{
    protected $connection = 'mysql2';

    public $table = 'visitor';
    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $fillable = [
        'ID', 'last_counter', 'referred','agent','platform','version','ip','location','user_id','UAString','hits','honeypot'
    ];


    private $date_column = 'last_counter';
//    private $selector = '*';
//if ($count_only == true) {
//$selector = 'count(last_counter)';
//}
    public function visitorToday()
    {
        $result = $this->select(DB::raw('count(last_counter) AS count'))->where([$this->date_column => Carbon::now()->format('Y-m-d')])->get();
        if (!$result->isEmpty()) {
            $result = $result[0]->count;
        }
        return !is_numeric($result) ? 0 : $result;
    }

    public function visitorYesterday()
    {
        $result = $this->select(DB::raw('count(last_counter) AS count'))->where([$this->date_column => Carbon::yesterday()->format('Y-m-d')])->get();
        if (!$result->isEmpty()) {
            $result = $result[0]->count;
        }
        return !is_numeric($result) ? 0 : $result;
    }

    public function visitorWeek()
    {
        $current_date = Carbon::now()->format('Y-m-d');
        $result = $this->select(DB::raw('count(last_counter) AS count'))->whereBetween($this->date_column,
            [Carbon::now()->subWeek()->format('Y-m-d'), $current_date])->get();

        if (!$result->isEmpty()) {
            $result = $result[0]->count;
        }
        return !is_numeric($result) ? 0 : $result;
    }

    public function visitorMonth()
    {
        $current_date = Carbon::now()->format('Y-m-d');
        $result = $this->select(DB::raw('count(last_counter) AS count'))->whereBetween($this->date_column,
            [Carbon::now()->subMonth()->format('Y-m-d'), $current_date])->get();

        if (!$result->isEmpty()) {
            $result = $result[0]->count;
        }
        return !is_numeric($result) ? 0 : $result;
    }

    public function visitorYear()
    {
        $current_date = Carbon::now()->format('Y-m-d');
        $result = $this->select(DB::raw('count(last_counter) AS count'))->whereBetween($this->date_column,
            [Carbon::now()->subYear()->format('Y-m-d'), $current_date])->get();

        if (!$result->isEmpty()) {
            $result = $result[0]->count;
        }
        return !is_numeric($result) ? 0 : $result;
    }

    public function visitorTotal()
    {
        $result = $this->select(DB::raw('count(last_counter) AS count'))->get();


        if (!$result->isEmpty()) {
            $result = $result[0]->count;
        }
        return !is_numeric($result) ? 0 : $result;
    }

    public function mapVisitors($date)
    {
        $data = array();
        foreach ($date as $dt) {
            $the_count = $this->select(DB::raw('count(last_counter) AS count'))->where('last_counter', $dt)
                ->orderBy('last_counter')->groupBy('last_counter')->get();
            if (!$the_count->isEmpty())
                $data[] = $the_count[0]->count;
            else
                $data[] = 0;

        }
        return $data;
    }

//    public function getBrowserData(){
//        $browsers = $this->select(DB::raw('Distinct(broswer)'))
//    }

}
