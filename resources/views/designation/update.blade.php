@extends('layouts.base')

@section('content')

	<!-- Row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Expense Update</h3>
                </div>
                <div class="card-body pb-2">
                    <form action="{{ route('designationUpdate' , ['id'=>$designation->id]) }}" method="POST">
                        @csrf

                        <div class="col-md-12 mt-3">
                            <label class="label-control" for="name">Enter Designation</label>
                            <input type="text" class="form-control" name="name" id="name" required value="{{ $designation->name }}">
                            <span class="text-danger" id="nameErrorMsg"></span>
                        </div>

                        <div class="col-md-12 mt-4">
                            <button class="btn btn-primary">Update</button>
                        </div>
                    </form>
            </div>
    </div>
@endsection
