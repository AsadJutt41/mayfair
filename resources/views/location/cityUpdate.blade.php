@extends('layouts.base')
@section('content')
    <!-- Row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">City Update</h3>
                </div>
                <div class="card-body pb-2">
                    <form action="{{route('cityUpdate',['id'=>$city->id])}}" method="POST">
                        @csrf
                        <div class="col-md-12 mt-4">
                            <label for="" class="label-control">City Name</label>
                            <input type="text" class="form-control" name="name" required value="{{ $city->name }}">
                            @if($errors->has('name'))
                                <div style="color: red;">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                        <div class="col-md-12 mt-4">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </form>
            </div>
    </div>
@endsection
