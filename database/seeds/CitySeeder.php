<?php

use App\Models\Dashboard\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        factory(City::class, 3)->create();
        $cities = ['Islamabad', 'Karachi', 'Lahore', 'Rawalpindi', 'Abbottabad', 'Abdul Hakim', 'Ahmedpur East', 'Alipur', 'Arifwala', 'Astore', 'Attock', 'Awaran', 'Badin', 'Bagh', 'Bahawalnagar', 'Bahawalpur', 'Balakot', 'Bannu', 'Barnala', 'Batkhela', 'Bhakkar', 'Bhalwal', 'Bhimber', 'Buner', 'Burewala', 'Chaghi', 'Chakwal', 'Charsadda', 'Chichawatni', 'Chiniot', 'Chishtian Sharif', 'Chitral', 'Choa Saidan Shah', 'Chunian', 'Dadu', 'Daharki', 'Daska', 'Daur', 'Depalpur', 'Dera Ghazi Khan', 'Dera Ismail Khan', 'Dijkot', 'Dina', 'Dobian', 'Duniya Pur', 'Faisalabad', 'FATA', 'Fateh Jang', 'Gaarho', 'Gadoon', 'Galyat', 'Ghakhar', 'Gharo', 'Ghotki', 'Gilgit', 'Gojra', 'Gujar Khan', 'Gujranwala', 'Gujrat', 'Gwadar', 'Hafizabad', 'Hala', 'Hangu', 'Harappa', 'Haripur', 'Haroonabad', 'Hasilpur', 'Hassan Abdal', 'Haveli Lakha', 'Hazro', 'Hub Chowki', 'Hujra Shah Muqeem', 'Hunza', 'Hyderabad', 'Jacobabad', 'Jahanian', 'Jalalpur Jattan', 'Jampur', 'Jamshoro', 'Jatoi', 'Jauharabad', 'Jhang', 'Jhelum', 'Kaghan', 'Kahror Pakka', 'Kalat', 'Kamalia', 'Kamoki', 'Kandiaro', 'Karak', 'Kasur', 'Khairpur', 'Khanewal', 'Khanpur', 'Kharian', 'Khipro', 'Khushab', 'Khuzdar', 'Kohat', 'Kot Addu', 'Kotli', 'Kotri', 'Lakki Marwat', 'Lalamusa', 'Larkana', 'Lasbela', 'Layyah', 'Liaquatpur', 'Lodhran', 'Loralai', 'Lower Dir', 'Mailsi', 'Makran', 'Malakand', 'Mandi Bahauddin', 'Mangla', 'Mansehra', 'Mardan', 'Matiari', 'Matli', 'Mian Channu', 'Mianwali', 'Mingora', 'Mirpur Khas', 'Mirpur Sakro', 'Mirpur', 'Mitha Tiwana', 'Moro', 'Multan', 'Muridke', 'Murree', 'Muzaffarabad', 'Muzaffargarh', 'Nankana Sahib', 'Naran', 'Narowal', 'Nasar Ullah Khan Town', 'Nasirabad', 'Naushahro Feroze', 'Nawabshah', 'Neelum', 'New Mirpur City', 'Nowshera', 'Okara', 'Others Azad Kashmir', 'Others Balochistan', 'Others Gilgit Baltistan', 'Others Khyber Pakhtunkhwa', 'Others Punjab', 'Others Sindh', 'Others', 'Pakpattan', 'Peshawar', 'Pind Dadan Khan', 'Pindi Bhattian', 'Pir Mahal', 'Qazi Ahmed', 'Quetta', 'Rahim Yar Khan', 'Rajana', 'Rajanpur', 'Ratwal', 'Rawalkot', 'Rohri', 'Sadiqabad', 'Sahiwal', 'Sakrand', 'Samundri', 'Sanghar', 'Sarai Alamgir', 'Sargodha', 'Sehwan', 'Shabqadar', 'Shahdadpur', 'Shahkot', 'Shahpur Chakar', 'Shakargarh', 'Shehr Sultan', 'Sheikhupura', 'Sher Garh', 'Shikarpur', 'Shorkot', 'Sialkot', 'Sibi', 'Skardu', 'Sudhnoti', 'Sujawal', 'Sukkur', 'Swabi', 'Swat', 'Talagang', 'Tando Adam', 'Tando Allahyar', 'Tando Bago', 'Tando Muhammad Khan', 'Taxila', 'Tharparkar', 'Thatta', 'Toba Tek Singh', 'Turbat', 'Vehari', 'Wah', 'Wazirabad', 'Waziristan', 'Yazman', 'Zhob'];

        foreach ($cities as $key => $value) {
            DB::table('cities')->insert([
                'user_id' => '1',
                'name' => $value,
                'is_active' => '1',
            ]);
        }
    }
}
