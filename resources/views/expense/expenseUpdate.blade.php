@extends('layouts.base')

@section('content')

	<!-- Row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Update Expense Details</h3>
                </div>
                <div class="card-body pb-2">
                    <form action="{{ route('expenseUpdate' , ['id'=>$expense->id]) }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-4 mt-3">
                                <label class="label-control" for="role">Select Role</label>
                                <select name="role" class="form-control" id="role" required>
                                    <option disabled selected>Select Select Role</option>
                                @foreach ($staffRoles as $item)
                                    <option value="{{ $item->role }}" {{ ( $item->role == $expense->role) ? 'selected' : '' }}>{{ $item->role }}</option>
                                @endforeach
                                </select>
                                <span class="text-danger" id="roleErrorMsg"></span>
                            </div>

                            <div class="col-md-4 mt-3">
                                <label class="label-control" for="name">Expense Type</label>
                                <select name="name" class="form-control" id="name" required>
                                    <option disabled selected>Select Expense Type</option>
                                @foreach ($expenseType as $item)
                                    <option value="{{ $item->name }}" {{ ( $item->name == $expense->name) ? 'selected' : '' }}>{{ $item->name }}</option>
                                @endforeach
                                </select>
                                <span class="text-danger" id="nameErrorMsg"></span>
                            </div>

                            <div class="col-md-4 mt-3">
                                <label class="label-control" for="type">Type</label>
                                <select name="type" class="form-control" required>
                                    <option disabled selected>Select Type</option>
                                    <option value="daily" {{ ( 'daily' == $expense->type) ? 'selected' : '' }} >Daily</option>
                                    <option value="monthly" {{ ( 'monthly' == $expense->expense_category) ? 'selected' : '' }}>Monthy</option>
                                </select>
                                @if($errors->has('type'))
                                    <div style="color: red;">{{ $errors->first('type') }}</div>
                                @endif
                            </div>

                            <div class="col-md-4 mt-3">
                                <label class="label-control" for="wage">Enter Expense Amount</label>
                                <input type="number" class="form-control" name="value" id="value"  min="0" required value="{{ $expense->value }}">
                                <span class="text-danger" id="valueErrorMsg"></span>
                            </div>

                            <div class="col-md-4 mt-3">
                                <label class="label-control" for="wage">Enter Wage Type</label>
                                <input type="text" class="form-control" name="wage_type" required value="{{ $expense->wage_type }}">
                                @if($errors->has('wage_type'))
                                    <div style="color: red;">{{ $errors->first('wage_type') }}</div>
                                @endif
                            </div>

                            <div class="col-md-4 mt-3">
                                <label class="label-control" for="info_type">Enter Info Type</label>
                                <input type="text" class="form-control" name="info_type" required value="{{ $expense->info_type }}">
                                @if($errors->has('info_type'))
                                    <div style="color: red;">{{ $errors->first('info_type') }}</div>
                                @endif
                            </div>

                            <div class="col-md-4 mt-3">
                                <label class="label-control" for="expense_category">Expense Category</label>
                                <select name="expense_category" class="form-control" required>
                                    <option disabled selected>Select Expense Category</option>
                                    @foreach ($expenseCategories as $item)
                                        <option value="{{ $item->id }}" {{ ( $item->id == $expense->expense_category) ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('expense_category'))
                                    <div style="color: red;">{{ $errors->first('expense_category') }}</div>
                                @endif
                            </div>

                            <div class="col-md-4 mt-3">
                                <label class="label-control" for="amount_per_kilometer">Amount Per Kilometer</label>
                                <input type="number" name="amount_per_kilometer" class="form-control" required value="{{ $expense->amount_per_kilometer }}">
                                @if($errors->has('amount_per_kilometer'))
                                    <div style="color: red;">{{ $errors->first('amount_per_kilometer') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-4 mt-4">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </form>
            </div>
    </div>
@endsection
