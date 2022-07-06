<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Fortify;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Zone;

class HomeController extends Controller
{
    public function index()
    {
        $totalUsers = User::all()->count();
        if(Auth::check()){
            $totalUsers = User::all()->count();
            $totalCity = City::all()->count();

            $totalZone = Zone::all()->count();
            $totalStation = Station::all()->count();
            return view('dashboard.index', compact('totalUsers','totalUsers', 'totalCity', 'totalZone', 'totalStation'));
        }else{
            return redirect()->route('login');
        }
        $user = Auth::user();
        $user_permissions=[];

        foreach($user->roles as $role){
            foreach($role->permissions as $permission){
                $user_permissions[] = $permission->name;
            }
        }

        if (in_array("Expense Management", $user_permissions)){
            return redirect()->route('expense');
        } elseif (in_array("User Management", $user_permissions)){
            return redirect()->route('users');
        } elseif (in_array("Staff Management", $user_permissions)){
            return redirect()->route('staff');
        } elseif (in_array("Manager Management", $user_permissions)){
            return redirect()->route('manager');
        } elseif (in_array("Admin Access", $user_permissions)){
            return redirect()->route('dashboard');
        } elseif (in_array("Cites", $user_permissions)){
            return redirect()->route('city');
        } elseif (in_array("Zone", $user_permissions)){
            return redirect()->route('zone');
        } elseif (in_array("Fuel Rates", $user_permissions)){
            return redirect()->route('fuelRates');
        } elseif (in_array("Distance Management", $user_permissions)){
            return redirect()->route('distance');
        } elseif (in_array("Add Stations", $user_permissions)){
            return redirect()->route('station');
        } elseif (in_array("Designation Management", $user_permissions)){
            return redirect()->route('designation');
        } elseif (in_array("Main Dashboard", $user_permissions)){
            return redirect()->route('dashboard');
        } else {
            Auth::logout();
            return redirect()->route('login')->with('permission-error',"Sorry, You haven't assign any Permission by Admin");
        }

        if(Auth::check() ){
            return view('dashboard.index', compact('totalUsers'));
        } else {
            return  redirect(Fortify::redirects('logout', '/login'));
        }
    }
}
