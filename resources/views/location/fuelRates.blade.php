@extends('layouts.base')

@section('content')
<div class="card">
    <div class="card-header">
         <div class="col-md-12">
            <div class="row">
                <div class="col-md-10">
                    <div class="card-title">Fuel Managment</div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#fuelModel">Add New Fuel Rate</button>
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
                            <th class="border-bottom-0">Fuel Rate</th>
                            <th class="border-bottom-0">Month</th>
                            <th class="border-bottom-0">Controls</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($fuelRates as $item)
                            <tr>
                                <td>@php echo $i++ @endphp</td>
                                <td>{{ $item->price }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($item->fuel_date)->format('j-F-Y') }}
                                <td>
                                    <a href="{{ route('fuelRateEdit', ['id'=>$item->id]) }}"><i class="fa fa-edit" style="font-size: 22px; color: blue;"></i></a>
                                    <a href="{{ route('fuelRateDelete', ['id'=>$item->id]) }}" class="delete-confirm"><i class="fa fa-trash" style="font-size: 22px; color: red; margin-left: 10px;"></i></a>
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
<div class="modal fade" id="fuelModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Fuel Rates Model</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="alert alert-danger" style="display:none"></div>
                <form action="{{ route('fuelRateStore') }}" method="POST">
                    @csrf

                    <div class="col-md-12 mt-4">
                        <label for="" class="label-control">Price</label>
                        <input type="number" class="form-control" name="price" id="price"  :value="old('price')"  step=".01">
                        {{--  <span class="text-danger" id="priceErrorMsg"></span>  --}}
                    </div>

                    <div class="col-md-12 mt-4">
                        <label for="" class="label-control">Date</label>
                        <input type="date" class="form-control" name="fuel_date" id="fuel_date"  :value="old('fuel_date')"  >
                        {{--  <span class="text-danger" id="fuel_dateMsg"></span>  --}}

                    </div>

                    <div class="col-md-12 mt-4">
                        <button class="btn btn-primary"  id="fuekrateForm">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')

<script>
    jQuery(document).ready(function(){
       jQuery('#fuekrateForm').click(function(e){
          e.preventDefault();
          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

          jQuery.ajax({
             url: "{{ route('fuelRateStore') }}",
             method: 'post',
             data: {
                price: jQuery('#price').val(),
                fuel_date: jQuery('#fuel_date').val(),

             },
             success: function(result){
                 if(result.errors)
                 {
                    $('.alert-danger').html('');

                    $.each(result.errors, function(key, value){
                        $('.alert-danger').show();
                        $('.alert-danger').append('<li>'+value+'</li>');
                    });
                 }
                 else
                 {
                    $('#fuelModel').modal('toggle');

                     jQuery('.alert-danger').hide();
                     $('#open').hide();
                     $('#roleModel').modal('hide');
                     Swal.fire({
                        title: 'Success!',
                        text: 'Fuel Rates has been added successfully!',
                        icon: 'success',
                        confirmButtonText: 'Done'
                    });
                    setTimeout(function() {   //calls click event after a certain time
                        location.reload()
                    }, 2000);
                 }
             }});
          });
       });
 </script>
@endpush
