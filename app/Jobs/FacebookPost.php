<?php

namespace App\Jobs;

use App\Models\Property;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FacebookPost implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $property;

    public function __construct($property)
    {
        $this->property = $property;
    }

    public function handle()
    {
        $token = 'EAADU6kME7ZCIBAFAQjktiIX2qFpLhBRRwCmxfZBCuIXTaeXCfNMGLtOiVD9PmY0sEEZBDv1MYuZBEFlGhLblfdlYnt2ZB5fXdmeX7MENyGD3NcQhNF8Scp2crom4n5vMp9qIlZBZCz5CsjFqZCQZBRaufQrpsWCysxMGljNxAyWFEhALrflsAJREbwAQdlu96fHgZD';

        $fb = new Facebook([
            'app_id' => '234102611832818',
            'app_secret' => '17c51b4cd6934b727435d804658248ed',
            'default_graph_version' => 'v5.0',
        ]);
        $property = DB::table('properties')->where('id', $this->property)
            ->select('id', 'title', 'reference', 'city_id', 'location_id', 'purpose', 'reference', 'area_unit', 'type', 'sub_type', 'purpose', 'land_area')->first();
        $image = DB::table('images')->where('property_id', $this->property)->where('order', 1)->first();
        $city = DB::table('cities')->select('name')->where('id', $property->city_id)->first();
        $location = DB::table('locations')->select('name')->where('id', $property->location_id)->first();
        $link = route('properties.show', [
            'slug' => Str::slug($city->name) . '-' . Str::slug($location->name) . '-' . Str::slug($property->title) . '-' . $property->reference,
            'property' => $property->id]);

        if ($image) {
            if (strpos($image->name, '.webp') !== false) {

                $absolute_image_path = base_path('thumbnails/properties/' . explode('.', $image->name)[0] . '-450x350.webp');

            } else {
                $absolute_image_path = base_path('thumbnails/properties/' . $image->name . '-450x350.webp');

            }
        } else {
            $absolute_image_path = base_path('img\logo\dummy-logo.png');
        }
        $source = $fb->fileToUpload($absolute_image_path);


        $user_message = intval($property->land_area) . ' ' . $property->area_unit . ' Beautiful ' . $property->sub_type . ' for ' . $property->purpose . ' in a peaceful and prime location of ' . $location->name . ', ' . $city->name . '.' .
            PHP_EOL . 'See price & details here: ' . $link .
            PHP_EOL . PHP_EOL . 'Search with Property ID: ' . $property->id;


        $linkData = [
            'message' => $user_message,
            'source' => $source
        ];
        $page_id = '906497989423481';
        try {
            $post = $fb->post(' / ' . $page_id . ' / photos', $linkData, $token);
            $post = $post->getGraphNode()->asArray();
            echo 'Facebook Post Successfully Created . ';
            print_r($post);

        } catch (FacebookSDKException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
//            exit;
        }


    }
}