@extends('layouts.base')

@section('content')
<div class="row">

    @if(Session::has('succesmsg'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get('succesmsg') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if(Session::has('errorcsv') && !empty(Session::get('errorcsv')))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <p>These records are not inserted in database</p>
            <ul>
                @foreach(Session::get('errorcsv') as $error)

                <li style="padding: 5px;">{{$error['errorMessage']}}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="col-lg-10 col-md-10">
           <div class="card-header">
                <h3 class="card-title">Upload City Csv File</h3>
            </div>
            <div class=" card-body">
                <div class="row">
                    <div class="col-md-12">
                        <label style="min-width: 275px;">File upload(csv,xlsx) <i class="text-danger">*</i> <a href="{{url('/csv-template/city.csv')}}" target="_blank">Download Sample CSV</a></label>

                        <form  method="POST" action="{{route('import.city_save')}}" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="file" class="dropify" data-height="180" />
                            <button type="submit" class="btn btn-primary">Submit File</button>
                        </form>
                    </div>
                </div>
            </div>
    </div>
</div>

@endsection
@push('scripts')

@endpush
