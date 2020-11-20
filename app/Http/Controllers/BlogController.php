<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\Blog;
use App\Models\Property;
use Illuminate\Contracts\Foundation\Application as ApplicationAlias;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BlogController extends Controller
{
//    display total 9 of blogs on listing page of blogs
    public function index()
    {
        (new MetaTagController())->addMetaTagsOnBlog();

        $result = DB::connection('mysql2')->select('SELECT `t1`.*, `t2`.`image` FROM (
                    SELECT `wp_posts`.`ID` AS `id`, `wp_terms`.`name` AS `category`,`post_title`, `wp_users`.`display_name` AS `author`, `post_date`, \'medical\' AS `source`, `post_content`
                    FROM `wp_posts`
                        LEFT JOIN `wp_term_relationships` ON `wp_posts`.`ID` = `wp_term_relationships`.`object_id`
                        LEFT JOIN `wp_term_taxonomy` ON `wp_term_relationships`.`term_taxonomy_id` = `wp_term_taxonomy`.`term_taxonomy_id`
                        LEFT JOIN `wp_terms`  ON `wp_terms`.`term_id` = `wp_term_taxonomy`.`term_id`
                        JOIN `wp_users` ON `wp_posts`.`post_author` = `wp_users`.`ID`
                    WHERE `wp_term_taxonomy`.`taxonomy` = \'category\' AND  `wp_terms`.`name` = \'Property\'  AND `wp_posts`.`post_type` = \'post\'
                    GROUP BY `wp_posts`.`ID`
                ) `t1`
                JOIN (
                    SELECT `wp_posts`.`ID` AS `id`, `pm2`.`meta_value` AS `image`
                    FROM `wp_posts`
                        INNER JOIN `wp_postmeta` AS pm1 ON `wp_posts`.`id` = `pm1`.`post_id` AND `pm1`.`meta_key` = \'_thumbnail_id\'
                        INNER JOIN `wp_postmeta` AS pm2 ON `pm1`.`meta_value` = `pm2`.`post_id` AND `pm2`.`meta_key` = \'_wp_attached_file\'
                ) `t2` ON `t1`.`id` = `t2`.`id`
                ORDER BY `t1`.`post_date` DESC LIMIT 9');

        $footer_content = (new FooterController())->footerContent();
        $data = [
            'results' => $result,
            'blog_organization' => (new MetaTagController())->addScriptJsonldOnBlogOrganization(),
            'blog_website' => (new MetaTagController())->addscriptJsonldWebsite(),
            'recent_properties' => $footer_content[0],
            'footer_agencies' => $footer_content[1],
        ];
        return view('website.pages.blogs.blog_listing', $data);
    }

    /* display detail blog on page*/
    public function show($slug, $id)
    {

        $result = DB::connection('mysql2')->select('SELECT `t1`.*, `t2`.`image` FROM (
                    SELECT `wp_posts`.`ID` AS `id`, `wp_terms`.`name` AS `category`,`post_title`, `wp_users`.`display_name` AS `author`, `post_date`, \'medical\' AS `source`, `post_content`
                    FROM `wp_posts`
                        LEFT JOIN `wp_term_relationships` ON `wp_posts`.`ID` = `wp_term_relationships`.`object_id`
                        LEFT JOIN `wp_term_taxonomy` ON `wp_term_relationships`.`term_taxonomy_id` = `wp_term_taxonomy`.`term_taxonomy_id`
                        LEFT JOIN `wp_terms`  ON `wp_terms`.`term_id` = `wp_term_taxonomy`.`term_id`
                        JOIN `wp_users` ON `wp_posts`.`post_author` = `wp_users`.`ID`
                    WHERE `wp_term_taxonomy`.`taxonomy` = \'category\' AND  `wp_terms`.`name` = \'Property\'  AND `wp_posts`.`post_type` = \'post\'
                    GROUP BY `wp_posts`.`ID`
                ) `t1`
                JOIN (SELECT `wp_posts`.`ID` AS `id`, `pm2`.`meta_value` AS `image`
                    FROM `wp_posts`
                        INNER JOIN `wp_postmeta` AS pm1 ON `wp_posts`.`id` = `pm1`.`post_id` AND `pm1`.`meta_key` = \'_thumbnail_id\'
                        INNER JOIN `wp_postmeta` AS pm2 ON `pm1`.`meta_value` = `pm2`.`post_id` AND `pm2`.`meta_key` = \'_wp_attached_file\'
                ) `t2` ON `t1`.`id` = `t2`.`id` WHERE `t1`.`id`  = :id
                ORDER BY `t1`.`post_date` DESC LIMIT 1', ['id' => $id]);


        $similar_result = DB::connection('mysql2')->select('SELECT `t1`.*, `t2`.`image` FROM (
                    SELECT `wp_posts`.`ID` AS `id`, `wp_terms`.`name` AS `category`,`post_title`, `wp_users`.`display_name` AS `author`, `post_date`, \'medical\' AS `source`, `post_content`
                    FROM `wp_posts`
                        LEFT JOIN `wp_term_relationships` ON `wp_posts`.`ID` = `wp_term_relationships`.`object_id`
                        LEFT JOIN `wp_term_taxonomy` ON `wp_term_relationships`.`term_taxonomy_id` = `wp_term_taxonomy`.`term_taxonomy_id`
                        LEFT JOIN `wp_terms`  ON `wp_terms`.`term_id` = `wp_term_taxonomy`.`term_id`
                        JOIN `wp_users` ON `wp_posts`.`post_author` = `wp_users`.`ID`
                    WHERE `wp_term_taxonomy`.`taxonomy` = \'category\' AND  `wp_terms`.`name` = \'Property\'  AND `wp_posts`.`post_type` = \'post\'
                    GROUP BY `wp_posts`.`ID`
                ) `t1`
                JOIN (SELECT `wp_posts`.`ID` AS `id`, `pm2`.`meta_value` AS `image`
                    FROM `wp_posts`
                        INNER JOIN `wp_postmeta` AS pm1 ON `wp_posts`.`id` = `pm1`.`post_id` AND `pm1`.`meta_key` = \'_thumbnail_id\'
                        INNER JOIN `wp_postmeta` AS pm2 ON `pm1`.`meta_value` = `pm2`.`post_id` AND `pm2`.`meta_key` = \'_wp_attached_file\'
                ) `t2` ON `t1`.`id` = `t2`.`id` WHERE `t1`.`id`  <> :id ORDER BY `t1`.`post_date` DESC LIMIT 3', ['id' => $id]);
        $footer_content = (new FooterController)->footerContent();
        $data = [
            'result' => $result,
            'tags' => (new MetaTagController)->addMetaTagsOnDetailBlog($result),
            'blog_organization' => (new MetaTagController)->addScriptJsonldOnBlogOrganization(),
            'similar_results' => $similar_result,
            'recent_properties' => $footer_content[0],
            'footer_agencies' => $footer_content[1],
        ];
        return view('website.pages.blogs.blog_detail', $data);
    }

    public function more_data(Request $request)
    {
        if ($request->ajax()) {
            $more_results = [];
            if ($request->id > 0) {
                $prev_id = $request->input('id');
                $more_results = DB::connection('mysql2')->select('SELECT `t1`.*, `t2`.`image` FROM (
                    SELECT `wp_posts`.`ID` AS `id`, `wp_terms`.`name` AS `category`,`post_title`, `wp_users`.`display_name` AS `author`, `post_date`, \'medical\' AS `source`, `post_content`
                    FROM `wp_posts`
                        LEFT JOIN `wp_term_relationships` ON `wp_posts`.`ID` = `wp_term_relationships`.`object_id`
                        LEFT JOIN `wp_term_taxonomy` ON `wp_term_relationships`.`term_taxonomy_id` = `wp_term_taxonomy`.`term_taxonomy_id`
                        LEFT JOIN `wp_terms`  ON `wp_terms`.`term_id` = `wp_term_taxonomy`.`term_id`
                        JOIN `wp_users` ON `wp_posts`.`post_author` = `wp_users`.`ID`
                    WHERE `wp_term_taxonomy`.`taxonomy` = \'category\' AND  `wp_terms`.`name` = \'Medical\'  AND `wp_posts`.`post_type` = \'post\'
                    GROUP BY `wp_posts`.`ID`
                ) `t1`
                JOIN (
                    SELECT `wp_posts`.`ID` AS `id`, `pm2`.`meta_value` AS `image`
                    FROM `wp_posts`
                        INNER JOIN `wp_postmeta` AS pm1 ON `wp_posts`.`id` = `pm1`.`post_id` AND `pm1`.`meta_key` = \'_thumbnail_id\'
                        INNER JOIN `wp_postmeta` AS pm2 ON `pm1`.`meta_value` = `pm2`.`post_id` AND `pm2`.`meta_key` = \'_wp_attached_file\'
                ) `t2` ON `t1`.`id` = `t2`.`id` where `t1`.`id` < :id   ORDER BY `t1`.`post_date` DESC LIMIT 9', ['id' => $prev_id]);
            }

            $html = '';
            $last_id = '';
            if (!empty($more_results)) {
                foreach ($more_results as $key => $value) {
                    $html .=
                        '<div class="col-lg-4 col-md-6">' .
                        '     <div class="blog-3">' .
                        '       <div class="blog-photo">' .
                        '           <a href="' . route('blogs.show', [\Illuminate\Support\Str::slug($value->post_title), $value->id]) . '"><img src="' . asset('img/blogs/' . $value->image) . '" alt="blog" class="img-fluid"></a>' .
                        '       <div class="date-box">' .
                        '          <span>' . date_format(date_create($value->post_date), "d") . '</span>' . date_format(date_create($value->post_date), "M") .
                        '       </div>' .
                        '       </div>' .
                        '     <div class="post-meta" >' .
                        '         <ul>' .
                        '            <li class="profile-user" >' .
                        '               <img src = "' . asset('website/img/avatar/user.png') . '" alt = "user-blog" style = "max-height: 35px; max-width: 35px; margin-top: 0" >' .
                        '            </li>' .
                        '            <li> By <span>' . $value->author . '</span></li>' .
                        '        </ul>' .
                        '    </div>' .
                        '   <div class="caption detail blog-detail" >' .
                        '   <h4 ><a href ="' . route('blogs.show', [\Illuminate\Support\Str::slug($value->post_title), $value->id]) . '" >' . \Illuminate\Support\Str::limit(strip_tags($value->post_title), 69, $end = '...') . '</a></h4>' .
                        '      <p>' . \Illuminate\Support\Str::limit(strip_tags($value->post_content), 74, $end = '...') . '</p>' .
                        '    </div>' .
                        ' </div >' .
                        '</div >';
                    $last_id = $value->id;
                }
                $data = [
                    'html' => $html,
                    'last_id' => $last_id
                ];
                return response()->json(['data' => $data, 'status' => 200]);
            }
            return response()->json(['data' => 'no more results found', 'status' => 201]);
        } else
            return 'not found';
    }

    public function recentBlogsOnMainPage(Request $request)
    {

        $blogs = $request->input('result');





//        $blogs = DB::connection('mysql2')->select('SELECT `t1`.*, `t2`.`image` FROM (
//                    SELECT `wp_posts`.`ID` AS `id`, `wp_terms`.`name` AS `category`,`post_title`,SUM(`wp_statistics_pages`.`count`) AS `view_count`, `wp_users`.`display_name` AS `author`, `post_date`, \'medical\' AS `source`, `post_content`
//                    FROM `wp_posts`
//                        LEFT JOIN `wp_term_relationships` ON `wp_posts`.`ID` = `wp_term_relationships`.`object_id`
//                        LEFT JOIN `wp_term_taxonomy` ON `wp_term_relationships`.`term_taxonomy_id` = `wp_term_taxonomy`.`term_taxonomy_id`
//                        LEFT JOIN `wp_terms`  ON `wp_terms`.`term_id` = `wp_term_taxonomy`.`term_id`
//                        JOIN `wp_users` ON `wp_posts`.`post_author` = `wp_users`.`ID`
//                        JOIN `wp_statistics_pages` ON `wp_posts`.`ID` = `wp_statistics_pages`.`id`
//                    WHERE `wp_term_taxonomy`.`taxonomy` = \'category\' AND  `wp_terms`.`name` = \'Property\'  AND `wp_posts`.`post_type` = \'post\'
//                    GROUP BY `wp_posts`.`ID`
//                ) `t1`
//                JOIN (
//                    SELECT `wp_posts`.`ID` AS `id`, `pm2`.`meta_value` AS `image`
//                    FROM `wp_posts`
//                        INNER JOIN `wp_postmeta` AS pm1 ON `wp_posts`.`id` = `pm1`.`post_id` AND `pm1`.`meta_key` = \'_thumbnail_id\'
//                        INNER JOIN `wp_postmeta` AS pm2 ON `pm1`.`meta_value` = `pm2`.`post_id` AND `pm2`.`meta_key` = \'_wp_attached_file\'
//                ) `t2` ON `t1`.`id` = `t2`.`id`
//                ORDER BY `t1`.`post_date` DESC LIMIT 9');

        $data['view'] = View('website.components.main-page-blogs',
            [
                'blogs' => $blogs
            ])->render();


        return $data;
    }
}
