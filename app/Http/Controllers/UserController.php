<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\StaffExpense;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('user_type',1)->get();
        $roles = Role::orderBy('name','ASC')->get();
        return view('users.index', compact('users','roles'));
    }

    public function addUser() {
        $roles = Role::orderBy('name','ASC')->get();
        return view('users.create', compact('roles'));
    }

    public function storeUser(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'phone' => 'required',
            'password' => 'required',
            'role' => 'required',
        ]);

        $validated = $validator->validated();
        $user=New User;
        $user->firstname = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone;
        $user->user_type = '1';
        $user->password=Hash::make($request->password);

        $user->save();
        $role=Role::findById($request->role);
        $data = $user->assignRole($role);
        return redirect()->route('users')->with('success','User has been added successfully');
    }

    public function editUser($id) {
        $user = User::find($id);
        $userRole= $user->roles->value('name');
        $roles = Role::All();
        return view('users.edit', compact('user','roles','userRole'));
    }

    public function updateUser(Request $request,  $id) {


        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'password' => 'required',
            'role' => 'required',
        ]);

        $validated = $validator->validated();
        $user = User::find($id);
        $user->firstname = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone;
        $user->user_type = '1';
        $user->password=Hash::make($request->password);

        $user->save();
        $role=Role::findById($request->role);
        $data = $user->assignRole($role);
        return redirect()->route('users')->with('success','User has been updated successfully');
    }


    public function roles()
    {
        return view('users.role');
    }
    public function rolePermission()
    {
        return view('users.rolePermission');
    }

    public function storeDelete($id) {
        $user = User::find($id)->delete();
        if($user) {
            return redirect()->back()->with('success','User has been deleted successfully');
        }
    }
}
