<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Property;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(Property::class, function (Faker $faker) {

    $status = ['active', 'edited', 'pending', 'expired', 'uploaded', 'hidden', 'deleted', 'rejected'];
    $purpose = ['Sale', 'Rent', 'Wanted'];
    $sub_purpose = ['Buy', 'Rent'];
    $type = [
        'Homes' => ['House', 'Flat', 'Upper Portion', 'Lower Portion', 'Farm House', 'Room', 'Penthouse'],
        'Plots' => ['Residential Plot', 'Commercial Plot', 'Agricultural Land', 'Industrial Land', 'Plot File', 'Plot Form'],
        'Commercial' => ['Office', 'Shop', 'Warehouse', 'Factory', 'Building', 'Other'],
    ];
    $special_listings = ['premium_listing', 'super_hot_listing', 'hot_listing', 'magazine_listing'];
    $phone_extensions = [
        300, 301, 302, 303, 304, 305, 306, 307, 308, 309,  # Jazz
        311, 312, 313, 314, 315, 316,  # Zong
        321, 322, 323, 324,  # Warid
        330, 331, 332, 333, 334, 335, 336, 337,  # Ufone
        340, 341, 342, 343, 344, 345, 346, 347, 348, 349,  # Telenor
    ];

    $location = DB::table('locations')->inRandomOrder()->first();
    $user = DB::table('users')->select('id')->inRandomOrder()->first();

    $agency = DB::table('agency_users')
        ->select('agency_users.agency_id AS id')
        ->where('user_id', '=', $user->id)->first();

    $selected_purpose = $faker->randomElement($purpose);
    $selected_type = $faker->randomElement(array_keys($type));
    $selected_sub_type = $faker->randomElement($type[$selected_type]);
    $selected_special_listings = $faker->randomElement($special_listings);

    $coordinates = [[33.7108927, 73.0313684], [24.7984714, 67.0327672], [31.4846565, 74.3151685]];
    $selected_coordinates = $faker->randomElement($coordinates);
    $area_unit = ['Square Feet', 'Square Yards', 'Square Meters', 'Marla', 'Kanal'];

//    $max_id = DB::select("SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'property_management' AND TABLE_NAME = 'properties'")[0]->AUTO_INCREMENT;
//    $reference = 'ID-' . date("Y") . '-' . str_pad($max_id+1, 3, 0, STR_PAD_LEFT);

//    $reference = 'ID-' . date("Y") . '-' . str_pad($faker->randomNumber(4) + $faker->randomNumber(2) * 65 - $faker->randomNumber(2), 7, 0, STR_PAD_LEFT);
    return [
        'reference' => date("Y") . '-' . rand(11111111,99999999),
        'user_id' => $user->id,
        'city_id' => $location->city_id,
        'location_id' => $location->id,
        'agency_id' => $agency === null ? null : $agency->id,
        'purpose' => $selected_purpose,
        'sub_purpose' => $selected_purpose === 'Wanted' ? $faker->randomElement($sub_purpose) : null,
        'type' => $selected_type,
        'sub_type' => $selected_sub_type,
        'title' => 'Property Title',
        'description' => 'Property Description',
        'price' => $faker->numberBetween(1000, 99999) * 1000,
        'land_area' => $faker->numberBetween(10, 99),
        'area_unit' => $faker->randomElement($area_unit),
        'bedrooms' => $faker->numberBetween(1, 10),
        'bathrooms' => $faker->numberBetween(1, 3),
        'latitude' => $selected_coordinates[0],
        'longitude' => $selected_coordinates[1],
        'features' => null,
        'premium_listing' => $selected_special_listings === 'premium_listing',
        'super_hot_listing' => $selected_special_listings === 'super_hot_listing',
        'hot_listing' => $selected_special_listings === 'hot_listing',
        'magazine_listing' => $selected_special_listings === 'magazine_listing',
        'contact_person' => $faker->name,
        'phone' => '+92-' . $faker->randomElement([21, 51, 42, 91]) . '-' . $faker->randomNumber(7),
        'cell' => '+92-' . $faker->randomElement($phone_extensions) . '-' . $faker->randomNumber(7),
        'fax' => '+92-' . $faker->randomElement([21, 51, 42, 91]) . '-' . $faker->randomNumber(7),
        'email' => $faker->email,
        'favorites' => $faker->numberBetween(50, 100),
        'views' => $faker->numberBetween(50, 100),
        'visits' => $faker->numberBetween(10, 50),
        'click_through_rate' => $faker->numberBetween(1, 10),
        'status' => $faker->randomElement($status),
        'created_at' => $faker->dateTimeBetween('-1 months', 'now', 'Asia/Karachi'),
        'updated_at' => $faker->dateTime('now', 'Asia/Karachi'),
    ];
});
