<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {
         $rolepermissions = DB::table('role_has_permissions')
         ->select('role_id', 'permission_id')->get()
         ->groupBy(function($data){
             return $data->role_id;
         });
        return view('users.permission.index',compact('rolepermissions'));
    }

    public function create()
    {
        $roles=Role::orderBy('name','ASC')->get();
        $permissions=Permission::orderBy('name','ASC')->get();
        return view('users.permission.create',compact('roles','permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_id' => 'required',
            'permission_id' => 'required',
        ]);
        $role = Role::findOrFail($request->role_id);
        $role->givePermissionTo($request->permission_id);
        return redirect()->route('role-permission.index')->with('success','Role and Permission has been added successfully');

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $permissiondata = Role::where('id',$id)->with('permissions')->first();
        $roles= Role::all();
        $permissions = Permission::all();
        $roldid = $id;
        return view('users.permission.edit',compact('roles','permissions','permissiondata','roldid'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'role_id' => 'required',
            'permission_id' => 'required',
        ]);
        $role = Role::findOrFail($id);
        $role->syncPermissions($request->permission_id);
        return redirect()->route('role-permission.index')->with('success','Role and Permission has been updated successfully');
    }

    public function destroy($id)
    {
        try {
            if($id==1){
                    return back()->with('error','You dont have delete the admin permission ');
                }else{
                    $rolepermissions = DB::table('role_has_permissions')->where('role_id',$id);
                }
        } catch(\Exception $exception){
            return redirect()->route('role-permission.index')->with('delete_role', 'No Role and Permission Deleted  to de!' . $exception->getCode());
        }

        $result = $rolepermissions->delete();
        if ($result) {
            $Page_response['result'] = true;
            return redirect()->route('role-permission.index')->with('success', 'Role and Permission has been  deleted successfully.');

        } else {
            $Page_response['result'] = false;
            return redirect()->route('role-permission.index')->with('delete_role', 'Role and Permission  not deleted, Try again!');

        }
    }
}
