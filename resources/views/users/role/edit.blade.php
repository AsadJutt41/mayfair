@extends('layouts.base')
<meta name="csrf-token" content="{{ csrf_token() }}">
@push('style')
<style>
    li {
        list-style-type: none;
    }
</style>
@endpush
@section('content')
<div class="card">
    <div class="card-header">
         <div class="col-md-12">
            <div class="row">
                <div class="col-md-10">
                    <div class="card-title">Role Management</div>
                </div>

            </div>
         </div>
    </div>
    <div class="card-body">
        <div class="">
            <div class="table-responsive">

                <form  action="{{route('roles.update',$role->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="col-md-6 mt-3">
                        <label class="label-control" for="name">Enter Role Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"  id="name" value="{{$role->name}}" required>
                        @if($errors->has('name'))
                            <div style="color: red;">{{ $errors->first('name') }}</div>
                        @endif
                    </div>

                    <div class="col-md-12 mt-4">
                        <button class="btn btn-primary" id="formSubmit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
