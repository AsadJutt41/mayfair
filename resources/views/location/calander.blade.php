@extends('layouts.base')

@section('content')
<div class="card">
    <div class="card-header">
         <div class="col-md-12">
            <div class="row">
                <div class="col-md-10">
                    <div class="card-title">All Calendar</div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#calanderModel">Add New Calendar</button>
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
                            <th class="border-bottom-0">Updated At</th>
                            <th class="border-bottom-0">Date From</th>
                            <th class="border-bottom-0">Date To</th>
                            <th class="border-bottom-0">Date Description</th>
                            <th class="border-bottom-0">Controls</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach($calander as $item)
                            <tr>
                                <td>@php echo $i++ @endphp</td>
                                <td>{{ \Carbon\Carbon::parse($item->updated_at)->format('j-F-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->date_to)->format('j-F-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->date_from)->format('j-F-Y') }}</td>
                                <td>{{ $item->desc }}</td>
                                <td>
                                    <a href="{{ route('calanderEdit', ['id'=>$item->id]) }}"><i class="fa fa-edit" style="font-size: 22px; color: blue;"></i></a>
                                    <a href="{{ route('calanderDelete', ['id'=>$item->id]) }}" class="delete-confirm"><i class="fa fa-trash" style="font-size: 22px; color: red; margin-left: 10px;"></i></a>
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
<div class="modal fade" id="calanderModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Calendar Model</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('calanderStore') }}" method="POST">
                    @csrf

                    <div class="col-md-12 mt-4">
                        <label for="" class="label-control">From</label>
                        <input type="date" class="form-control" name="date_from" required>
                    </div>

                    <div class="col-md-12 mt-4">
                        <label for="date_to" class="label-control">To</label>
                        <input type="date" class="form-control" name="date_to" required>
                    </div>

                    <div class="col-md-12 mt-4">
                        <label for="date_to" class="label-control">Description</label>
                        <input type="text" class="form-control" name="desc" required >
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
