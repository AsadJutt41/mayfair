@extends('layouts.base')

@section('content')

	<!-- Row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Role Update</h3>
                </div>
                <div class="card-body pb-2">
                    <form action="{{ route('roleUpdate', ['id'=>$role->id]) }}" method="POST">
                        @csrf

                        <div class="col-md-12 mt-4">
                            <label for="role" class="label-control">Role</label>
                            <input type="text" class="form-control" name="role" required value="{{ $role->role }}">
                            @if($errors->has('role'))
                                <div style="color: red;">{{ $errors->first('role') }}</div>
                            @endif
                        </div>

                        <div class="col-md-12 mt-4">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </form>
            </div>
    </div>
@endsection
