
@extends('layouts.base')
<meta name="csrf-token" content="{{ csrf_token() }}">
@push('style')
<style>
    li {
        list-style-type: none;
    }
    button {
        border: none;
        background-color: transparent;
    }
</style>
@endpush
@section('content')
<div class="card">
    <div class="card-header">
         <div class="col-md-12">
            <div class="row">
                <div class="col-md-10">
                    <div class="card-title">Assign Role Permission</div>
                </div>
            </div>
         </div>
    </div>
    <div class="card-body">
            <form  action="{{route('role-permission.store')}}" method="post">
                @csrf
                <div class="row">
                <div class="col-md-6 mt-3">
                    <div class="form-group ">
                        <label class="form-label">Select Role</label>
                        <select class="form-control select2 custom-select" data-placeholder="Choose one" name="role_id">
                            <option label="Choose one">
                            </option>
                            @foreach ($roles as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('role_id'))
                            <div style="color: red;">{{ $errors->first('role_id') }}</div>
                        @endif
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <label class="form-label">Give Permission</label>
                        <select class="form-control select2" data-placeholder="Choose permission" multiple name="permission_id[]">
                            <option label="Choose permission">
                            </option>
                            @foreach ($permissions as $permission)
                            <option value="{{$permission->id}}">{{$permission->name}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('permission_id'))
                            <div style="color: red;">{{ $errors->first('permission_id') }}</div>
                        @endif
                    </div>
                </div>
                </div>

                <div class="col-md-12 mt-4">
                    <button class="btn btn-primary" id="formSubmit">Submit</button>
                </div>
            </form>
    </div>
</div>

@endsection
