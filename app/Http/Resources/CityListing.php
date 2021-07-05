<?php


namespace App\Http\Resources;


class CityListing
{
    public function myToArray($results)
    {
        $clean_results = array();

        foreach ($results as $item) {

            $clean_results[] = [
                'id' => $item->id,
                'city' => $item->name
            ];
        }

        return $clean_results;
    }

}
