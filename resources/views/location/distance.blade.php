@extends('layouts.base')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-10">
                        <div class="card-title">Distance Managment</div>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#distanceModel">Add New Distance</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="table-responsive">
                    <table id="example" class="table table-bordered text-nowrap key-buttons">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">No #</th>
                                <th class="border-bottom-0">Date</th>
                                <th class="border-bottom-0">City From</th>
                                <th class="border-bottom-0">City To</th>
                                <th class="border-bottom-0">Distance in Kilometer</th>
                                <th class="border-bottom-0">Controls</th>
                            </tr>
                        </thead>
                        <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($distance as $item)
                                    <tr>
                                        <td>@php echo $i++; @endphp</td>
                                        <td>{{  \Carbon\Carbon::parse($item->created_at)->format('j-F-Y') }}</td>
                                        <td>{{ $item->city_from }}</td>
                                        <td>{{ $item->city_to }}</td>
                                        <td>{{ $item->kilometer }}</td>
                                        <td>
                                            <a href="{{ route('distanceEdit', ['id'=>$item->id]) }}"><i class="fa fa-edit" style="font-size: 22px; color: blue;"></i></a>
                                            <a href="{{ route('distanceDelete', ['id'=>$item->id]) }}" class="delete-confirm"><i class="fa fa-trash" style="font-size: 22px; color: red; margin-left: 10px;"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                        </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>

<!-- Modal -->
<div class="modal fade" id="distanceModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Distance Model</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- <form id="distanceForm"> --}}
                    <form action="{{ route('distanceStore') }}" method="POST">
                    @csrf

                    <div class="col-md-12 mt-4">
                        <label for="" class="label-control">City From</label>
                        <select name="city_from" id="city_from" class="form-control">
                            <option selected disabled>Select City From</option>
                            @foreach ($cities as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger" id="city_fromErrorMsg"></span>
                    </div>

                    <div class="col-md-12 mt-4">
                        <label for="" class="label-control">City To</label>
                        <select name="city_to" id="city_to" class="form-control">
                            <option selected disabled>Select City To</option>
                            @foreach ($cities as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger" id="city_toErrorMsg"></span>
                    </div>

                    <div class="col-md-12 mt-4">
                        <label for="" class="label-control">Kilometer</label>
                        <input type="number" class="form-control" name="kilometer" id="kilometer" required :value="old('kilometer')">
                        <span class="text-danger" id="kilometerErrorMsg"></span>
                    </div>

                    <div class="col-md-12 mt-4">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">

    $('#distanceForm').on('submit',function(e){
        e.preventDefault();

        let city_from = $('#city_from').val();
        let city_to = $('#city_to').val();
        let kilometer = $('#kilometer').val();

        $.ajax({
        url: "/admin/distance/store",
        type:"POST",
        data:{
            "_token": "{{ csrf_token() }}",
            city_from:city_from,
            city_to:city_to,
            kilometer:kilometer,
        },
        success:function(response){
            $('#distanceModel').modal('toggle');
            Swal.fire({
                title: 'Success!',
                text: 'Distance has been added successfully!',
                icon: 'success',
                confirmButtonText: 'Done'
            });
            setTimeout(function() {   //calls click event after a certain time
                location.reload()
            }, 2000);

        },
        error: function(response) {
            $('#city_fromErrorMsg').text(response.responseJSON.errors.city_from);
            $('#city_toErrorMsg').text(response.responseJSON.errors.city_to);
            $('#kilometerErrorMsg').text(response.responseJSON.errors.kilometer);
        },
        });
        });
</script>
@endpush
