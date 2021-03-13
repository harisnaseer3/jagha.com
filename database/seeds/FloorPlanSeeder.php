<?php

use App\Http\Controllers\CountTableController;
use App\Http\Controllers\Dashboard\LocationController;
use App\Http\Controllers\FloorPlanController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\VideoController;
use App\Models\Agency;
use App\Models\Dashboard\City;
use App\Models\Dashboard\Location;
use App\Models\Image;
use App\Models\Property;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;

class FloorPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

//        $records = DB::table('properties')->select('properties.id','properties.agency_id','properties.created_at','property_links.link')
//            ->where('properties.cell', '=', null)
//            ->where('properties.phone', '=', null)
////            ->where('properties.agency_id', '!=', null)
////            ->where('agencies.phone', '=', null)
//            ->where('properties.id', '>', 71490)
////            ->where('agencies.id', '>', 6782)
////            ->join('agencies', 'properties.agency_id', '=', 'agencies.id')
//            ->join('property_links', 'properties.id', '=', 'property_links.property_id')
//            ->get()->toArray();
////        dd($records);
//        $data = array();
//
//        foreach ($records as $record) {
//            echo('writing data');
//            array_push($data, $record);
//
//        }
////        dd(json_encode($data));
//        file_put_contents("total_data.json", json_encode($data));


//        $agency_ids = ['6803', '6844', '6849', '6857', '6870', '6877', '6895', '6927', '6947', '7004', '7049', '7054', '7061', '7103',
//            '7136', '7154', '7172', '7185', '7189',
//            '7218', '7226', '7338', '7374', '7412', '7431', '7456', '7460', '7463', '7521', '7528', '7532', '7554',
//            '7576', '7649', '7657', '7694', '7711', '7723', '7726', '7741', '7746', '7751', '7759', '7762', '7816',
//            '7852', '7854', '7878', '7937', '7947', '7953', '7997', '8063', '8064', '8066', '8091', '8117', '8118', '8137',
//            '8149', '8220', '8231', '8252', '8315', '8340', '8341', '8343', '8432', '8441', '8447', '8452', '8457', '8488',
//            '8511', '8549', '8566', '8608', '8661', '8670', '8700', '8756', '8758', '8774', '8811', '8813', '8859', '8868',
//            '8891', '8967', '8988', '9008', '9014', '9021', '9025', '9030', '9033', '9040', '9041', '9075', '9098', '9114',
//            '9117', '9120', '9123', '9140', '9146', '9163', '9168', '9202', '9206', '9207', '9211', '9214', '9219', '9223',
//            '9233', '9287', '9298', '9334', '9352', '9360', '9371', '9421', '9451', '9463', '9479', '9480', '9495', '9511',
//            '9539', '9548', '9573', '9595', '9606', '9607', '9625', '9648', '9655', '9718', '9735', '9811', '9824', '9837',
//            '9891', '9905', '9906', '9921', '9925', '9977', '9995', '10009', '10023', '10028', '10046', '10057', '10066',
//            '10069', '10087', '10093', '10112', '10142', '10189', '10205', '10219', '10273', '10310', '10311', '10331',
//            '10344', '10393', '10410', '10430', '10439', '10456', '10459', '10462', '10497', '10549', '10550', '10555',
//            '10563', '10571', '10579', '10640', '10674', '10692', '10739', '10745', '10746', '10749', '10758', '10800',
//            '10823', '10840', '10844', '10850', '10860', '10879', '10899', '10909', '10923'];

//        $agency_ids = ['7218', '7374', '7412', '7528', '7532', '7576', '7746', '8063', '8118', '8252',
//            '8315', '8341', '8343', '8452', '8457', '8511', '8891', '9008', '9021', '9025', '9033', '9075',
//            '9098', '9163', '9223', '9360', '9479', '9548', '9648', '9811', '9995', '10057', '10459', '10549', '10640', '10674', '10879'];
//        foreach ($agency_ids as $id) {
//            $records = DB::table('properties')->select('properties.id', 'properties.agency_id', 'properties.phone', 'properties.cell')
//                ->where('properties.agency_id', $id)
////                ->orwhere('properties.phone', '!=', null)
////                ->orWhere('properties.cell', '!=', null)
//                ->get()->first();
//            if ($records) {
//                if ($records->cell !== '' || $records->phone !== '') {
//                    echo $records->phone;
//                    echo PHP_EOL;
//                    echo $records->cell;
//                    echo PHP_EOL;
//                    echo $id;
//                    echo PHP_EOL;
//                    DB::table('agencies')
//                        ->where('id', $id)
//                        ->where('phone', '=', null)
//                        ->where('cell', '=', null)
//                        ->update([
//                            'phone' => $records->phone,
//                            'cell' => $records->cell
//                        ]);
//                }
//
//            } else
//                print('Not found' . $id);
//
//
//        }
//        $records = DB::table('agencies')->select('id', 'phone', 'cell')
//            ->where('id','>',6787)
//            ->where('phone', '=', null)
//            ->where('cell', '=', null)
//            ->get()->toArray();
//       foreach ($records as $r){
//           print($r->id);
//           echo PHP_EOL;
//       }

//        $records = DB::table('properties')->select('properties.id','properties.created_at')
//                ->where('properties.id', '>',104230)
//                ->where('properties.phone', '!=', null)
//                ->Where('properties.cell', '!=', null)->limit(10)
//                ->get();
//        dd($records);


//        $path = ('database/json');
//
//        if (is_dir($path)) {
//            if ($dh = opendir($path)) {
//                while (($file = readdir($dh)) !== false) {
//                    if ($file !== '.' && $file !== '..') {
//                        $strJsonFileContents = File::get('database/json/' . $file);
//                        $array = json_decode($strJsonFileContents, true);
//
//                        foreach ($array as $data) {
//                            if ($data['phone'] == '' && $data['mobile'] == '') {
//                                DB::table('properties')
//                                    ->where('id', $data['id'])
//                                    ->where('phone', '=', null)
//                                    ->where('cell', '=', null)
//                                    ->update([
//                                        'phone' => $data['phone'],
//                                        'cell' => $data['mobile']
//                                    ]);

//                                print($data['id'] . PHP_EOL);
//                            }


//                        }
//
//                        print('successfully read folder ' . $file . PHP_EOL);
//                    }
//                }
//            }
//            closedir($dh);
//        }


    }
}
