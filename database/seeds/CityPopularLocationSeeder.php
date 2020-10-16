<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CityPopularLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data_input = [
            [1, 'DHA Defence', 'Homes', 'House'],
            [1, 'Bahria Town', 'Homes', 'House'],
            [1, 'Gulberg', 'Homes', 'House'],
            [1, 'DHA Defence', 'Plots', 'Plots'],
            [1, 'Bahria Town', 'Plots', 'Plots'],
            [1, 'Gulberg', 'Plots', 'Plots'],
            [1, 'Gulberg', 'Commercial', 'Commercial'],
            [1, 'B-17', 'Commercial', 'Commercial'],
            [1, 'Bahria Town', 'Commercial', 'Commercial'],

            [2, 'Bahira Town', 'Plots', 'Plots'],
            [2, 'Scheme 33', 'Plots', 'Plots'],
            [2, 'DHA Defence', 'Plots', 'Plots'],
            [2, 'DHA City', 'Plots', 'Plots'],
            [2, 'Gadap Town', 'Plots', 'Plots'],
            [2, 'Bin Qasim Town', 'Plots', 'Plots'],
            [2, 'Naya Nazimabad', 'Plots', 'Plots'],
            [2, 'Scheme 45', 'Plots', 'Plots'],
            [2, 'DHA Defence', 'Commercial', 'Commercial'],
            [2, 'Bahria Town', 'Commercial', 'Commercial'],
            [2, 'Gulshan-e-Iqbal Town', 'Commercial', 'Commercial'],
            [2, 'Gulistan-e-Jauhar', 'Commercial', 'Commercial'],
            [2, 'Korangi', 'Commercial', 'Commercial'],
            [2, 'North Nazimabad', 'Commercial', 'Commercial'],
            [2, 'Clifton', 'Commercial', 'Commercial'],
            [2, 'Bahria Town', 'Homes', 'House'],
            [2, 'DHA Defence', 'Homes', 'House'],
            [2, 'Gulistan-e-Jauhar', 'Homes', 'House'],
            [2, 'Gulshan-e-Iqbal Town', 'Homes', 'House'],
            [2, 'North Karachi', 'Homes', 'House'],
            [2, 'Gadap Town', 'Homes', 'House'],
            [2, 'Cantt', 'Homes', 'House'],
            [2, 'Federal B Area', 'Homes', 'House'],
            [2, 'Malir', 'Homes', 'House'],
            [2, 'Korangi', 'Homes', 'House'],

            [3, 'DHA Defence', 'Homes', 'House'],
            [3, 'Bahria Town', 'Homes', 'House'],
            [3, 'Johar Town', 'Homes', 'House'],
            [3, 'State Life Housing Society', 'Homes', 'House'],
            [3, 'Wapda Town', 'Homes', 'House'],
            [3, 'Allama Iqbal Town', 'Homes', 'House'],
            [3, 'Paragon City', 'Homes', 'House'],
            [3, 'Askari', 'Homes', 'House'],
            [3, 'DHA Defence', 'Plots', 'Plots'],
            [3, 'Bahria Town', 'Plots', 'Plots'],
            [3, 'Bahria Orchard', 'Plots', 'Plots'],
            [3, 'Raiwind Road', 'Plots', 'Plots'],
            [3, 'State Life Housing Society', 'Plots', 'Plots'],
            [3, 'DHA 11 Rahbar', 'Plots', 'Plots'],
            [3, 'Central Park Housing Scheme', 'Plots', 'Plots'],
            [3, 'LDA Avenue', 'Plots', 'Plots'],
            [3, 'Gulberg', 'Commercial', 'Commercial'],
            [3, 'DHA Defence', 'Commercial', 'Commercial'],
            [3, 'Bahria Town', 'Commercial', 'Commercial'],
            [3, 'Johar Town', 'Commercial', 'Commercial'],
            [3, 'Allama Iqbal Town', 'Commercial', 'Commercial'],
            [3, 'Cantt', 'Commercial', 'Commercial'],
            [3, 'Ferozepur Road', 'Commercial', 'Commercial'],
            [3, 'Township', 'Commercial', 'Commercial'],

            [4, 'Bahria Town', 'Homes', 'House'],
            [4, 'Adiala Road', 'Homes', 'House'],
            [4, 'Airport Housing Society', 'Homes', 'House'],
            [4, 'Bahria Town', 'Plots', 'Plots'],
            [4, 'Chakri Road', 'Plots', 'Plots'],
            [4, 'Capital Smart City', 'Plots', 'Plots'],
            [4, 'Bahria Town Rawalpindi', 'Commercial', 'Commercial'],
            [4, 'Saddar', 'Commercial', 'Commercial'],
            [4, 'Murree Road', 'Commercial', 'Commercial'],
            [4, 'Satellite Town', 'Commercial', 'Commercial'],
            [4, 'Adiala Road', 'Commercial', 'Commercial'],

            [153, 'Hayatabad', 'Commercial', 'Commercial'],
            [153, 'Ring Road', 'Commercial', 'Commercial'],
            [153, 'Kaur Complex', 'Commercial', 'Commercial'],
            [153, 'Pakha Ghulam', 'Commercial', 'Commercial'],
            [153, 'Phandu Road', 'Commercial', 'Commercial'],
            [153, 'Nasir Bagh Road', 'Commercial', 'Commercial'],
            [153, 'GT Road', 'Commercial', 'Commercial'],
            [153, 'Sardargarhi', 'Commercial', 'Commercial'],
            [153, 'Yakatoot', 'Commercial', 'Commercial'],
            [153, 'University Road', 'Commercial', 'Commercial'],
            [153, 'Tajabad', 'Commercial', 'Commercial'],
            [153, 'DHA Defence', 'Plots', 'Plots'],
            [153, 'Regi Model Town', 'Plots', 'Plots'],
            [153, 'Wapda Town', 'Plots', 'Plots'],
            [153, 'Warsak Road', 'Plots', 'Plots'],
            [153, 'Nasir Bagh Road', 'Plots', 'Plots'],
            [153, 'Ring Road', 'Plots', 'Plots'],
            [153, 'Pajagi Road', 'Plots', 'Plots'],
            [153, 'Hayatabad', 'Homes', 'House'],
            [153, 'Warsak Road', 'Homes', 'House'],
            [153, 'Gulbahar', 'Homes', 'House'],
            [153, 'Ring Road', 'Homes', 'House'],
            [153, 'Dalazak Road', 'Homes', 'House'],
            [153, 'Pajagi Road', 'Homes', 'House'],
            [153, 'Kaur Complex', 'Homes', 'House'],
        ];


        foreach ($data_input as $data) {
            DB::table('city_popular_locations')->insert([
                'city_is' => $data[0],
                'location_name' => $data[1],
                'property_type' => $data[2],
                'property_subtype' => $data[3],
            ]);

        }

    }
}
