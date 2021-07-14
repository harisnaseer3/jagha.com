<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HousingAuthoritiesSocieties extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('mysql3')->table('societies')->truncate();
        $path = ('database/societies.json');
        $strJsonFileContents = file_get_contents($path);
        $array = json_decode($strJsonFileContents, true);

        foreach ($array as $data) {

            $c = DB::connection('mysql3')->table('cities')->select('id')->where('title', $data['City'])->first()->id;


            $a = 0;
            $given_a = $data['AuthorityID'];
            if ($given_a == 31)
                $a = 1;  //31 => 1
            elseif ($given_a == 32)
                $a = 2;  //32=> 2
            elseif ($given_a == 1)
                $a = 3; //1=>3
            elseif ($given_a == 2)
                $a = 4; //2=>4

            elseif ($given_a == 33)
                $a = 5; //33=> 5

            elseif ($given_a == 39)
                $a = 6; //39=>6
            elseif ($given_a == 34)
                $a = 7; //34=>7

            $div = 0;
            $d_given = $data['DivisionID'];
            if ($d_given == 4) $div = 1; //4 =>   1
            else if ($d_given == 6) $div = 2; //6 =>   2
            else if ($d_given == 7) $div = 3; //7 =>   3
            else if ($d_given == 9) $div = 4; //9 =>   4
            else if ($d_given == 10) $div = 5; //10 =>   5
            else if ($d_given == 11) $div = 6; //11 =>   6
            else if ($d_given == 12) $div = 7; //12 =>   7
            else if ($d_given == 13) $div = 8; //13 =>   8
            else if ($d_given == 14) $div = 9; //14 =>   9

//            dd($d_given, $div);

            $dis = 0;

            $dis_given = $data['DistrictID'];
            if ($dis_given == 27) $dis = 1;
            else if ($dis_given == 1) $dis = 2;
            else if ($dis_given == 2) $dis = 3;
            else if ($dis_given == 31) $dis = 4;
            else if ($dis_given == 30) $dis = 5;
            else if ($dis_given == 35) $dis = 6;
            else if ($dis_given == 4) $dis = 7;
            else if ($dis_given == 8) $dis = 8;
            else if ($dis_given == 11) $dis = 9;
            else if ($dis_given == 12) $dis = 10;
            else if ($dis_given == 14) $dis = 11;
            else if ($dis_given == 28) $dis = 12;
            else if ($dis_given == 9) $dis = 13;
            else if ($dis_given == 17) $dis = 14;
            else if ($dis_given == 24) $dis = 15;
            else if ($dis_given == 32) $dis = 16;
            else if ($dis_given == 18) $dis = 17;
            else if ($dis_given == 5) $dis = 18;
            else if ($dis_given == 26) $dis = 19;
            else if ($dis_given == 15) $dis = 20;
            else if ($dis_given == 33) $dis = 21;
            else if ($dis_given == 21) $dis = 22;
            else if ($dis_given == 6) $dis = 23;
            else if ($dis_given == 36) $dis = 24;
            else if ($dis_given == 16) $dis = 25;
            else if ($dis_given == 19) $dis = 26;
            else if ($dis_given == 25) $dis = 27;
            else if ($dis_given == 3) $dis = 28;
            else if ($dis_given == 7) $dis = 29;
            else if ($dis_given == 29) $dis = 30;
            else if ($dis_given == 22) $dis = 31;
            else if ($dis_given == 34) $dis = 32;
            else if ($dis_given == 20) $dis = 33;
            else if ($dis_given == 13) $dis = 34;
            else if ($dis_given == 10) $dis = 35;
            else if ($dis_given == 23) $dis = 36;



            DB::connection('mysql3')->table('societies')->insert([
                'name' => trim($data['Name']),
                'area' => $data['TotalArea'],
                'authority_id' => $a,
                'status_id' => $data['SocietyStatusID'],
                'is_active' => 1,
                'city_id' => $c,
                'district_id' => $dis,
                'division_id' => $div

            ]);



        }
    }
}
