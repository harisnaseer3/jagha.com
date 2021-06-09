<?php

namespace App\Http\Controllers\Package;

use App\Http\Controllers\Controller;
use App\Models\PackagePrice;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminPackagePriceController extends Controller
{
    static function index()
    {
        return view('website.admin-pages.package.package_price_listing', [
            'packages' => self::prepareData(PackagePrice::all()),
        ]);
    }

    public function edit(PackagePrice $price)
    {
        return view('website.admin-pages.package.package_price_form', [
            'package' => $price,
        ]);
    }

    public function update(PackagePrice $price, Request $request)
    {
        try {
            $price->price_per_unit = $request->price;
            $price->save();


        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Error Please Try Again ' . '.');

        }
        return redirect()->route('admin.package.price.index')->with('success', 'Price Updated Successfully' . '.');


    }

    public static function prepareData($date)
    {
        $list = array();
        foreach ($date as $value) {
            $list[] = [
                'type' => ucwords($value->type),
                'for' => ucwords($value->package_for),
                'price' => number_format($value->price_per_unit),
                'at' => $value->updated_at == null ? (new Carbon($value->created_at))->Format('M d, Y') : (new Carbon($value->updated_at))->Format('M d, Y'),
                'link' => $value->id
            ];

        }
        return $list;
    }

}
