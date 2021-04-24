<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Referring;
use App\Http\Controllers\Admin\Statistics\CountryController;
use App\Http\Controllers\Admin\Statistics\PlatformController;
use App\Http\Controllers\Admin\Statistics\ReferringSiteController;
use App\Http\Controllers\Admin\Statistics\VisitorController;
use App\Http\Controllers\Controller;
use App\Models\Log\LogVisit;
use App\Models\Log\LogVisitor;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $admin = Auth::guard('admin')->user();
        return view('website.admin-pages.statistic', [
            'admin' => $admin,
            'visit' => [
                'today' => (new \App\Models\Log\LogVisit)->visitToday(),
                'yesterday' => (new \App\Models\Log\LogVisit)->visitYesterday(),
                'week' => (new \App\Models\Log\LogVisit)->visitWeek(),
                'month' => (new \App\Models\Log\LogVisit)->visitMonth(),
                'year' => (new \App\Models\Log\LogVisit)->visitYear(),
                'total' => (new \App\Models\Log\LogVisit)->visitTotal()],
            'visitor' => [
                'today' => (new \App\Models\Log\LogVisitor)->visitorToday(),
                'yesterday' => (new \App\Models\Log\LogVisitor)->visitorYesterday(),
                'week' => (new \App\Models\Log\LogVisitor)->visitorWeek(),
                'month' => (new \App\Models\Log\LogVisitor)->visitorMonth(),
                'year' => (new \App\Models\Log\LogVisitor)->visitorYear(),
                'total' => (new \App\Models\Log\LogVisitor)->visitorTotal()
            ],


        ]);
    }

    public function getHitStatistic(Request $request)
    {
        if ($request->ajax()) {
            $visits = $date = $visitors = array();


            $to = $request->has('to') ? $request->to : null;
            $from = $request->has('from') ? $request->from : null;

            $time = $request->has('time') ? $request->time : null;
            if (null !== $time) {
                $limit = $this->getToFrom($time);
                $from = $limit[0];
                $to = $limit[1];
            }


            if (null == $to && null == $from || $time == 'month') {
                $date = $this->customDateArray();
                $visits = (new \App\Models\Log\LogVisit)->mapVisits($date[1]);
                $visitors = (new \App\Models\Log\LogVisitor)->mapVisitors($date[1]);
            } else if ($this->validateDate($to) && $this->validateDate($from)) {
                $date = $this->customDateArray($from, $to);
                $visits = (new \App\Models\Log\LogVisit)->mapVisits($date[1]);
                $visitors = (new \App\Models\Log\LogVisitor)->mapVisitors($date[1]);
            }


            return response()->json(['data' => ['visits' => $visits, 'visitors' => $visitors, 'date' => $date[0]], 'status' => 200]);
        } else {
            return 'Not Found';
        }

    }

    private function getToFrom($time)
    {
        $current_date = Carbon::now()->format('Y-m-d');
        if ($time == 'week') {
            return [Carbon::now()->subWeek()->format('Y-m-d'), $current_date];
        }
        if ($time == 'year') {
            return [Carbon::now()->subYear()->format('Y-m-d'), $current_date];
        }
        if ($time == 'month') {
            return [Carbon::now()->submonth()->format('Y-m-d'), $current_date];
        }
    }

    private function customDateArray($start = null, $end = null): array
    {
        $dates = $fullDates = array();
        if ($start == null && $end == null) {
            $start = Carbon::now()->startOfMonth()->format('Y-m-d');
            $end = Carbon::now()->format('Y-m-d');
        }

        $period = CarbonPeriod::create($start, $end);

        // Iterate over the period
        foreach ($period as $date) {
            $dates[] = $date->format('M-d');
            $fullDates[] = $date->format('Y-m-d');
        }

        return [$dates, $fullDates];
    }

    private function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;

    }

    public function getTopPages()
    {
        $top_pages = (new \App\Models\Log\LogPage())->getTopPages();
        $data['view'] = View('website.admin-pages.components.top-pages',
            ['top_pages' => $top_pages])->render();
        return $data;
    }

    public function getTopBrowser()
    {

    }

    public function getTopCountries()
    {
        $args = array();
        $args['limit'] = 20;

        $countries = (new CountryController())->get($args);
        $data['view'] = View('website.admin-pages.components.top-countries',
            ['top_countries' => $countries])->render();
        return $data;

    }

    public function getTopVisitors()
    {
        $args = array();
        $args['limit'] = 20;

        $visitors = (new VisitorController())->get($args);


        $data['view'] = View('website.admin-pages.components.top-visitors',
            ['top_visitors' => $visitors])->render();
        return $data;

    }

    public function getRecentVisitors()
    {
        $args = array();
        $args['limit'] = 20;

        $visitors = (new VisitorController())->getRecentVisitor($args);


        $data['view'] = View('website.admin-pages.components.recent-visitors',
            ['recent_visitors' => $visitors])->render();
        return $data;

    }

    public function getReferringSite()
    {
        $args = array();
        $args['limit'] = 20;


        $sites = (new ReferringSiteController())::get($args);


        $data['view'] = View('website.admin-pages.components.top-referring-site',
            ['sites' => $sites])->render();
        return $data;

    }

    public function getTopPlatForm(Request $request)
    {
        if ($request->ajax()) {
            $args = array();
            $args['number'] = 20;

            $to = $request->has('to') ? $request->to : null;
            $from = $request->has('from') ? $request->from : null;

            $time = $request->has('time') ? $request->time : null;
            if (null !== $time) {
                $limit = $this->getToFrom($time);
                $from = $limit[0];
                $to = $limit[1];
            }
            $args['to'] = $to;
            $args['from'] = $from;


            try {

                $platforms = (new PlatformController)::getTop($args);
            } catch (\Exception $e) {
                return response()->json(['data' => ['platforms' => array(), 'status' => 201]]);
            }


            return response()->json(['data' => ['platforms' => $platforms, 'status' => 200]]);
        } else {
            return 'Not Found';
        }
    }


}
