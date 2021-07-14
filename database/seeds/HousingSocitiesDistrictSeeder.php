<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HousingSocitiesDistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('mysql3')->table('districts')->truncate();

        DB::connection('mysql3')->table('districts')->insert([
                [
                    'division_id' => 1,
                    'isDevelopmentAuthority' => 0,
                    'code' => "RWP",
                    'title' => "ATTOCK"],
                [
                    'division_id' => 7,
                    'isDevelopmentAuthority' => 0,
                    'code' => "BWP",
                    'title' => "BAHAWALNAGAR"],
                [
                    'division_id' => 7,
                    'isDevelopmentAuthority' => 0,
                    'code' => "BWP",
                    'title' => "BAHAWALPUR"],
                [
                    'division_id' => 6,
                    'isDevelopmentAuthority' => 0,
                    'code' => "SGD",
                    'title' => "BHAKKAR"],
                [
                    'division_id' => 1,
                    'isDevelopmentAuthority' => 0,
                    'code' => "RWP",
                    'title' => "CHAKWAL"],
                [
                    'division_id' => 5,
                    'isDevelopmentAuthority' => 0,
                    'code' => "FSD",
                    'title' => "CHINIOT"],
                [
                    'division_id' => 9,
                    'isDevelopmentAuthority' => 0,
                    'code' => "DGK",
                    'title' => "DERA GHAZI KHAN"],
                [
                    'division_id' => 5,
                    'isDevelopmentAuthority' => 1,
                    'code' => "FSD",
                    'title' => "FAISALABAD"],
                [
                    'division_id' => 3,
                    'isDevelopmentAuthority' => 1,
                    'code' => "GRW",
                    'title' => "GUJRANWALA"],
                [
                    'division_id' => 3,
                    'isDevelopmentAuthority' => 0,
                    'code' => "GRW",
                    'title' => "GUJRAT"],
                [
                    'division_id' => 3,
                    'isDevelopmentAuthority' => 0,
                    'code' => "GRW",
                    'title' => "HAFIZABAD"],
                [
                    'division_id' => 1,
                    'isDevelopmentAuthority' => 0,
                    'code' => "RWP",
                    'title' => "JEHLUM"],
                [
                    'division_id' => 5,
                    'isDevelopmentAuthority' => 0,
                    'code' => "FSD",
                    'title' => "JHANG"],
                [
                    'division_id' => 2,
                    'isDevelopmentAuthority' => 1,
                    'code' => "LHR",
                    'title' => "KASUR"],
                [
                    'division_id' => 4,
                    'isDevelopmentAuthority' => 0,
                    'code' => "MUL",
                    'title' => "KHANEWAL"],
                [
                    'division_id' => 6,
                    'isDevelopmentAuthority' => 0,
                    'code' => "SGD",
                    'title' => "KHUSHAB"],
                [
                    'division_id' => 2,
                    'isDevelopmentAuthority' => 1,
                    'code' => "LHR",
                    'title' => "LAHORE"],
                [
                    'division_id' => 9,
                    'isDevelopmentAuthority' => 0,
                    'code' => "DGK",
                    'title' => "LAYYAH"],
                [
                    'division_id' => 4,
                    'isDevelopmentAuthority' => 0,
                    'code' => "MUL",
                    'title' => "LODHRAN"],
                [
                    'division_id' => 3,
                    'isDevelopmentAuthority' => 0,
                    'code' => "GRW",
                    'title' => "MANDI BAHAUDDIN"],
                [
                    'division_id' => 6,
                    'isDevelopmentAuthority' => 0,
                    'code' => "SGD",
                    'title' => "MIANWALI"],
                [
                    'division_id' => 4,
                    'isDevelopmentAuthority' => 1,
                    'code' => "MUL",
                    'title' => "MULTAN"],
                [
                    'division_id' => 9,
                    'isDevelopmentAuthority' => 0,
                    'code' => "DGK",
                    'title' => "MUZAFFARGARH"],
                [
                    'division_id' => 2,
                    'isDevelopmentAuthority' => 1,
                    'code' => "LHR",
                    'title' => "NANKANA SAHIB"],
                [
                    'division_id' => 3,
                    'isDevelopmentAuthority' => 0,
                    'code' => "GRW",
                    'title' => "NAROWAL"],
                [
                    'division_id' => 8,
                    'isDevelopmentAuthority' => 0,
                    'code' => "SWL",
                    'title' => "OKARA"],
                [
                    'division_id' => 8,
                    'isDevelopmentAuthority' => 0,
                    'code' => "SWL",
                    'title' => "PAKPATTAN"],
                [
                    'division_id' => 7,
                    'isDevelopmentAuthority' => 0,
                    'code' => "BWP",
                    'title' => "RAHIM YAR KHAN"],
                [
                    'division_id' => 9,
                    'isDevelopmentAuthority' => 0,
                    'code' => "DGK",
                    'title' => "RAJANPUR"],
                [
                    'division_id' => "1",
                    'isDevelopmentAuthority' => 1,
                    'code' => "RWP",
                    'title' => "RAWALPINDI",
                    ],
                [
                    'division_id' => 8,
                    'isDevelopmentAuthority' => 0,
                    'code' => "SWL",
                    'title' => "SAHIWAL"],
                [
                    'division_id' => 6,
                    'isDevelopmentAuthority' => 0,
                    'code' => "SGD",
                    'title' => "SARGODHA"],
                [
                    'division_id' => 2,
                    'isDevelopmentAuthority' => 1,
                    'code' => "LHR",
                    'title' => "SHEIKHUPURA"],
                [
                    'division_id' => 3,
                    'isDevelopmentAuthority' => 0,
                    'code' => "GRW",
                    'title' => "SIALKOT"],
                [
                    'division_id' => 5,
                    'isDevelopmentAuthority' => 0,
                    'code' => "FSD",
                    'title' => "TOBA TEK SINGH"],
                [
                    'division_id' => 4,
                    'isDevelopmentAuthority' => 0,
                    'code' => "MUL",
                    'title' => "VEHARI"],

            ]
        );

    }
}
