@extends('layouts.base')

@section('content')

	<!-- Row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Calendar Update</h3>
                </div>
                <div class="card-body pb-2">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('calanderUpdate', ['id'=>$calander->id]) }}" method="POST">
                        @csrf

                        <div class="col-md-12 mt-4">
                            <label for="date_to" class="label-control">To</label>
                            <input type="date" class="form-control" name="date_to" required value="{{ $calander->date_to }}">
                        </div>

                        <div class="col-md-12 mt-4">
                            <label for="" class="label-control">From</label>
                            <input type="date" class="form-control" name="date_from" required value="{{ $calander->date_from }}">
                        </div>

                        <div class="col-md-12 mt-4">
                            <label for="date_to" class="label-control">Desc</label>
                            <input type="text" class="form-control" name="desc" required value="{{ $calander->desc }}">
                        </div>

                        <div class="col-md-12 mt-4">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </form>
            </div>
    </div>
@endsection
