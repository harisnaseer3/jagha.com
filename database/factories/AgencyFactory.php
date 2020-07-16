<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Agency;
use App\Models\Dashboard\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(Agency::class, function (Faker $faker) {
//    $user = (new User)->select('id')->inRandomOrder()->first();
//        if ((DB::table('agencies')
//            ->where('user_id', '=', $user->id)
//            ->exists()))
//        {
////             It does not exist
//            $status = ['verified', 'pending', 'expired', 'deleted', 'rejected'];
//            $special_listings = ['featured_listing', 'key_listing'];
//            $phone_extensions = [
//                300, 301, 302, 303, 304, 305, 306, 307, 308, 309,  # Jazz
//                311, 312, 313, 314, 315, 316,  # Zong
//                321, 322, 323, 324,  # Warid
//                330, 331, 332, 333, 334, 335, 336, 337,  # Ufone
//                340, 341, 342, 343, 344, 345, 346, 347, 348, 349,  # Telenor
//            ];
//            $city = DB::table('cities')->inRandomOrder()->first();
//            $location = DB::table('locations')->inRandomOrder()->first();
//            $selected_special_listings = $faker->randomElement($special_listings);
//            $title = ['Super State', 'Pak Gulf', 'Star', 'Moon', 'Sky', 'High', 'True', 'Best', 'Unique', 'Better', 'Zameen', 'Jaidada', 'Mustafa', 'Madina', 'Jadda', 'Madina', 'Bismillah', 'Mashallah'];
//
//            return [
//                'user_id' => $user->id,
//                'city' => json_encode([$city->name]),
//                'title' => $faker->randomElement($title) . 'Company',
//                'description' => 'Agency Description',
//                'phone' => '+92-' . $faker->randomElement([21, 51, 42, 91]) . '-' . $faker->randomNumber(7),
//                'cell' => '+92-' . $faker->randomElement($phone_extensions) . '-' . $faker->randomNumber(7),
//                'fax' => '+92-' . $faker->randomElement([21, 51, 42, 91]) . '-' . $faker->randomNumber(7),
//                'address' => $location->name,
//                'country' => 'Pakistan',
//                'website' => $faker->url,
//                'email' => $faker->email,
//                'status' => $faker->randomElement($status),
//                'featured_listing' => $selected_special_listings === 'featured_listing',
//                'key_listing' => $selected_special_listings === 'key_listing',
//                'ceo_name' => $faker->firstNameMale,
//                'created_at' => $faker->dateTimeBetween('-1 months', 'now', 'Asia/Karachi'),
//                'updated_at' => $faker->dateTime('now', 'Asia/Karachi'),
//            ];
//        }
});
