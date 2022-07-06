<?php

namespace App\Http\Controllers;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Models\StaffExpense;
use App\Models\User;
use App\Models\{City, Zone, Station};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\Notification;
use Auth;
use Carbon\Carbon;
class ManagerController extends Controller
{
    public function index() {
        $users = User::where('user_type',3)->get();
        $roles = Role::orderBy('name','ASC')->get();
        $staffexpenses = StaffExpense::all();
        return view('manager.index', compact('users','roles','staffexpenses'));
    }

    public function managerStore(Request $request)
    {
        $validate = $request->validate([
            'profile_photo_path' => ['required'],
            'firstname' => ['required'],
            'lastname' => ['required'],
            'email' => ['required'],
            'password' => ['required'],
            'phone_number' => ['required'],
            'address' => ['required'],
            'role'  =>  ['required']
         ]);
        $manager = new User();
        $imageName = time().'.'.$request->profile_photo_path->extension();
        $request->profile_photo_path->move(public_path('images/staff'), $imageName);
        $manager->profile_photo_path = $imageName;
        $manager->firstname = $request->firstname;
        $manager->lastname = $request->lastname;
        $manager->email = $request->email;
        $manager->phone_number = $request->phone_number;
        $manager->user_type = '3'; // 3 is for manager
        $manager->address = $request->address;
        $manager->password = Hash::make($request->password);
        $manager->save();
        $role = Role::findById($request->role);
        $data = $manager->assignRole($role);
        return back()->with('success', 'Manager has been added successfully!');
    }

    public function managerDelete($id)
    {
        $manager = User::find($id);
        $manager->delete();
        return back()->with('success', 'Manager has been deleted successfully!');
    }

    public function changeExpenseStatus(Request $request, $id)
    {

        // $cuser = auth()->user()->id;
        $user = User::where('line_manager', Auth::user()->firstname.Auth::user()->lastname)->select('fcm_token','firstname')->first();

        $staffExpense = StaffExpense::find($id);
        $staffExpense->status = $request->status;
        $staffExpense->save();
        if($user){
            $fcmtoken =$user->fcm_token;
            $notification['title'] = "Request from Manager";
            $notification['body'] = "Hi, '".$user->firstname."' your reques has been '".$request->status."'";

            if($fcmtoken) {
                $responsesms = Helpers::send_push_notif_to_device($fcmtoken,$notification);
                if($responsesms) {
                    $notif = new Notification;
                    $notif->type =  "Add Staff";
                    $notif->title = $notification['title'];
                    $notif->body = $notification['body'];
                    $notif->user_id = auth()->user()->id;
                    $notif->save();
                }
            }
        }
        return back()->with('success', 'Staff Expense status has been updated successfully!');
    }
    public function expenseRequest()
    {
        $users = User::where('user_type',3)->get();
        $roles = Role::orderBy('name','ASC')->get();
        foreach($users as $manager){
            $id[] = $manager->id;
        }
        // dd($id);
        $staffexpenses = StaffExpense::whereIn('user_id',$id)->orderBy('id','DESC')->get();

        return view('manager.rejectedExpenses', compact('users','roles','staffexpenses'));
    }
    public function managerStaff()
    {
        $staff = User::where('user_type', 2)->where('line_manager', Auth::user()->firstname.Auth::user()->lastname)->orderBy('firstname','ASC')->get();
        return view('manager.staffMember', compact('staff'));
    }
    public function managerStaffExpenseInGraph($id)
    {
        $salestaff = StaffExpense::where('expense_category','headquater')->select('expense_id','expense_category')->get();
        $totalUsers = User::all()->count();
        $totalCity = City::all()->count();
        $totalZone = Zone::all()->count();
        $totalStation = Station::all()->count();
        $staff = StaffExpense::where('status', 'Approved')->where('user_id', $id)->get();
        $staffCount = StaffExpense::count('expense_id');
        foreach($staff as $item){
            foreach(json_decode($item->expense_id) as $key => $expense){
                $expense_name[] = $expense->name;
                $expense_val[] = $expense->value;
                $sum = array_sum($expense_val);

                for ($i = 0; $i < 1; $i++){
                    $expense_value[$key][$i] = $sum;
                }

            }
        }
        function flatten(array $array) {
            $return = array();
            array_walk_recursive($array, function($a) use (&$return) { $return[] = $a; });
            return $return;
        }
        if(isset($expense_value)){
            $expenseValue = flatten($expense_value);
        }else{
            $expenseValue = null;
        }
        if(isset($expense_name)){
            $expenseName = collect($expense_name);
        }else{
            $expenseName = collect(['Nothing Available']);
        }
        $unique_expense_name = $expenseName->unique()->values()->all();
        return view('dashboard.index', compact('totalUsers', 'totalCity', 'totalZone', 'totalStation', 'salestaff', 'unique_expense_name', 'expenseValue'));
    }
}
