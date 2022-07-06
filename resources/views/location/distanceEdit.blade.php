@extends('layouts.base')
@section('content')
    <!-- Row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Distance Update</h3>
                </div>
                <div class="card-body pb-2">
                    <form action="{{ route('distanceUpdate', ['id'=>$distance->id]) }}">
                        @csrf

                        <div class="col-md-12 mt-4">
                            <label for="" class="label-control">City From</label>
                            <select name="city_from" id="city_from" class="form-control">
                                <option selected disabled>Select City From</option>
                                @foreach ($cities as $item)
                                    <option value="{{ $item->name }}" {{ ( $item->name == $distance->city_from) ? 'selected' : '' }} >{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('city_from'))
                                <div style="color: red;">{{ $errors->first('city_from') }}</div>
                            @endif
                        </div>

                        <div class="col-md-12 mt-4">
                            <label for="" class="label-control">City To</label>
                            <select name="city_to" id="city_to" class="form-control">
                                <option selected disabled>Select City To</option>
                                @foreach ($cities as $item)
                                    <option value="{{ $item->name }}" {{ ( $item->name == $distance->city_to) ? 'selected' : '' }} >{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('city_to'))
                                <div style="color: red;">{{ $errors->first('city_to') }}</div>
                            @endif
                        </div>

                        <div class="col-md-12 mt-4">
                            <label for="" class="label-control">Kilometer</label>
                            <input type="number" class="form-control" name="kilometer" id="kilometer" required value="{{ $distance->kilometer }}">
                            @if($errors->has('kilometer'))
                                <div style="color: red;">{{ $errors->first('kilometer') }}</div>
                            @endif
                        </div>

                        <div class="col-md-12 mt-4">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </form>
            </div>
    </div>
@endsection
