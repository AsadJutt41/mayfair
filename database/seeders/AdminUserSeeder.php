<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;
use Spatie\Permission\Models\Permission;
use DB;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        //create role if role is not exist
        $role = Role::where('name','admin')->first();
        if ($role === null) {
            $role = Role::updateOrCreate(['name' => 'admin']);
        }
        //create user as a admin if not exist
        $checkuser = User::where('firstname', 'admin')->first();
        if ($checkuser === null) {
            $admin= new User();
            $admin->firstname="admin";
            $admin->email="admin@gmail.com";
            $admin->role="admin";
            $admin->user_type = 2;
            $admin->phone_number = "03445853814";
            $admin->password= Hash::make('password');
            $admin->save();
        }
        //assign role to the admin
        $user= User::where('firstname', 'admin')->first();
        $user->assignRole($role);
        //give permission to the admin
        $permission = Permission::updateOrCreate(['name' => 'Admin Access']);
        $rolemodel =DB::table('model_has_roles')->where('model_id',1)->first();
        if ($rolemodel === null) {
            DB::table('model_has_roles')->insert([
                [
                    'role_id' => 1,
                    'model_type' => 'App\Models\User',
                    'model_id' => 1,
                ],
            ]);
        }

        //create new user manager
        $checkuser = User::where('user_type', 3)->first();
        if ($checkuser === null) {
            $admin= new User();
            $admin->firstname="manager";
            $admin->email="manager@gmail.com";
            $admin->role="manager";
            $admin->user_type = 3;
            $admin->phone_number = "03445853814";
            $admin->password= Hash::make('password');
            $admin->save();
        }



        //role has permission
        DB::table('role_has_permissions')
        ->updateOrInsert(
            ['permission_id' => '1', 'role_id' => '1'],
        );
        //give permission to user
        $permission = Permission::updateOrCreate(['name' => 'Expense Management']);
        $permission = Permission::updateOrCreate(['name' => 'User Management']);
        $permission = Permission::updateOrCreate(['name' => 'Staff Management']);
        $permission = Permission::updateOrCreate(['name' => 'Manager Management']);
        $permission = Permission::updateOrCreate(['name' => 'Cites']);
        $permission = Permission::updateOrCreate(['name' => 'Zone']);
        $permission = Permission::updateOrCreate(['name' => 'Fuel Rates']);
        $permission = Permission::updateOrCreate(['name' => 'Distance Management']);
        $permission = Permission::updateOrCreate(['name' => 'Add Stations']);
        $permission = Permission::updateOrCreate(['name' => 'Calender Management']);
        $permission = Permission::updateOrCreate(['name' => 'Designation Management']);


    }

}
