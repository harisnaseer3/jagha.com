<?php

namespace App\Models\Log;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 * @mixin Builder
 */
class LogPage extends Model
{
    protected $connection = 'mysql2';
    public $table = 'pages';

    public function getTopPages()
    {

        $result = $this->select(DB::raw('SUM(`count`) as count_sum'), 'uri')->groupBy('uri')
            ->orderBy('count_sum', 'desc')->limit('10')->get();


        if (!$result->isEmpty()) {
            return $result;
        } else
            return [];


    }

}
