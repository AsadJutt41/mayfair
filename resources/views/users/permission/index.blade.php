@extends('layouts.base')
@push('style')

@endpush
@section('content')
<div class="card">
    <div class="card-header">
         <div class="col-md-12">
            <div class="row">
                <div class="col-md-10">
                    <div class="card-title">Role & Permission</div>
                </div>
                <div class="col-md-2">
                    <div>
                        <a href="{{route('role-permission.create')}}"> <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModel">Assign Role & Permission</button></a>
                    </div>
                </div>
            </div>
         </div>
    </div>
    <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-bordered text-nowrap key-buttons">
                    <thead>
                        <tr>
                          <th>
                            #
                          </th>
                          <th>
                            Role Name
                          </th>
                          <th>
                            Permission Name
                          </th>
                          <th  colspan="2">
                            Controls
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                       @foreach($rolepermissions as $key=>$rolepermission)
                        <tr>
                          <td class="py-1">
                              {{$key}}
                          </td>
                          <td>
                            @foreach ($rolepermission as $roles)
                                @php
                                    $roll = Spatie\Permission\Models\Role::find($roles->role_id);
                                @endphp
                            @endforeach
                            @if ($roll->name)
                            {{ $roll->name }}
                            @endif

                          </td>
                          </td>
                          <td>
                              @foreach ($rolepermission as $item)
                                  @php
                                      $permission = Spatie\Permission\Models\Permission::find($item->permission_id);
                                  @endphp
                                  {{ $permission->name }} ,
                              @endforeach
                          </td>
                           <td class="d-flex">
                                <a  href="{{route('role-permission.edit',$roles->role_id)}}"><i class="fa fa-edit" style="font-size: 22px; color: blue;margin-top:8px"></i></a>
                                @foreach ($rolepermission as $roles)
                                <form action="{{route('role-permission.destroy', $roles->role_id)}}" method="post" >
                                    @csrf
                                    @method('DELETE')
                                    @endforeach
                                <button type="submit" style="background: unset;padding: 0 6px 0px 0; border: none;"  onclick="return confirm('Are you sure you want to delete this Role & Permission ?')" style="border:none !important"><i class="mdi mdi-delete-forever" style="font-size:24px;color:red" ></i></button>
                                </form>
                          </td>
                        </tr>
                        @endforeach
                </table>
            </div>
    </div>
</div>

@endsection
