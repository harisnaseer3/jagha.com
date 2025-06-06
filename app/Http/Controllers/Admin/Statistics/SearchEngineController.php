<?php

namespace App\Http\Controllers\Admin\Statistics;

use App\Classes\Referred;
use App\Events\LogErrorEvent;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchEngineController extends Controller
{
    /**
     * Default error not founding search engine
     *
     * @var string
     */
    public static $error_found = 'No search query found!';

    public static function getByUrl($url = false)
    {

        // If no URL was passed in, get the current referrer for the session.
        if (!$url) {
            $url = !empty(\request()->server('HTTP_REFERER')) ? Referred::get() : false;
        }

        // If there is no URL and no referrer, always return false.
        if ($url == false) {
            return false;
        }

        // Parse the URL in to it's component parts.
        $parts = @parse_url($url);

        // Get the list of search engines we currently support.
        $search_engines = self::getList();

        // Loop through the SE list until we find which search engine matches.
        foreach ($search_engines as $key => $value) {
            $search_regex = self::regex($key);
            $host = isset($parts['host']) ? $parts['host'] : '';

            preg_match('/' . $search_regex . '/', $host, $matches);
            if (isset($matches[1])) {
                // Return the first matched SE.
                return $value;
            }
        }

        // If no SE matched, return some defaults.
        return self::default_engine();
    }

    /**
     * Get base assets url search engine logo
     *
     * @return string
     */
    public static function Asset()
    {
        return asset('img/search-engine/');
    }

    /**
     * Get List Of Search engine
     *
     * @param bool $all
     * @return array
     */
    public static function getList($all = false)
    {

        // List OF Search engine
        $default = $engines = array(
            'ask' => array(
                'name' => 'Ask.com',
                'translated' => 'Ask.com',
                'tag' => 'ask',
                'sqlpattern' => '%ask.com%',
                'regexpattern' => 'ask\.com',
                'querykey' => 'q',
                'image' => 'ask.png',
                'logo_url' => self::Asset() . 'ask.png'
            ),
            'baidu' => array(
                'name' => 'Baidu',
                'translated' => 'Baidu',
                'tag' => 'baidu',
                'sqlpattern' => '%baidu.com%',
                'regexpattern' => 'baidu\.com',
                'querykey' => 'wd',
                'image' => 'baidu.png',
                'logo_url' => self::Asset() . 'baidu.png'
            ),
            'bing' => array(
                'name' => 'Bing',
                'translated' => 'Bing',
                'tag' => 'bing',
                'sqlpattern' => '%bing.com%',
                'regexpattern' => 'bing\.com',
                'querykey' => 'q',
                'image' => 'bing.png',
                'logo_url' => self::Asset() . 'bing.png'
            ),
            'clearch' => array(
                'name' => 'clearch.org',
                'translated' => 'clearch.org',
                'tag' => 'clearch',
                'sqlpattern' => '%clearch.org%',
                'regexpattern' => 'clearch\.org',
                'querykey' => 'q',
                'image' => 'clearch.png',
                'logo_url' => self::Asset() . 'clearch.png'
            ),
            'duckduckgo' => array(
                'name' => 'DuckDuckGo',
                'translated' => 'DuckDuckGo',
                'tag' => 'duckduckgo',
                'sqlpattern' => array('%duckduckgo.com%', '%ddg.gg%'),
                'regexpattern' => array('duckduckgo\.com', 'ddg\.gg'),
                'querykey' => 'q',
                'image' => 'duckduckgo.png',
                'logo_url' => self::Asset() . 'duckduckgo.png'
            ),
            'google' => array(
                'name' => 'Google',
                'translated' => 'Google',
                'tag' => 'google',
                'sqlpattern' => '%google.%',
                'regexpattern' => 'google\.',
                'querykey' => 'q',
                'image' => 'google.png',
                'logo_url' => self::Asset() . 'google.png'
            ),
            'yahoo' => array(
                'name' => 'Yahoo!',
                'translated' => 'Yahoo!',
                'tag' => 'yahoo',
                'sqlpattern' => '%yahoo.com%',
                'regexpattern' => 'yahoo\.com',
                'querykey' => 'p',
                'image' => 'yahoo.png',
                'logo_url' => self::Asset() . 'yahoo.png'
            ),
            'yandex' => array(
                'name' => 'Yandex',
                'translated' => 'Yandex',
                'tag' => 'yandex',
                'sqlpattern' => '%yandex.ru%',
                'regexpattern' => 'yandex\.ru',
                'querykey' => 'text',
                'image' => 'yandex.png',
                'logo_url' => self::Asset() . 'yandex.png'
            ),
            'qwant' => array(
                'name' => 'Qwant',
                'translated' => 'Qwant',
                'tag' => 'qwant',
                'sqlpattern' => '%qwant.com%',
                'regexpattern' => 'qwant\.com',
                'querykey' => 'q',
                'image' => 'qwant.png',
                'logo_url' => self::Asset() . 'qwant.png'
            )
        );

//        if ($all == false) {
//            foreach ($engines as $key => $engine) {
//                if (Option::get('disable_se_' . $engine['tag'])) {
//                    unset($engines[$key]);
//                }
//            }
//
//            // If we've disabled all the search engines, reset the list back to default.
//            if (count($engines) == 0) {
//                $engines = $default;
//            }
//        }

        return $engines;
    }

    /**
     * Get Search Engine Regex From List
     *
     * @param string $search_engine
     * @return string
     */
    public static function regex($search_engine = 'all')
    {

        // Get a complete list of search engines
        $search_engine_list = self::getList();
        $search_query = '';

        // Are we getting results for all search engines or a specific one?
        if (strtolower($search_engine) == 'all') {
            foreach ($search_engine_list as $se) {
                if (is_array($se['regexpattern'])) {
                    foreach ($se['regexpattern'] as $subse) {
                        $search_query .= "{$subse}|";
                    }
                } else {
                    $search_query .= "{$se['regexpattern']}|";
                }
            }

            // Trim off the last '|' for the loop above.
            $search_query = substr($search_query, 0, strlen($search_query) - 1);
        } else {
            if (is_array($search_engine_list[$search_engine]['regexpattern'])) {
                foreach ($search_engine_list[$search_engine]['regexpattern'] as $se) {
                    $search_query .= "{$se}|";
                }

                // Trim off the last '|' for the loop above.
                $search_query = substr($search_query, 0, strlen($search_query) - 1);
            } else {
                $search_query .= $search_engine_list[$search_engine]['regexpattern'];
            }
        }

        return "({$search_query})";
    }

    /**
     * Return Default Value if Search Engine Not Exist
     *
     * @return array
     */
    public static function default_engine()
    {
        return array(
            'name' => 'Unknown',
            'tag' => '',
            'sqlpattern' => '',
            'regexpattern' => '',
            'querykey' => 'q',
            'image' => 'unknown.png',
            'logo_url' => self::Asset() . 'unknown.png'
        );
    }

    /**
     * Parses a URL from a referrer and return the search query words used.
     *
     * @param bool|false $url
     * @return bool|string
     */
    public static function getByQueryString($url = false)
    {

        // Get Referred Url
        $referred_url = Referred::getRefererURL();

        // If no URL was passed in, get the current referrer for the session.
        if (!$url) {
            $url = ($referred_url == "" ? false : $referred_url);
        }

        // If there is no URL and no referrer, always return false.
        if ($url == false) {
            return false;
        }

        // Parse the URL in to it's component parts.
        $parts = @parse_url($url);

        // Check query exist
        if (array_key_exists('query', $parts)) {
            parse_str($parts['query'], $query);
        } else {
            $query = array();
        }

        // Get the list of search engines we currently support.
        $search_engines = self::getList();

        // Loop through the SE list until we find which search engine matches.
        foreach ($search_engines as $key => $value) {
            $search_regex = self::regex($key);
            $host = isset($parts['host']) ? $parts['host'] : '';
            preg_match('/' . $search_regex . '/', $host, $matches);
            if (isset($matches[1])) {
                if (array_key_exists($search_engines[$key]['querykey'], $query)) {
                    $words = strip_tags($query[$search_engines[$key]['querykey']]);
                } else {
                    $words = '';
                }

                return ($words == "" ? self::$error_found : $words);
            }
        }

        return self::$error_found;
    }

    /**
     * Record Search Engine
     *
     * @param array $arg
     */
    public static function record($arg = array())
    {

        // Define the array of defaults
        $defaults = array(
            'visitor_id' => 0
        );
        $args = (new \App\Helpers\WPHelper)->my_parse_args($arg, $defaults);

        // Check Exist Visitor ID
        if ($args['visitor_id'] > 0) {
            $search_engines = self::getList();
            $referred = Referred::get();

            // Check Validate Url
            if (preg_match('/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/', $referred)) {

                // Parse Url and Check Search Engine Match regex
                $parts = @parse_url($referred);

                // Loop through the SE list until we find which search engine matches.
                foreach ($search_engines as $key => $value) {
                    $host = isset($parts['host']) ? $parts['host'] : '';

                    // Check find Regex
                    $search_regex = self::regex($key);
                    preg_match('/' . $search_regex . '/', $host, $matches);
                    if (isset($matches[1])) {
                        // Prepare Search Word Data
                        $search_word = array(
                            'last_counter' => Carbon::now()->format('Y-m-d'),
                            'engine' => $key,
                            'words' => (SearchEngineController::getByQueryString($referred) == self::$error_found ? '' : SearchEngineController::getByQueryString($referred)),
                            'host' => $host,
                            'visitor' => $args['visitor_id'],
                        );

                        // Save To DB
                        self::save_word($search_word);
                    }
                }
            }
        }
    }

    /**
     * Added new Search Word record to DB
     *
     * @param array $data
     */
    public static function save_word($data = array())
    {
        # Save to Database
        try {
            DB::connection('mysql2')->table('search')->insert($data);
        } catch (\Exception $e) {
            event(new LogErrorEvent($e->getMessage(), 'Error in search engine controller save_word method.'));

        }
    }
}
