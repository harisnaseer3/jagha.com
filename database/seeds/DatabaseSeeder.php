<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        $this->call(RolesSeeder::class);
        $this->call(UserSeeder::class);

        $this->call(CitySeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(FeatureSeeder::class);
        $this->call(PropertyTypeSeeder::class);
        $this->call(AgencySeeder::class);
        $this->call(AgencyUserSeeder::class);
        $this->call(PropertySeeder::class);
        $this->call(RentSeeder::class);
        $this->call(ImageSeeder::class);
        $this->call(VideoSeeder::class);;
        $this->call(AgencyPerformanceSeeder::class);
        $this->call(ClientSeeder::class);
        $this->call(FavoriteSeeder::class);
        $this->call(PropertyCountByCitySeeder::class);
        $this->call(PropertyCountByLocationSeeder::class);
        $this->call(PropertyCountByPropertyTypeSeeder::class);
        $this->call(PropertyCountByPropertyPurposeSeeder::class);
        $this->call(SubscriberSeeder::class);

        Schema::enableForeignKeyConstraints();
    }
}
