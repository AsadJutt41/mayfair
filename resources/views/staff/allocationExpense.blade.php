@extends('layouts.base')

@section('content')
<div class="card">
    <div class="card-header">
         <div class="col-md-12">
            <div class="row">
                <div class="col-md-10">
                    <div class="card-title">Role As Per Sale Expense Allocation</div>
                </div>
                {{-- <div class="col-md-2">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staffexpenseModel">Add New Expense</button>
                </div> --}}
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
                            <th class="border-bottom-0">Role</th>
                            <th class="border-bottom-0">Sale Expense Allocation</th>
                            <th class="border-bottom-0">H.Q. Town Exepense</th>
                            <th class="border-bottom-0">Daily Traveling Exepense</th>
                            {{-- <th class="border-bottom-0">Controls</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach($allocation as $item)
                            <tr>
                               <td>@php echo $i++; @endphp</td>
                                <td>{{ $item->role }}</td>
                                <td>
                                    {{-- @foreach ($name as $expenseName) --}}
                                        {{ $item->name }}
                                    {{-- @endforeach --}}
                                </td>
                                @if ($item->expense_category == 1)
                                    <td>{{ $item->value }}</td>
                                @else
                                    <td>-</td>
                                @endif
                                @if ($item->expense_category == 2)
                                    <td>
                                            {{ $item->value }}

                                    </td>
                                @else
                                    <td>-</td>
                                @endif
                                {{-- <td>
                                    <a href="#"><i class="fa fa-edit" style="font-size: 22px; color: blue;"></i></a>
                                    <a href="#"><i class="fa fa-trash" style="font-size: 22px; color: red; margin-left: 10px;"></i></a>
                                </td> --}}
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
    jQuery(document).ready(function(){
        $(".flex-wrap").css('display', 'none');
    });

    $('#allocation').on('submit',function(e){
        e.preventDefault();

        let role = $('#role').val();
        let expenses_name = $('#expenses_name').val();
        // let maintance = $('#maintance').val();
        // let fare = $('#fare').val();
        // let staff = $('#staff').val();
        // let phone = $('#phone').val();
        // let internet = $('#internet').val();
        // let courier = $('#courier').val();
        // let photostate = $('#photostate').val();
        // let sampling = $('#sampling').val();
        // let fuel = $('#fuel').val();
        // let traveling = $('#traveling').val();

        $.ajax({
          url: "/admin/allocations/store",
          type:"POST",
          data:{
            "_token": "{{ csrf_token() }}",
            role:role,
            expenses_name:expenses_name,
            // maintance:maintance,
            // fare:fare,
            // staff:staff,
            // phone:phone,
            // internet:internet,
            // courier:courier,
            // photostate:photostate,
            // sampling:sampling,
            // fuel:fuel,
            // traveling:traveling,
          },
          success:function(response){
            $('#staffexpenseModel').modal('toggle');
            Swal.fire({
                title: 'Success!',
                text: 'Allocation sale expense has been added successfully!',
                icon: 'success',
                confirmButtonText: 'Done'
            });
            setTimeout(function() {   //calls click event after a certain time
                location.reload()
            }, 2000);

          },
          error: function(response) {
            $('#roleErrorMsg').text(response.responseJSON.errors.role);
            $('#expenses_nameErrorMsg').text(response.responseJSON.errors.expenses_name);
            // $('#maintanceErrorMsg').text(response.responseJSON.errors.maintance);
            // $('#fareErrorMsg').text(response.responseJSON.errors.fare);
            // $('#staffErrorMsg').text(response.responseJSON.errors.staff);
            // $('#phoneErrorMsg').text(response.responseJSON.errors.phone);
            // $('#internetErrorMsg').text(response.responseJSON.errors.internet);
            // $('#courierErrorMsg').text(response.responseJSON.errors.courier);
            // $('#photostateErrorMsg').text(response.responseJSON.errors.photostate);
            // $('#samplingErrorMsg').text(response.responseJSON.errors.sampling);
            // $('#fuelErrorMsg').text(response.responseJSON.errors.fuel);
            // $('#travelingErrorMsg').text(response.responseJSON.errors.traveling);
          },
          });
        });
</script>
@endpush
