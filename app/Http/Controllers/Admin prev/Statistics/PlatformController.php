<?php

namespace App\Http\Controllers\Admin\Statistics;

use app\Helpers\WPHelper;
use App\Http\Controllers\Controller;
use App\Models\Log\LogVisitor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Self_;
use Spatie\SchemaOrg\Car;

class PlatformController extends Controller
{
    /**
     * Get Platforms Chart
     *
     * @param array $arg
     * @return array
     * @throws \Exception
     */
    public static function getTop($arg = array())
    {

        // Set Default Params
        $defaults = array(
//            'ago'    => 0,
            'from' => '',
            'to' => '',
            'order' => '',
            'number' => 10 // Get Max number of platform
        );

        $args = (new \App\Helpers\WPHelper)->my_parse_args($arg, $defaults);


        // Set Default Value
        $total = $count = 0;
        $lists_value = $lists_name = $lists_values = array();


        $d = Carbon::now()->format('Y-m-d');
        $list = (new LogVisitor())->select(DB::raw('Count(*) AS count'), 'platform');

        if ($args['to'] == null && $args['from'] == null) {
            $list = $list->where('last_counter', $d);
        } elseif ($args['to'] != null && $args['from'] != null) {
            $list = $list->whereBetween('last_counter', [$args['from'], $args['to']]);
        }


        $list = $list->groupBy('platform')->get()->toArray();

        // Sort By Count
        WPHelper::SortByKeyValue($list, 'count');

        // Get Last 10 Version that Max number
        $platforms = array_slice($list, 0, $args['number']);

        // Push to array
        foreach ($platforms as $l) {

            if (trim($l['platform']) != "") {
                $platform = trim(preg_replace('![\d+] ?(.*)!', '', $l['platform']));

                if (!in_array($platform, $lists_name)) {

                    // Sanitize Version name
                    $lists_name[] = $platform;

                    // Get List Count
                    $lists_value[] = (int)$l['count'];
                } else {
                    foreach ($lists_name as $key1 => $value1) {
                        if ($value1 == $platform) // not satisfying this condition
                        {
                            $lists_value[$key1] = $lists_value[$key1] + (int)$l['count'];
                        }
                    }
                }


                // Add to Total
                $total += $l['count'];
            }
        }

        // Prepare Response
        $response = array(
//            'days'           => $count_day,
//            'from'           => reset($days_time_list),
//            'to'             => end($days_time_list),
//            'type'           => (($args['from'] != "" and $args['to'] != "") ? 'between' : 'ago'),
//            'title'          => $title,
            'platform_name' => $lists_name,
            'platform_value' => $lists_value,
//            'info'           => array(
//                'visitor_page' => Menus::admin_url('visitors')
//            ),
            'total' => $total
        );

        // Check For No Data Meta Box
        if (count(array_filter($lists_value)) < 1 and !isset($args['no - data'])) {
            $response = array();
        }

        // Response
        return $response;
    }


}
