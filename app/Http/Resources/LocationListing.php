<?php


namespace App\Http\Resources;


class LocationListing
{
    public function myToArray($results)
    {
        $clean_results = array();

        foreach ($results as $item) {

            $clean_results[] = [
                'id' => $item->id,
                'location' => $item->name
            ];
        }

        return $clean_results;
    }
}
