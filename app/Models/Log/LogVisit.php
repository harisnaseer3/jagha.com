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
class LogVisit extends Model
{
    protected $connection = 'mysql2';
    public $table = 'visit';

    private $date_column = 'last_counter';


    public function visitToday()
    {
        $result = $this->select('*')->where([$this->date_column => Carbon::now()->format('Y-m-d')])->first();
        if ($result) {
            $result = $result->visit;
        }
        return !is_numeric($result) ? 0 : $result;
    }

    public function visitYesterday()
    {
        $result = $this->select('*')->where([$this->date_column => Carbon::yesterday()->format('Y-m-d')])->first();
        if ($result) {
            $result = $result->visit;
        }
        return !is_numeric($result) ? 0 : $result;
    }

    public function visitWeek()
    {
        $current_date = Carbon::now()->format('Y-m-d');
        $result = $this->select(DB::raw('SUM(visit) AS visit'))->whereBetween($this->date_column,
            [Carbon::now()->subWeek()->format('Y-m-d'), $current_date])->get();

        if (!$result->isEmpty()) {
            $result = $result[0]->visit;
        }
        return !is_numeric($result) ? 0 : $result;
    }

    public function visitMonth()
    {
        $current_date = Carbon::now()->format('Y-m-d');
        $result = $this->select(DB::raw('SUM(visit) AS visit'))->whereBetween($this->date_column,
            [Carbon::now()->subMonth()->format('Y-m-d'), $current_date])->get();

        if (!$result->isEmpty()) {
            $result = $result[0]->visit;
        }
        return !is_numeric($result) ? 0 : $result;
    }

    public function visitYear()
    {
        $current_date = Carbon::now()->format('Y-m-d');
        $result = $this->select(DB::raw('SUM(visit) AS visit'))->whereBetween($this->date_column,
            [Carbon::now()->subYear()->format('Y-m-d'), $current_date])->get();

        if (!$result->isEmpty()) {
            $result = $result[0]->visit;
        }
        return !is_numeric($result) ? 0 : $result;
    }

    public function visitTotal()
    {
        $result = $this->select(DB::raw('SUM(visit) AS visit'))->get();

        if (!$result->isEmpty()) {
            $result = $result[0]->visit;
        }
        return !is_numeric($result) ? 0 : $result;
    }

    // this months visits to show on graph
    public function mapVisits($date)
    {
        $data = array();
        foreach ($date as $dt) {
            $the_count = $this->select('visit')->where('last_counter', $dt)
                ->orderBy('last_counter')->groupBy('last_counter')->get();

            if (!$the_count->isEmpty())
                $data[] = $the_count[0]->visit;
            else
                $data[] = 0;
        }
        return $data;

    }

}
