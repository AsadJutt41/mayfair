@extends('layouts.base')

@section('content')

	<!-- Row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Station Update</h3>
                </div>
                <div class="card-body pb-2">
                    <form action="{{ route('stationUpdate' , ['id'=>$station->id]) }}" method="POST">
                        @csrf

                        <div class="col-md-12 mt-4">
                            <label for="name" class="label-control">Station Name</label>
                            <input type="name" class="form-control" name="name" required value="{{ $station->name }}">
                        </div>

                        <div class="col-md-12 mt-4">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </form>
            </div>
    </div>
@endsection
