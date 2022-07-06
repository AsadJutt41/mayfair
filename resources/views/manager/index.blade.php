@extends('layouts.base')
@push('style')
  <style>
    .required {
        color: red;
      }
  </style>
@endpush
@section('content')
<div class="card">
    <div class="card-header">
         <div class="col-md-12">
            <div class="row">
                <div class="col-md-10">
                    <div class="card-title">All Managers</div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#managerModel">Add New Manager</button>
                </div>
            </div>
         </div>
    </div>
    <div class="card-body">
        <div class="">
            <div class="table-responsive">
                @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    @foreach ($errors->all() as $error)
                        <ul>
                            <li>{{$error}}</li>
                        </ul>
                    @endforeach
                </div>
                @endif
                <table id="example" class="table table-bordered text-nowrap key-buttons">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">No #</th>
                            <th class="border-bottom-0">Image</th>
                            <th class="border-bottom-0">Manager Name</th>
                            <th class="border-bottom-0">Email</th>
                            <th class="border-bottom-0">Phone Number</th>
                            <th class="border-bottom-0">Address</th>
                            <th class="border-bottom-0">Controls</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($users as $item)
                            <tr>
                                <td>@php echo $i++ @endphp</td>
                                <td><img src={{ asset('/images/staff') }}/{{ $item->profile_photo_path }} style="height: 100px; width: 95px; border-radius: 10px;" /></td>
                                <td>{{ $item->firstname }}{{ $item->lastname }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->phone_number }}</td>
                                <td>{{ $item->address }}</td>
                                <td>
                                    <a href="{{ route('managerDelete', ['id'=>$item->id]) }}" class="delete-confirm"><i class="fa fa-trash" style="font-size: 27px; color: red; margin-left: 10px;"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="managerModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Manager Model</h5>
                <button type="button" class="btn-close btn-close-blue" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-window-close" aria-hidden="true" style="color:blue"></i></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('managerStore') }}" enctype="multipart/form-data" method="POST">
                    @csrf

                    <div class="row mt-2">
                        <div class="col-md-12">
                            <label for="" class="label-control">Profile Imagge <span class="required"> * </span></label>
                            <input type="file" class="form-control" accept="image/*" name="profile_photo_path" id="profile_photo_path" required onchange="loadFile(event)">
                            <img id="output" style="height: 150px; width: 150px; border-radius: 25px; border: none; margin-top: 10px;"/>
                            <span class="text-danger" id="photoErrorMsg"></span>
                            @if($errors->has('profile_photo_path'))
                                <div style="color: red;">{{ $errors->first('profile_photo_path') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="" class="label-control">First Name <span class="required"> * </span></label>
                            <input type="text" class="form-control" name="firstname" id="firstname" required :value="old('firstname')">
                            <span class="text-danger" id="firstErrorMsg"></span>
                            @if($errors->has('firstname'))
                                <div style="color: red;">{{ $errors->first('firstname') }}</div>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <label for="" class="label-control">Last Name <span class="required"> * </span></label>
                            <input type="text" class="form-control" name="lastname" id="lastname" required :value="old('lastname')">
                            <span class="text-danger" id="lastErrorMsg"></span>
                            @if($errors->has('lastname'))
                                <div style="color: red;">{{ $errors->first('lastname') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="" class="label-control">Email <span class="required"> * </span></label>
                            <input type="email" class="form-control" name="email" id="email" required :value="old('email')">
                            <span class="text-danger" id="emailErrorMsg"></span>
                            @if($errors->has('email'))
                                <div style="color: red;">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <label for="" class="label-control">Phone Number <span class="required"> * </span></label>
                            <input type="number" class="form-control" name="phone_number" id="phone_number" required :value="old('phone_number')">
                            <span class="text-danger" id="phoneErrorMsg"></span>
                            @if($errors->has('phone_number'))
                                <div style="color: red;">{{ $errors->first('phone_number') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <label class="label-control" for="name">User Role <span class="required"> * </span></label>
                            <select  class="form-control" name="role">
                                <option label="select role"></option>
                                @foreach ($roles as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                                @endforeach
                            </select>
                            @if($errors->has('role'))
                                <div style="color: red;">{{ $errors->first('role') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <label for="" class="label-control">Address <span class="required"> * </span></label>
                            <input type="text" class="form-control" name="address" id="address" required :value="old('address')">
                            <span class="text-danger" id="addressErrorMsg"></span>
                            @if($errors->has('address'))
                                <div style="color: red;">{{ $errors->first('address') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <label for="" class="label-control">Password <span class="required"> * </span></label>
                            <input type="password" class="form-control" name="password" id="password" required :value="old('password')">
                            <span class="text-danger" id="passErrorMsg"></span>
                            @if($errors->has('password'))
                                <div style="color: red;">{{ $errors->first('password') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12 mt-4">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
        jQuery(document).ready(function(){

            $(".flex-wrap").css('display', 'none');
        });
    </script>
@endpush
