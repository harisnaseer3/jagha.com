<?php

namespace App\Http\Controllers;

use App\Models\PropertyLog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyLogController extends Controller
{

    public function index()
    {
        //
    }

    public function store($property)
    {
        (new PropertyLog)->create([
            'admin_id' => Auth::guard('admin')->user()->getAuthIdentifier(),
            'admin_name' => Auth::guard('admin')->user()->name,
            'property_id' => $property->id,
            'status' => $property->status,
            'rejection_reason' => $property->rejection_reason,
        ]);
    }


    public function show()
    {

    }

}
