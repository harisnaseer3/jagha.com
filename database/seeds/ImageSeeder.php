<?php

use App\Models\Image;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $property_list = (new Image)->select('property_id')->groupBy('property_id')->get()->toArray();
        foreach ($property_list as $key1 => $property) {
            $images = (new Image)->where('property_id', '=', $property['property_id'])->get();
            foreach ($images as $key => $image) {
                $image->order = $key + 1;
                $image->save();
            }
            print($key1 + 1);
        }

    }
}
