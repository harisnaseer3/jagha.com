<?php

namespace App\Http\Controllers;

use App\Models\AgencyLog;
use Illuminate\Support\Facades\Auth;

class AgencyLogController extends Controller
{

    public function store($agency)
    {
        (new AgencyLog)->create([
            'admin_id' => Auth::guard('admin')->user()->getAuthIdentifier(),
            'admin_name' => Auth::guard('admin')->user()->name,
            'agnecy_id' => $agency->id,
            'status' => $agency->status,
            'rejection_reason' => $agency->rejection_reason,
        ]);
    }

    public function show(AgencyLog $agencyLog)
    {
        //
    }


}
