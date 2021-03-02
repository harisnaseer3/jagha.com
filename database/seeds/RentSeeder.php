<?php

use App\Models\Dashboard\City;
use App\Models\Property;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $properties = Property::select('id','land_area', 'area_in_sqft', 'area_in_sqyd', 'area_unit', 'area_in_sqm', 'area_in_marla',
//                'area_in_kanal', 'area_in_new_marla', 'area_in_new_kanal')
//            ->where('city_id', '!=', 2)->where('expired_at', '>', now())->get();
//        foreach ($properties as $property) {
////           print_r($property);
//            print('reading...');
//            if ($property->land_area !== 0 && $property->area_in_sqft == 0) {
//                echo $property->id .PHP_EOL ;
//                $area_values = $this->calculateArea($property->area_unit, number_format((float)str_replace(',', '', $property->land_area), 2, '.', ''));
//                $property->area_in_sqft = $area_values['sqft'];
//                $property->area_in_marla = $area_values['marla'];
//                $property->area_in_new_marla = $area_values['new_marla'];
//                $property->area_in_sqyd = $area_values['sqyd'];
//                $property->area_in_sqm = $area_values['sqm'];
//                $property->area_in_kanal = $area_values['kanal'];
//                $property->area_in_new_kanal = $area_values['new_kanal'];
//                $property->update();
//            }
        $cities = City::select('name')->get();
        $new_cities = [
            'Rajanpur',
            'Rawalkot',
            'Rohri',
            'Sadiqabad',
            'Sahiwal',
            'Samundri',
            'Sanghar',
            'Sarai_Alamgir',
            'Sargodha',
            'Shahdadpur',
            'Shahkot',
            'Sheikhupura',
            'Shorkot',
            'Sialkot',
            'Skardu',
            'Sukkur',
            'Swabi',
            'Swat',
            'Talagang',
            'Tando_Adam',
            'Tando_Allahyar',
            'Taxila',
            'Thatta',
            'Toba_Tek_Singh',
            'Vehari',
            'Wah',
            'Wazirabad',
            'Mian_Channu',
            'Mirpur',
            'Mirpur_Khas',
            'Multan',
            'Islamabad',
            'Karachi',
            'Lahore',
            'Rawalpindi',
            'Peshawar',
            'Pindi_Bhattian',
            'Pir_Mahal',
            'Quetta',
            'Rahim_Yar_Khan',
            'Abbottabad',
            'Abdul_Hakim',
            'Ahmedpur_East',
            'Alipur',
            'Arifwala',
            'Astore',
            'Attock',
            'Awaran',
            'Badin',
            'Bagh',
            'Bahawalnagar',
            'Bahawalpur',
            'Bannu',
            'Barnala',
            'Bhakkar',
            'Bhalwal',
            'Bhimber',
            'Buner',
            'Burewala',
            'Chakwal',
            'Charsadda',
            'Chichawatni',
            'Chaghi',
            'Chiniot',
            'Chishtian_Sharif',
            'Chitral',
            'Chunian',
            'Dadu',
            'Daharki',
            'Daska',
            'Depalpur',
            'Dera_Ghazi_Khan',
            'Dera_Ismail_Khan',
            'Dijkot',
            'Dina',
            'Faisalabad',
            'FATA',
            'Fateh_Jang',
            'Gaarho',
            'Gadoon',
            'Galyat',
            'Gharo',
            'Ghotki',
            'Gilgit',
            'Gojra',
            'Gujar_Khan',
            'Gujranwala',
            'Gujrat',
            'Gwadar',
            'Hafizabad',
            'Hangu',
            'Haripur',
            'Haroonabad',
            'Hasilpur',
            'Hassan_Abdal',
            'Haveli_Lakha',
            'Hazro',
            'Hub_Chowki',
            'Hunza',
            'Hyderabad',
            'Jacobabad',
            'Jahanian',
            'Jalalpur_Jattan',
            'Jampur',
            'Jamshoro',
            'Jauharabad',
            'Jhang',
            'Jhelum',
            'Kaghan',
            'Kahror_Pakka',
            'Kalat',
            'Kamalia',
            'Kamoki',
            'Karak',
            'Kasur',
            'Khairpur',
            'Khanewal',
            'Khanpur',
            'Kharian',
            'Khushab',
            'Khuzdar',
            'Kohat',
            'Kot_Addu',
            'Kotli',
            'Kotri',
            'Lalamusa',
            'Larkana',
            'Layyah',
            'Lodhran',
            'Mailsi',
            'Mandi_Bahauddin',
            'Mangla',
            'Mansehra',
            'Mardan',
            'Malakand',
            'Muridke',
            'Murree',
            'Muzaffarabad',
            'Muzaffargarh',
            'Nankana_Sahib_',
            'Naran',
            'Narowal',
            'Nawabshah',
            'Nowshera',
            'Okara',
            'Pakpattan'
        ];
        foreach ($cities as $city) {
            if (!in_array(str_replace(' ', '_', $city->name), $new_cities))
                echo $city->name . PHP_EOL;

        }
    }

}
