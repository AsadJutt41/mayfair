@extends('layouts.base')

@section('content')

	<!-- Row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Fuel Rate Update</h3>
                </div>
                <div class="card-body pb-2">

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <p><strong>Opps Something went wrong</strong></p>
                            <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('fuelRateUpdate' , ['id'=>$fuelRate->id]) }}" method="POST">
                        @csrf

                        <div class="col-md-12 mt-4">
                            <label for="" class="label-control">Price</label>
                            <input type="number" class="form-control" name="price"  value="{{ $fuelRate->price }}">
                        </div>

                        <div class="col-md-12 mt-4">
                            {{--  <label for="month" class="label-control">Month</label>
                            <select name="month" id="month" class="form-control" required>
                                <option selected disabled>Select Month</option>
                                <option value="1"  {{ $fuelRate->month==1 ? 'selected' : '' }}>January</option>
                                <option value="2"  {{ $fuelRate->month==2 ? 'selected' : '' }}>February</option>
                                <option value="3"  {{ $fuelRate->month==3 ? 'selected' : '' }}>March</option>
                                <option value="4"  {{ $fuelRate->month==4 ? 'selected' : '' }}>April</option>
                                <option value="5"  {{ $fuelRate->month==5 ? 'selected' : '' }}>May</option>
                                <option value="6"  {{ $fuelRate->month==6 ? 'selected' : '' }}>June</option>
                                <option value="7"  {{ $fuelRate->month==7 ? 'selected' : '' }}>July</option>
                                <option value="8"  {{ $fuelRate->month==8 ? 'selected' : '' }}>August</option>
                                <option value="9"  {{ $fuelRate->month==9 ? 'selected' : '' }}>September</option>
                                <option value="10"  {{ $fuelRate->month==10 ? 'selected' : '' }}>October</option>
                                <option value="11"  {{ $fuelRate->month==11 ? 'selected' : '' }}>November</option>
                                <option value="12"  {{ $fuelRate->month==12 ? 'selected' : '' }}>December</option>
                            </select>  --}}
                            <label for="fuel_date" class="label-control">Date</label>
                            <input type="date" class="form-control" name="fuel_date" id="fuel_date"  :value="old('fuel_date')"  value="{{ $fuelRate->fuel_date }}" >
                            <span class="text-danger" id="fuel_dateMsg"></span>
                        </div>

                        <div class="col-md-12 mt-4">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </form>
            </div>
    </div>
@endsection
