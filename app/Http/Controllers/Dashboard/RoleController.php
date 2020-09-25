<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Dashboard\PropertyRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('role.index', ['table_name' => 'roles', 'table_data_values' => PropertyRole::all('id', 'name')]);
    }

    public function create()
    {
        return view('role.create', ['table_name' => 'roles']);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), PropertyRole::$rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Error storing record, try again.');
        }
        try {
            (New PropertyRole)->updateOrCreate(['name' => $request->input('name')], [
                'name' => lcfirst(str_replace(' ', '_', $request->input('name'))),
            ]);
            return view('role.index', ['table_name' => 'roles', 'table_data_values' => PropertyRole::all('id', 'name')]);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'No record stored, try again!');
        }
    }

    public function destroy(Request $request)
    {
        $role = (new PropertyRole)->find($request->input('record_id'));

        if ($role->exists) {
            try {
                $role->users()->detach();
                $role->delete();
                return redirect()->route('roles.index')->with('success', 'Record deleted successfully');

            } catch (\Exception $e) {
                return redirect()->route('roles.index')->with('error', 'Record not found');
            }
        }
        return redirect()->back()->with('error', 'Record not found');
    }

}
