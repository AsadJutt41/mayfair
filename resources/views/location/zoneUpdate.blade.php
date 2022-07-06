@extends('layouts.base')
@section('content')
    <!-- Row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Zone Update</h3>
                </div>
                <div class="card-body pb-2">
                    <form action="{{route('zoneUpdate',['id'=>$zone->id])}}" method="POST">
                        @csrf
                        <div class="col-md-12 mt-4">
                            <label for="" class="label-control">Zone Name</label>
                            <input type="text" class="form-control" name="zone" required value="{{ $zone->zone }}">
                            @if($errors->has('zone'))
                                <div style="color: red;">{{ $errors->first('zone') }}</div>
                            @endif
                        </div>
                        <div class="col-md-12 mt-4">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </form>
            </div>
    </div>
@endsection
