<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = \App\Models\Property::
        select('id', 'phone', 'cell')
            ->where('properties.id', '>', 173092)->get();
        foreach ($data as $row) {


//            $phone = '';
            if ($row->phone) {
                print($row->id);
                $phone = $this->str_lreplace(', ', '', $row->phone);
                $row->phone = $phone;
                $row->update();
                print($phone);
            }
//            $cell = '';
            if ($row->cell) {
                print($row->id);
                $cell = $this->str_lreplace(', ', '', $row->cell);
                $row->cell = $cell;
                $row->update();
                print($cell);
            }

        }
    }

    public function str_lreplace($search, $replace, $subject)
    {
        $pos = strrpos($subject, $search);

        if ($pos !== false) {
            $subject = substr_replace($subject, $replace, $pos, strlen($search));
        }

        return $subject;
    }

}
