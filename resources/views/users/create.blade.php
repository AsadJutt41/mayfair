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
                    <div class="card-title">Create User</div>
                </div>
            </div>
         </div>
    </div>
    <div class="card-body">
        <div class="">
                <form action="{{route('store.user')}}" method="post" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mt-3">
                            <label class="label-control" for="name">Enter User Name <span class="required"> * </span></label>
                            <input type="text" class="form-control" name="name" required :value="old('name')">
                            @if($errors->has('name'))
                                <div style="color: red;">{{ $errors->first('name') }}</div>
                            @endif
                        </div>

                        <div class="col-md-6 mt-3">
                            <label class="label-control" for="email">Enter User Email <span class="required"> * </span></label>
                            <input type="email" class="form-control" name="email" required :value="old('email')">
                            @if($errors->has('email'))
                                <div style="color: red;">{{ $errors->first('email') }}</div>
                            @endif
                        </div>

                        <div class="col-md-6 mt-3">
                            <label class="label-control" for="name">Enter Phone Number <span class="required"> * </span></label>
                            <input type="tel" class="form-control" name="phone" required :value="old('phone')">
                            @if($errors->has('phone'))
                                <div style="color: red;">{{ $errors->first('phone') }}</div>
                            @endif
                        </div>


                        <div class="col-md-6 mt-3">
                            <label class="label-control" for="password">Enter User Password <span class="required"> * </span></label>
                            <input type="password" class="form-control" name="password" required :value="old('password')" autocomplete="new-password">
                            @if($errors->has('password'))
                                <div style="color: red;">{{ $errors->first('password') }}</div>
                            @endif
                        </div>

                        <div class="col-md-12 mt-3">
                            <label class="label-control" for="name">User Role <span class="required"> * </span></label>
                            <select  class="form-control" name="role">
                                <option label="Select User Role"></option>
                                @foreach ($roles as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                                @endforeach
                            </select>
                            @if($errors->has('role'))
                                <div style="color: red;">{{ $errors->first('role') }}</div>
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

@endsection

