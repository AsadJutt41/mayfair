@extends('layouts.base')
<meta name="csrf-token" content="{{ csrf_token() }}">
@push('style')
<style>
    li {
        list-style-type: none;
    }
    #tddesign td {
        display: flex;
    }
</style>
@endpush
@section('content')
<div class="card">
    <div class="card-header">
         <div class="col-md-12">
            <div class="row">
                <div class="col-md-10">
                    <div class="card-title">Approve or Reject Staff Expense by Manager</div>
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
                            <th class="border-bottom-0">Expense Total Amount</th>
                            <th class="border-bottom-0">Category</th>
                            <th class="border-bottom-0">User</th>
                            <th class="border-bottom-0">Status</th>
                            {{--  <th class="border-bottom-0">Controles</th>  --}}
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($staffexpenses as $expense)
                        <tr>
                            <td>@php echo $i++ @endphp</td>
                            <td>
                                @foreach (json_decode($expense->expense_id) as $item)
                                    {{ $item->name.', ' }}
                                @endforeach
                            </td>
                            <td>
                                @foreach (json_decode($expense->expense_id) as $item)
                                    {{ $item->value.', ' }}
                                @endforeach
                            </td>
                            <td>{{ $expense->expense_category }}</td>
                            <td>
                                @php
                                    $user = App\Models\User::where('id',$expense->user_id)->first();
                                @endphp
                                @if($user)
                                    {{ $user->firstname }}{{ $user->lastname }}
                                @endif
                            <td>
                                <form action="{{ route('changeExpenseStatus', ['id'=>$expense->id]) }}" method="POST">
                                    @csrf
                                    <select name="status" class="form-control" onchange="this.form.submit();">
                                        <option selected disabled>Select Approval Status</option>
                                        <option value="Approved" {{ ( 'Approved' == $expense->status) ? 'selected' : '' }}>Approved</option>
                                        <option value="Rejected" {{ ( 'Rejected' == $expense->status) ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                    {{-- <input type="hidden" name="id" value="{{ $expense->id }}"> --}}
                                    <span class="text-danger" id="statusErrorMsg"></span>
                                </form>
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
@push('scripts')

<script type="text/javascript">

    $('#expenseType').on('submit',function(e){
        e.preventDefault();

        let role = $('#status').val();

        $.ajax({
          url: "/admin/expense-change-status/{id}",
          type:"POST",
          data:{
            "_token": "{{ csrf_token() }}",
            status:status,
          },
          success:function(response){
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
            $('#statusErrorMsg').text(response.responseJSON.errors.status);
          },
          });
        });
</script>
@endpush
