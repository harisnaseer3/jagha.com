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

    public function __construct(Property $property)
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
        $image = DB::table('images')->where('property_id', $this->property->id)->where('order', 1)->first();

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
        $city = $this->property->city->name;
        $location = $this->property->location->name;

        $link = route('properties.show', [
            'slug' => Str::slug($city) . '-' . Str::slug($location) . '-' . Str::slug($this->property->title) . '-' . $this->property->reference,
            'property' => $this->property->id]);



        $user_message = intval($this->property->land_area) . ' ' . $this->property->area_unit . ' Beautiful ' . $this->property->sub_type . ' for ' . $this->property->purpose . ' in a prime location of ' . $location . ', ' . $city . '.' .
            PHP_EOL .PHP_EOL . 'See price & contact details here: ' . $link .
            PHP_EOL . PHP_EOL . 'OR Search with Property ID: ' . $this->property->id.' on https://property.aboutpakistan.com';


        $linkData = [
            'message' => $user_message,
            'source' => $source
        ];
        $page_id = '906497989423481';
        try {
            $post = $fb->post('/' . $page_id . '/photos', $linkData, $token);
            $post = $post->getGraphNode()->asArray();
            echo 'Facebook Post Successfully Created.';
            print_r($post);

        } catch (FacebookSDKException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
//            exit;
        }


    }
}
