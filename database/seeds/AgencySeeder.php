<?php

use App\Models\Agency;
use App\Models\Dashboard\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new Agency)->truncate();
        $users = User::all()->pluck('id')->toArray();
        foreach ($users as $key => $user) {
            if ($user === 1) continue;
            $status = ['verified', 'pending', 'expired', 'deleted', 'rejected'];
            $special_listings = ['featured_listing', 'key_listing'];
            $phone_extensions = [
                300, 301, 302, 303, 304, 305, 306, 307, 308, 309,  # Jazz
                311, 312, 313, 314, 315, 316,  # Zong
                321, 322, 323, 324,  # Warid
                330, 331, 332, 333, 334, 335, 336, 337,  # Ufone
                340, 341, 342, 343, 344, 345, 346, 347, 348, 349,  # Telenor
            ];
            $names = ['Ali Ahmed', 'Hamid Mir', 'Josef Allen', 'Alex Genadinik', 'A Khan'];
            $city = DB::table('cities')->inRandomOrder()->first();
            $location = DB::table('locations')->inRandomOrder()->first();
            $selected_special_listings = $special_listings[array_rand($special_listings, 1)];
            $title = ['Super State', 'Pak Gulf', 'Star', 'Moon', 'Sky', 'High', 'True', 'Best', 'Unique', 'Better', 'Zameen', 'Jaidada', 'Mustafa', 'Madina', 'Jadda', 'Madina', 'Bismillah', 'Mashallah'];
            $phone = [21, 51, 42, 91];
            (new Agency)->updateOrCreate(['user_id' => $user], [
                'user_id' => $user,
                'city' => json_encode([$city->name]),
                'title' => $title[array_rand($title, 1)] . ' State Company',
                'description' => 'Agency Description',
                'phone' => '+92-' . $phone[array_rand($phone, 1)] . '-' . '1234567',
                'cell' => '+92-' . $phone_extensions[array_rand($phone_extensions, 1)] . '-' . '1234567',
                'fax' => '+92-' . $phone[array_rand($phone, 1)] . '-' . '1234567',
                'address' => $location->name,
                'country' => 'Pakistan',
                'website' => 'www.fake_url.com',
                'email' => 'random_email' . $user . '@email.com',
                'status' => $status[array_rand($status, 1)],
                'featured_listing' => $selected_special_listings === 'featured_listing',
                'key_listing' => $selected_special_listings === 'key_listing',
                'ceo_name' => $names[array_rand($names, 1)],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
