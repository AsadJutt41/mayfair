@extends('layouts.base')

@push('style')
  <style>
    buttons.btn-group.flex-wrap {
        display: none !important;
    }
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
                    <div class="card-title">Expense Details</div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#expenseModel">Add Expense Details</button>
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
                            <th>No #</th>
                            <th>Role</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Wage Type</th>
                            <th>Info Type</th>
                            <th>Expense Category</th>
                            <th>Amount per Kilometer</th>
                            <th>Controls</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($expenses as $item)
                            <tr>
                                <td>@php echo $i++; @endphp</td>
                                <td>{{ $item->role }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->type }}</td>
                                <td>{{ $item->wage_type }}</td>
                                <td>{{ $item->info_type }}</td>
                                <td>{{ $item->expenseCategory->name }}</td>
                                <td>{{ $item->amount_per_kilometer }}</td>
                                <td>
                                    <a href="{{ route('expenseEdit', ['id'=>$item->id]) }}"><i class="fa fa-edit" style="font-size: 22px; color: blue;"></i></a>
                                    <a href="{{ route('expenseDelete', ['id'=>$item->id]) }}" class="delete-confirm"><i class="fa fa-trash" style="font-size: 22px; color: red; margin-left: 10px;"></i></a>
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
<div class="modal fade" id="expenseModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Expense Details Model</h5>
                <button type="button" class="btn-close btn-close-blue" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-window-close" aria-hidden="true" style="color:blue"></i></button>
            </div>
            <div class="modal-body">
                <form id="expenseType">
                    @csrf
                    <div class="col-md-12 mt-3">
                        <label class="label-control" for="role">Select Role <span class="required"> * </span></label>
                        <select name="role" class="form-control" id="role" required>
                            <option disabled selected>Select Select Role</option>
                           @foreach ($staffRoles as $item)
                               <option value="{{ $item->role }}">{{ $item->role }}</option>
                           @endforeach
                        </select>
                        <span class="text-danger" id="roleErrorMsg"></span>
                    </div>

                    <div class="col-md-12 mt-3">
                        <label class="label-control" for="name">Expense Type <span class="required"> * </span></label>
                        <select name="name" class="form-control" id="name" required>
                            <option disabled selected>Select Expense Type</option>
                           @foreach ($expenseType as $item)
                               <option value="{{ $item->name }}">{{ $item->name }}</option>
                           @endforeach
                        </select>
                        <span class="text-danger" id="nameErrorMsg"></span>
                    </div>

                    <div class="col-md-12 mt-3">
                        <label class="label-control" for="wage">Enter Expense Amount <span class="required"> * </span></label>
                        <input type="number" class="form-control" name="value" id="value"  min="0" required :value="old('value')">
                        <span class="text-danger" id="valueErrorMsg"></span>
                    </div>


                    <div class="col-md-12 mt-3">
                        <label class="label-control" for="type">Type <span class="required"> * </span></label>
                        <select name="type" class="form-control" id="type" required>
                            <option disabled selected>Select Type</option>
                            <option value="daily">Daily</option>
                            <option value="monthly">Monthy</option>
                        </select>
                        <span class="text-danger" id="typeErrorMsg"></span>
                    </div>

                    <div class="col-md-12 mt-3">
                        <label class="label-control" for="wage">Enter Wage Type <span class="required"> * </span></label>
                        <input type="number" class="form-control" name="wage_type" id="wage_type"  min="0" required :value="old('wage_type')">
                        <span class="text-danger" id="wage_typeErrorMsg"></span>
                    </div>

                    <div class="col-md-12 mt-3">
                        <label class="label-control" for="info_type">Enter Info Type <span class="required"> * </span></label>
                        <input type="text" class="form-control" name="info_type" id="info_type" required :value="old('info_type')">
                        <span class="text-danger" id="info_typeErrorMsg"></span>
                    </div>

                    <div class="col-md-12 mt-3">
                        <label class="label-control" for="expense_category">Expense Category <span class="required"> * </span></label>
                        <select name="expense_category" class="form-control" id="expense_category" required>
                            <option disabled selected>Select Expense Category</option>
                           @foreach ($expenseCategories as $item)
                               <option value="{{ $item->id }}">{{ $item->name }}</option>
                           @endforeach
                        </select>
                        <span class="text-danger" id="expense_categoryErrorMsg"></span>
                    </div>

                    <div class="col-md-12 mt-3">
                        <label class="label-control" for="amount_per_kilometer">Amount Per Kilometer <span class="required"> * </span></label>
                        <select name="" onchange="yesnoCheck(this);" class="form-control">
                            <option selected disabled>Select One</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </div>

                    <div class="col-md-12 mt-3"  id="ifYes" style="display: none;">
                        <label class="label-control" for="amount_per_kilometer">Amount Per Kilometer <span class="required"> * </span></label>
                        <input type="number" id="amount_per_kilometer" name="amount_per_kilometer" class="form-control" />
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
<script>
    function yesnoCheck(that) {
        if (that.value == "yes") {
            document.getElementById("ifYes").style.display = "block";
        } else {
            document.getElementById("ifYes").style.display = "none";
        }
    }
</script>

<script type="text/javascript">

    $('#expenseType').on('submit',function(e){
        e.preventDefault();

        let role = $('#role').val();
        let name = $('#name').val();
        let value = $('#value').val();
        let type = $('#type').val();
        let wage_type = $('#wage_type').val();
        let info_type = $('#info_type').val();
        let expense_category = $('#expense_category').val();
        let amount_per_kilometer = $('#amount_per_kilometer').val();

        $.ajax({
          url: "/admin/expense/store",
          type:"POST",
          data:{
            "_token": "{{ csrf_token() }}",
            role:role,
            name:name,
            value:value,
            type:type,
            wage_type:wage_type,
            info_type:info_type,
            expense_category:expense_category,
            amount_per_kilometer:amount_per_kilometer,
          },
          success:function(response){
            $('#expenseModel').modal('toggle');
            Swal.fire({
                title: 'Success!',
                text: 'Expense has been added successfully!',
                icon: 'success',
                confirmButtonText: 'Done'
            });
            setTimeout(function() {   //calls click event after a certain time
                location.reload()
            }, 2000);

          },
          error: function(response) {
            $('#roleErrorMsg').text(response.responseJSON.errors.role);
            $('#nameErrorMsg').text(response.responseJSON.errors.name);
            $('#valueErrorMsg').text(response.responseJSON.errors.value);
            $('#typeErrorMsg').text(response.responseJSON.errors.type);
            $('#wage_typeErrorMsg').text(response.responseJSON.errors.wage_type);
            $('#info_typeErrorMsg').text(response.responseJSON.errors.info_type);
            $('#expense_categoryErrorMsg').text(response.responseJSON.errors.expense_category);
            $('#amount_per_kilometerErrorMsg').text(response.responseJSON.errors.amount_per_kilometer);
          },
          });
        });
        jQuery(document).ready(function(){
            $(".flex-wrap").css('display', 'none');
        });
</script>
@endpush
