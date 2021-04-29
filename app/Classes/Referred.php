<?php


namespace App\Classes;


use App\Helpers\WPHelper;
use App\Http\Controllers\Admin\Statistics\SearchEngineController;
use App\Http\Controllers\Admin\Statistics\VisitorController;
use App\Http\Controllers\CountryController;
use App\Models\Log\LogVisitor;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use IpLocation;

class Referred
{
    /**
     * Top Referring Transient name
     *
     * @var string
     */
    public static $referrer_spam_link = 'https://raw.githubusercontent.com/matomo-org/referrer-spam-blacklist/master/spammers.txt';

    public static function getRefererURL()
    {
        return (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '');
//        $http_referer = \request()->server('HTTP_REFERER');
//        return (isset($http_referer) ? $http_referer : '');
    }

    /**
     * Return the referrer link for the current user.
     *
     * @return array|bool|string
     */
    public static function get()
    {
        // Get Default
        $referred = self::getRefererURL();

        // Sanitize Referer Url
//        $referred = DB::connection('mysql2')->getPdo()->quote(strip_tags($referred));

        // If Referer is Empty then use same WebSite Url
        if (empty($referred)) {
            $referred ='https://property.aboutpakistan.com/';
        }
        if($referred == '')
            $referred = 'https://property.aboutpakistan.com/';

        // Check Search Engine

        // Check to see if this is a search engine referrer
        $SEInfo = SearchEngineController::getByUrl($referred);
//        if (is_array($SEInfo)) {
//
//            // If we're a known SE, check the query string
//            if ($SEInfo['tag'] != '') {
//                $result = SearchEngineController::getByQueryString($referred);
//
//                // If there were no search words, let's add the page title
//                if ($result == '' || $result == SearchEngineController::$error_found) {
////                    $result = wp_title('', false);
////                    $result = env('APP_URL');
//                    //TODO: Add page title
//                    if ($result != '') {
//                        $referred = add_query_arg($SEInfo['querykey'], urlencode('~"' . $result . '"'), $referred);
//                        $referred = $result;
//                    }
//                }
//            }
//
//        }
        return $referred;
    }

    public static function get_referrer_link($referrer, $title = '', $is_blank = true)
    {

        // Sanitize Link
        $html_referrer = self::html_sanitize_referrer($referrer);

        // Check Url Protocol
        if (!self::check_url_scheme($html_referrer)) {
            $html_referrer = '//' . $html_referrer;
        }

        // Parse Url
        $base_url = @parse_url($html_referrer);

        // Get Page title
        $title = (trim($title) == "" ? $html_referrer : $title);

        // Get Html Link
        return "<a href='{$html_referrer}' title='{$title}' " . ($is_blank === true ? ' target="_blank"' : '') . ">{$base_url['host']}</a>";
    }

    /**
     * Sanitizes the referrer
     *
     * @param     $referrer
     * @param int $length
     * @return string
     */
    public static function html_sanitize_referrer($referrer, $length = -1)
    {
        $referrer = trim($referrer);

        if ('data:' == strtolower(substr($referrer, 0, 5))) {
            $referrer = 'http://127.0.0.1';
        }

        if ('javascript:' == strtolower(substr($referrer, 0, 11))) {
            $referrer = 'http://127.0.0.1';
        }

        if ($length > 0) {
            $referrer = substr($referrer, 0, $length);
        }

        return htmlentities($referrer, ENT_QUOTES);
    }

    public static function check_url_scheme($url, $accept = array('http', 'https'))
    {
        $scheme = @parse_url($url, PHP_URL_SCHEME);
        return in_array($scheme, $accept);
    }

    /**
     * Get Top Referring Site
     *
     * @param int $number
     * @return array
     * @throws \Exception
     */
    public static function getTop($number = 10)
    {

        $result = self::GenerateReferSQL();
        foreach ($result as $items) {
            $get_urls[$items->domain] = self::get_referer_from_domain($items->domain);
        }

        // Return Data

        return self::PrepareReferData($get_urls);
    }

    /**
     * Prepare Refer Data
     *
     * @param $get_urls
     * @return array
     * @throws \Exception
     */
    public static function PrepareReferData($get_urls)
    {

        //Prepare List
        $list = array();

        //Load country Code
        $ISOCountryCode = (new Countries)->list();
//
        if (!$get_urls) {
            return array();
        }
        // Check List
        foreach ($get_urls as $domain => $number) {

            //Get Site Link
            $referrer_html = Referred::html_sanitize_referrer($domain);

            $get_site_inf = Referred::get_domain_server($domain);
//            $get_site_title = WPHelper::get_site_title_by_url($domain);
            $get_site_title = false;
            $referrer_list[$domain] = array(
                'ip' => $get_site_inf['ip'],
                'country' => $get_site_inf['country'],
                'title' => ($get_site_title === false ? '' : $get_site_title),
            );
            // Push to list
            $list[] = array(
                'domain' => $domain,
                'title' => $referrer_list[$domain]['title'],
                'ip' => ($referrer_list[$domain]['ip'] != "" ? $referrer_list[$domain]['ip'] : '-'),
                'country' => ($referrer_list[$domain]['country'] != "" ? $ISOCountryCode[$referrer_list[$domain]['country']] : ''),
//                'flag' => ($referrer_list[$domain]['country'] != "" ? Country::flag($referrer_list[$domain]['country']) : ''),
                'number' => number_format($number[0]->count)
            );
        }
        // Return Data
        return $list;
    }

    /**
     * Generate Basic SQL Refer List and return before get
     *
     *
     */

    /**
     * Get WebSite IP Server And Country Name
     *
     * @param $url string domain name e.g : wp-statistics.com
     * @return array
     * @throws \Exception
     */
    public static function get_domain_server($url)
    {

        //Create Empty Object
        $result = array('ip' => '', 'country' => '');

        //Get Ip by Domain
        if (function_exists('gethostbyname')) {

            // Get Host Domain
            $ip = gethostbyname($url);

            // Check Validate IP
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                $result['ip'] = $ip;
                $country = '';
                if ($ip_location = IpLocation::get($ip)) {
                    $country = $ip_location->countryCode;
                    if ($country == null)
                        $country = (new CountryController())->country_code($ip);
                } else {
                    $country = 'Unknown';
                }
                $result['country'] = $country;
            }
        }

        return $result;
    }

    public static function GenerateReferSQL()
    {
        // Check Protocol Of domain
//        $domain_name = rtrim(preg_replace('/^https?:\/\//', '', get_site_url()), " / ");
        $domain_name = rtrim(preg_replace('/^https?:\/\//', '', 'https://property.aboutpakistan.com'), " / ");
        foreach (array("http", "https", "ftp") as $protocol) {
            foreach (array('', 'www.') as $w3) {
                $where = " AND `referred` NOT LIKE '{$protocol}://{$w3}{$domain_name}%' ";
            }
        }
        $sql_query = DB::connection('mysql2')->select("SELECT SUBSTRING_INDEX(REPLACE( REPLACE( referred, 'http://', '') , 'https://' , '') , '/', 1 ) as `domain`, count(referred) as `number` FROM `visitor`  WHERE `referred` REGEXP \"^(https?://|www\\.)[\.A-Za-z0-9\-]+\\.[a-zA-Z]{2,4}\" AND `referred` <> '' AND LENGTH(referred) >=12 " . $where . " GROUP BY domain ORDER BY `number` DESC");
        // Return SQL
        return $sql_query;
    }

    /**
     * Get Number Referer Domain
     *
     * @param $url
     * @param string $type [list|number]
     * @param array $time_rang
     * @param null $limit
     * @return array
     * @throws \Exception
     */
    public static function get_referer_from_domain($url, $type = 'number', $time_rang = array(), $limit = null)
    {
        //Get Domain Name
        $search_url = WPHelper::get_domain_name($url);

        //Prepare SQL
        $time_sql = '';
        if (count($time_rang) > 0 and !empty($time_rang)) {
            $time_sql = sprintf("AND `last_counter` BETWEEN '%s' AND '%s'", $time_rang[0], $time_rang[1]);
        }

        $sql = DB::connection('mysql2')->select("SELECT " . ($type == 'number' ? 'COUNT(*) AS count' : '*') . " FROM `visitor` WHERE `referred` REGEXP \"^(https?://|www\\.)[\.A-Za-z0-9\-]+\\.[a-zA-Z]{2,4}\"
        AND referred <> '' AND LENGTH(referred) >=12 AND (`referred` LIKE  ? OR `referred` LIKE ? OR `referred` LIKE ? OR `referred` LIKE ?) " . $time_sql .
            " ORDER BY `visitor`.`ID` DESC " . ($limit != null ? " LIMIT " . $limit : ""), ['https://www.' . $search_url . '%', 'https://' . $search_url . '%', 'http://www.' . $search_url . '%', 'http://' . $search_url . '%']);


        //Get Count
        return ($type == 'number' ? $sql : (new \App\Http\Controllers\Admin\Statistics\VisitorController)->PrepareData($sql));
    }

}
