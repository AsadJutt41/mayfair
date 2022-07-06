@extends('layouts.base')

@section('content')
<div class="card">
    <div class="card-header">
         <div class="col-md-12">
            <div class="row">
                <div class="col-md-10">
                    <div class="card-title">All Stations</div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#stationModel">Add New Station</button>
                </div>
            </div>
         </div>
    </div>
    <div class="card-body">
        <div class="">
            <div class="table-responsive">
                <table id="example" class="table table-bordered text-nowrap key-buttons">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">No #</th>
                            <th class="border-bottom-0">Date </th>
                            <th class="border-bottom-0">Station</th>
                            <th class="border-bottom-0">Controls</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($stations as $item)
                            <tr>
                                <td>@php echo $i++ @endphp</td>
                                <td> {{   date('y-m-d', strtotime($item->created_at))}}</td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    <a href="{{ route('stationEdit', ['id'=>$item->id]) }}"><i class="fa fa-edit" style="font-size: 22px; color: blue;"></i></a>
                                    <a href="{{ route('stationDelete', ['id'=>$item->id]) }}" class="delete-confirm"><i class="fa fa-trash" style="font-size: 22px; color: red; margin-left: 10px;"></i></a>
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
<div class="modal fade" id="stationModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Station Model</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('stationStore') }}" method="POST">
                    @csrf

                    <div class="col-md-12">
                        <label for="name" class="label-control">Station Name</label>
                        <input type="text" class="form-control" name="name" required :value="old('name')">
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
