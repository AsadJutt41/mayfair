@extends('layouts.base')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-4">
                <div class="card-title pt-3">Sale Staff Expense</div>
            </div>
            <div class="col-md-8">
                <form action="{{ route('dateFilterSaleStaffExpense') }}" method="post">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-md-5">
                            <input placeholder="Enter your start date" type="text" name="start_date" required class="form-control" onfocus="(this.type='date')" id="date">
                        </div>
                        <div class="col-md-5">
                            <input placeholder="Enter your end date" type="text" name="end_date" required class="form-control" onfocus="(this.type='date')" id="date">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary" type="submit">Filter expense data</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="">
            <div class="table-responsive">
                <table id="example" class="table table-bordered text-nowrap key-buttons">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">Code</th>
                            <th class="border-bottom-0">Name</th>
                            <th class="border-bottom-0">Role</th>
                            <th class="border-bottom-0">Total</th>
                            <th class="border-bottom-0">Created At</th>
                            @foreach ($expense as $item)
                                <th class="border-bottom-0">{{ $item->name }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($saleStaff as $item)
                            <tr>
                                <td>@php echo $i++ @endphp</td>
                                <td>{{ $item->user->firstname ?? '-'}}</td>
                                <td>{{ $item->user->role  ?? '-'}}</td>
                                <td>{{ $item->total  ?? '-'}}</td>
                                <td>{{ $item->created_at  ?? '-'}}</td>
                                @foreach (json_decode($item->expense_id) as $expense)
                                    <td>{{ $expense->value ? $expense->value : '-' }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
