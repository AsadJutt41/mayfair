<?php

namespace App\Http\Controllers;

use App\Helper\StaffImportCsv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\City;
use App\Models\Zone;
use App\Models\StaffRole;
use App\Models\Allocation;
use App\Models\Expense;
use App\Models\Designation;
use DB;

class StaffController extends Controller
{
    public function index()
    {
        $cities = City::orderBy('name','ASC')->get();
        $zone = zone::orderBy('zone','ASC')->get();
        $staffRole = StaffRole::orderBy('role','ASC')->get();
        $staff = User::where('user_type',2)->orderBy('firstname','ASC')->get();
        $manager = User::where('user_type',3)->orderBy('firstname','ASC')->get();
        $designations = Designation::orderBy('name','ASC')->get();
        return view('staff.index')->with([
            'staffRole' => $staffRole,
            'staff' => $staff,
            'cities' => $cities,
            'zone' => $zone,
            'designations' => $designations,
            'manager' => $manager,
        ]);
    }
    public function dateFilterSaleStaff(Request $request)
    {
        $cities = City::orderBy('name','ASC')->get();
        $zone = zone::orderBy('zone','ASC')->get();
        $staffRole = StaffRole::orderBy('role','ASC')->get();
        $manager = User::where('user_type',3)->orderBy('firstname','ASC')->get();
        $designations = Designation::orderBy('name','ASC')->get();
        $staff = User::where('user_type',2)->whereBetween('joining_date', [$request->start_date, $request->end_date])->orderBy('firstname','ASC')->get();
        return view('staff.index')->with([
            'staffRole' => $staffRole,
            'staff' => $staff,
            'cities' => $cities,
            'zone' => $zone,
            'designations' => $designations,
            'manager' => $manager,
         ]);
    }

    public function staffStore(Request $request)
    {
        $validate = $request->validate([
            'profile_photo_path' => ['required'],
            'firstname' => ['required'],
            'lastname' => ['required'],
            'email' => ['required','unique:users'],
            'password' => ['required'],
            'phone_number' => ['required','numeric',''],
            'designation' => ['required'],
            'role' => ['required'],
            'over_limit_approver' => ['required'],
            'sap_id' => ['required'],
            'joining_date' => ['required'],
            'base_town' => ['required'],
            'zone' => ['required'],
            'address' => ['required'],
        ]);
        $staff = new User();
        $imageName = time().'.'.$request->profile_photo_path->extension();
        $request->profile_photo_path->move(public_path('assets/images/users/'), $imageName);

        $staff->profile_photo_path = $imageName;
        $staff->firstname = $request->firstname;
        $staff->lastname = $request->lastname;
        $staff->email = $request->email;
        $staff->phone_number = $request->phone_number;
        $staff->designation = $request->designation;
        $staff->role = $request->role;
        $staff->user_type = 2;
        $staff->line_manager = $request->line_manager;
        $staff->over_limit_approver = $request->over_limit_approver;
        $staff->sap_id = $request->sap_id;
        $staff->joining_date = $request->joining_date;
        $staff->base_town = $request->base_town;
        $staff->zone = $request->zone;
        $staff->address = $request->address;
        $staff->password = Hash::make($request->password);
        $staff->save();
        return back()->with('success', "Staff member has been added succesfully!");
    }
    public function staffEdit($id)
    {
        $staff = User::find($id);
        $users = User::where('user_type', 2)->get();
        $cities = City::orderBy('name','ASC')->get();
        $zone = zone::orderBy('zone','ASC')->get();
        $staffRole = StaffRole::orderBy('role','ASC')->get();
        return view('staff.staffEdit')->with([
            'staffRole' => $staffRole,
            'staff' => $staff,
            'users' => $users,
            'cities' => $cities,
            'zone' => $zone,
        ]);
    }
    public function staffUpdate(Request $request, $id)
    {
        $staff = User::find($id);
        if($request->profile_photo_path){
            $imageName = time().'.'.$request->profile_photo_path->extension();
            $request->profile_photo_path->move(public_path('assets/images/users/'), $imageName);

            $staff->profile_photo_path = $imageName;
        }


        $staff->firstname = $request->firstname;
        $staff->lastname = $request->lastname;
        $staff->email = $request->email;
        $staff->designation = $request->designation;
        $staff->role = $request->role;
        $staff->user_type = 2;
        $staff->line_manager = $request->line_manager;
        $staff->over_limit_approver = $request->over_limit_approver;
        $staff->sap_id = $request->sap_id;
        $staff->joining_date = $request->joining_date;
        $staff->base_town = $request->base_town;
        $staff->zone = $request->zone;
        $staff->address = $request->address;
        $staff->save();
        return back()->with('success', "Staff member has been updated succesfully!");
    }
    public function staffDelete($id)
    {
        $staff = User::find($id);
        $staff->delete();
        return back()->with('success', "Staff member has deleted succesfully!");
    }

    /****Staff Role Part ****/
    public function role()
    {
        $roles = StaffRole::all();
        return view('staff.role', compact('roles'));
    }
    public function roleStore(Request $request)
    {
        $validate = $request->validate([
            'role' => ['required','unique:users']
        ]);
        $role = new StaffRole();
        $role->role = $request->role;
        $role->save();
        return back()->with('success', "Role has been added succesfully!");
    }
    public function roleEdit(Request $request, $id)
    {

        $role = StaffRole::find($id);
        return view('staff.roleEdit', compact('role'));
    }
    public function roleUpdate(Request $request, $id)
    {
        $validate = $request->validate([
            'role' => ['required']
        ]);
        $role = StaffRole::find($id);
        $role->role = $request->role;
        $role->save();
        return back()->with('success', "Role has been updated succesfully!");
    }
    public function roleDelete($id)
    {
        $role = StaffRole::find($id);
        $role->delete();
        return back()->with('success', "Role has been deleted succesfully!");
    }


    public function allocationExpense()
    {
        $allocation = Expense::orderBy('name','ASC')->get();
        // $uniqueCollection = $allocation->unique( 'name');
        // $uniqueCollection->all();
        // dd($uniqueCollection);

        // foreach($allocation as $item){
        //     $name[] = $item['name'];
        //     $value[] = collect($item['value'])->sum();

        // }
        return view('staff.allocationExpense', compact('allocation'));
    }
    public function allocationStore(Request $request)
    {
        $validate = $request->validate([
            'role' => ['required'],
            'expense_id' => ['required'],
        ]);
        foreach($request->expenseid as $data)
        {
            $dat[] = $data;
        }

        foreach($dat as $da){
            $allocation = new Allocation();
            $allocation->role = $request->role;
            $allocation->expense_id = $da;
            $allocation->save();
        }

        return back()->with('success', 'Allocation sale expense has been added successfully!');
    }

    public function importStaff(Request $request) {
        return view('staff.import_staff');
    }

    public function importStaffSave(Request $request) {
        $validated = $request->validate([
            'file' => 'required|max:50000|mimes:csv,xlsx,txt',
            ],
            [
            'file.required' => 'Please choose the file first.',
        ]);

        $staffHelper = new StaffImportCsv($request->file('file'));
        $response = $staffHelper->importCsv();
        if ($response) {
            return redirect()->route('staff')->with(['succesmsg' => $staffHelper->getSuccessCount() . ' Staff inserted successfully...', 'errorcsv' => $staffHelper->getErrors()]);
        }
        return redirect()->back()->with(['errorcsv' => $staffHelper->getErrors()]);
    }

}
