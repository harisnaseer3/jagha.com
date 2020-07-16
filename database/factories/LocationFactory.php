<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Dashboard\Location;
use App\Models\Dashboard\City;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(Location::class, function (Faker $faker) {

    $islamabad_locations = ['12th Avenue','7th Avenue','9th Avenue','Abdullah Garden','Agha Shahi Avenue','AGHOSH','Agro Farming Scheme','Ahmed Town','Airline Avenue','Airport Avenue Housing Society','Airport Enclave','Aiza Garden','Akbar Town','Al Buraq Valley','Al Huda Town','Al Madina City','Al Qaim Town','Al-Kabir Town','Alhamra Avenue','Ali Pur','Alipur Farash','Ammar Enclave And Talha Villas','Angoori Road','Arcadia City','Arsalan Town','Asad Town','Ataturk Avenue','Athal','Atomic Energy Employee Society','Axis Mall  Apartments','Azmat Town','B-17','Bahria Town','Bani Gala','Bhara kahu','Blue Area','Bokra Road','Burma Town','C-14','C-15','C-16','C-17','C-18','C-19','Canyon Views Prados','Capital Enclave','CBR Town','Central Avenue','Chak Shahzad','Chatha Bakhtawar','Chattar','Chinar Model Valley','Chirah','City Garden','Club Road','Commander Enclave','Commerce Town','Commoners Flower Valley','Commoners Gold Valley','Commoners Sky Gardens','Constitution Avenue','D-12','D-13','D-14','D-16','D-17','D-18','Danial Town','Darussalam Coop Society','DHA Defence','Dhok Chaudhrian','Diplomatic Enclave','E-10','E-11','E-12','E-13','E-14','E-15','E-16','E-17','E-18','E-19','E-6','E-7','E-8','Eden Life Islamabad','Emaar Canyon Views','Embassy Road','Engineering Co-operative Housing (ECHS)','F-10','F-11','F-12','F-13','F-14','F-15','F-16','F-17','F-5','F-6','F-7','F-8','F-9','Faisal Town - F-18','Fateh Jang Road','Fatima Town','FECHS','Federal Government Employees Housing Foundation','Fenarina Residences','FOECHS - Foreign Office Employees Society','Frash Town','G-10','G-11','G-12','G-13','G-14','G-15','G-16','G-17','G-5','G-6','G-7','G-8','G-9','Gandhara City','Garden Town','Ghauri Town','Golra Mor','Golra Road','Grace Valley','Graceland Housing','Green Avenue','Green City','Green Hills Housing Scheme','Green Huts Farmhouses','GT Road','Gulberg','Gulshan-e-Khudadad','Gulshan-e-Rabia','H-10','H-11','H-12','H-13','H-15','H-17','H-19','H-8','H-9','Hundamal','Hussain Abad','I-10','I-11','I-12','I-13','I-14','I-15','I-16','I-17','I-8','I-9','Ibn-e-Sina Road','Icon Garden','IJP Road','Iqbal Town','Islamabad - Murree Expressway','Islamabad - Peshawar Motorway','Islamabad Enclave','Islamabad Expressway','Islamabad Garden','Islamabad Highway','Islamabad View Valley','Ittefaq Town','J and K Zone 5','Jagiot Road','Jandala Road','Japan Road','Jeddah Town','Jhang Syedan','Jhangi Syedan','Jinnah Avenue','Judicial Town','Kahuta Road','Kahuta Triangle Industrial Area','Karakoram Diplomatic Enclave','Karakoram Enclave 1','Kashmir Highway','Kashmir Town','Khanna Pul','Khayaban-e-Iqbal','Khayaban-e-Suhrwardy','Koral Chowk','Koral Town','Korang Road','Korang Town','Kuri','Kuri Model Town','Kuri Road','Lawyers Society','Lehtarar Road','Luqman Hakeem Road','Madina Town','Main Margalla Road','Malot','Malpur','Margalla Town','Margalla Valley - C-12','Marwa Town','Meherban Colony','Ministry of Commerce Society','Mira Abadi','Model Town','Mohra Nur Road','Montviro','Motorway Chowk','Motorway City','Motorway City Executive Block','Mubasher Homes','Multi Residencia  Orchards','Mumtaz City','Murree Road','Muslim Town','NARC Colony','National Cooperative Housing Society','National Police Foundation','National Police Foundation O-9','National Town','Naval Anchorage','Naval Farms Housing Scheme','Naval Housing Scheme','Nazim-ud-din Road','New Airport Town','New Icon City','New Shakrial','NHA Housing Society','NIH Colony','OGDC Officers Cooperative Housing Society','OGDC Town','OPF Valley','Orchard Scheme','Others','PAEC Employees Cooperative Housing Society','PAF Tarnol','Pakistan Intelligence Bureau Housing Society','Pakistan Town','Park Enclave','Park Road','Park View City','Partal Town','PECHS','Phulgran','Pind Begwal','Pindorian','Pir Sohawa','Police Foundation Housing Society','PTV Colony','PWD Housing Scheme','PWD Road','Quaid-e-Azam Road','Qutbal Town','Raja Akhtar Road','Rawal Dam Colony','Rawal Enclave','Rawal Town','Razia Abad','River Garden','Royal Avenue','Royal City','Sangjani','Sarai Kharbuza','Sehab Gardens','Sehala Farm House','Senate Secretariat Employees Cooperative Housing Society','Shah Allah Ditta','Shah Dara','Shaheen Town','Shahpur','Shalimar Town','Shehzad Town','Sihala','Sihala Valley','Silver City Housing Scheme','Simly Dam Road','Soan Garden','Sohan Valley','Spring Valley','State Life Insurance Employees Cooperative Housing Society','Swan Garden','Taramrri','Tarlai','Tarnol','Thalian','Thanda Pani','The Organic Farms Islamabad','The Springs','Top City 1','Tumair','University Town','Victoria Heights','Wapda Town','Yousaf Homes','Zaraj Housing Scheme','Zero Point','Zone 5'];

    $karachi_locations = [
        'Abdullah Ahmed Road',
        'Abdullah Haroon Road',
        'Abid Town',
        'Ablagh-e-Aama Society',
        'Abul Hassan Isphani Road',
        'Ahsan Grand City',
        'Airport',
        'Airport Road',
        'Aisha Manzil',
        'Al-Hilal Society',
        'Al-Jadeed Residency',
        'Al-Manzar Town',
        'Al-Safaa Garden',
        'Allama Iqbal Town',
        'Altaf Hussain Road',
        'Amil Colony',
        'Amir Khusro',
        'Anda Mor Road',
        'APP Employees Co-operative Housing Society',
        'ASF Housing Scheme',
        'ASF Tower',
        'Ashraf Nagar',
        'Ayesha View Housing Society',
        'Azam Nagar',
        'Azam Town',
        'Azeemabad',
        'Bahria Town Karachi',
        'Baldia Town',
        'Baloch Colony',
        'Bangladesh Colony',
    ];

    $locations = array_merge($islamabad_locations, $karachi_locations);

    return [
        'user_id' => 1,
        'city_id' => DB::table('cities')->inRandomOrder()->first()->id,
        'name' => $faker->randomElement($locations),
    ];
});
