<?php

use App\Models\Property;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateExpiryColumn extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = Property::all();
        foreach ($data as $column) {
            $dt = Carbon::parse($column->created_at);
            $expiry = $dt->addMonths(3)->toDateTimeString();
            $column->expired_at = $expiry;
            $column->save();
            echo $column->id;
        }
    }
}
