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
    protected $fillable = [
        'page_id', 'uri', 'type','date','count','id'
    ];

    public function getTopPages()
    {

        $result = $this->select(DB::raw('SUM(`count`) as count_sum'),'uri','type')->groupBy('uri','type')
            ->orderBy('count_sum', 'desc')->get();




        if (!$result->isEmpty()) {
            return $result;
        } else
            return [];


    }

}
