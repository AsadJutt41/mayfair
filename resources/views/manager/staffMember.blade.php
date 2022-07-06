@extends('layouts.base')
@push('style')
  <style>
    .required {
        color: red;
      }
  </style>
@endpush
@section('content')
<div class="card">
    <div class="card-header">
         <div class="col-md-12">
            <div class="row">
                <div class="col-md-10">
                    <div class="card-title">All Staff Members of {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</div>
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
                            <th class="border-bottom-0">Name</th>
                            <th class="border-bottom-0">Role</th>
                            <th class="border-bottom-0">Zone</th>
                            <th class="border-bottom-0">City</th>
                            <th class="border-bottom-0">Phone Number</th>
                            <th class="border-bottom-0">Designation</th>
                            <th class="border-bottom-0">Joining Date</th>
                            <th class="border-bottom-0">Controls</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($staff as $item)
                            <tr>
                                <td>@php echo $i++ @endphp</td>
                                <td>{{ $item->firstname }}</td>
                                <td>{{ $item->role }}</td>
                                <td>{{ $item->zone }}</td>
                                <td>{{ $item->base_town }}</td>
                                <td>{{ $item->phone_number }}</td>
                                <td>{{ $item->designation }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->joining_date)->format('j-F-Y') }}</td>
                                <td>
                                    <a href="{{ route('managerStaffExpenseInGraph' , ['id' => $item->id]) }}" type="button" class="btn btn-primary">Show Expense in Graph</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

