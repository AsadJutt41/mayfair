@extends('layouts.base')

@section('content')
<div class="card">
    <div class="card-header">
         <div class="col-md-12">
            <div class="row">
                <div class="col-md-8">
                    <div class="card-title">All Zone</div>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#zoneModel">Add New Zone</button>
                    <a href="{{route('import.zone')}}" class="btn btn-outline-primary"><i class="fe fe-download"></i>
                        Import Zone</a>
                </div>
            </div>
         </div>
    </div>
    <div class="card-body">
        @if(Session::has('succesmsg'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('succesmsg') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if(Session::has('errorcsv') && !empty(Session::get('errorcsv')))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <p>These records are not inserted in database</p>
                <ul>
                    @foreach(Session::get('errorcsv') as $error)

                    <li style="padding: 5px;">{{$error['errorMessage']}}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="">
            <div class="table-responsive">
                <table id="example" class="table table-bordered text-nowrap key-buttons">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">No #</th>
                            <th class="border-bottom-0">Zone</th>
                            <th class="border-bottom-0">Date</th>
                            <th class="border-bottom-0">Controls</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($zones as $item)
                            <tr>
                                <td>@php echo $i++; @endphp</td>
                                <td>{{ $item->zone }}</td>
                                <td>{{  \Carbon\Carbon::parse($item->created_at)->format('j-F-Y') }}</td>
                                <td>
                                    <a href="{{ route('zoneEdit', ['id'=>$item->id]) }}"><i class="fa fa-edit" style="font-size: 22px; color: blue;"></i></a>
                                    <a href="{{ route('zoneDelete', ['id'=>$item->id]) }}" class="delete-confirm"><i class="fa fa-trash" style="font-size: 22px; color: red; margin-left: 10px;"></i></a>
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
<div class="modal fade" id="zoneModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Zone Model</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="zoneForm">
                    @csrf

                    <div class="col-md-12">
                        <label for="" class="label-control">Zone</label>
                        <input type="text" class="form-control" name="zone" id="zone" required :value="old('zone')">
                        <span class="text-danger" id="zoneErrorMsg"></span>
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

    $('#zoneForm').on('submit',function(e){
        e.preventDefault();

        let zone = $('#zone').val();

        $.ajax({
          url: "/admin/zone/store",
          type:"POST",
          data:{
            "_token": "{{ csrf_token() }}",
            zone:zone,
          },
          success:function(response){
            $('#zoneModel').modal('toggle');
            Swal.fire({
                title: 'Success!',
                text: 'Zone has been added successfully!',
                icon: 'success',
                confirmButtonText: 'Done'
            });
            setTimeout(function() {   //calls click event after a certain time
                location.reload()
            }, 2000);

          },
          error: function(response) {
            $('#zoneErrorMsg').text(response.responseJSON.errors.zone);
          },
          });
        });
</script>

@endpush
