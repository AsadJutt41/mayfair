@extends('layouts.base')

@section('content')
<div class="card">
    <div class="card-header">
         <div class="col-md-12">
            <div class="row">
                <div class="col-md-8">
                    <div class="card-title">All Cities</div>
                </div>
                <div class="col-md-4">

                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cityModel">Add New City</button>
                    <a href="{{route('import.city')}}" class="btn btn-outline-primary"><i class="fe fe-download"></i>
                        Import City</a>
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
                            <th class="border-bottom-0">city Name</th>
                            <th class="border-bottom-0">Controls</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($cities as $item)
                            <tr>
                                <td>@php echo $i++ @endphp</td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    <a href="{{ route('cityEdit', ['id'=>$item->id]) }}"><i class="fa fa-edit" style="font-size: 22px; color: blue;"></i></a>
                                    <a href="{{ route('cityDelete', ['id'=>$item->id]) }}" class="delete-confirm"><i class="fa fa-trash" style="font-size: 22px; color: red; margin-left: 10px;"></i></a>
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
<div class="modal fade" id="cityModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">City Model</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="cityForm">
                    @csrf

                    <div class="col-md-12">
                        <label for="" class="label-control">City Name</label>
                        <input type="text" class="form-control" name="name" id="name" required :value="old('name')">
                        <span class="text-danger" id="nameErrorMsg"></span>

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

    $('#cityForm').on('submit',function(e){
        e.preventDefault();

        let name = $('#name').val();

        $.ajax({
          url: "/admin/city/store",
          type:"POST",
          data:{
            "_token": "{{ csrf_token() }}",
            name:name,
          },
          success:function(response){
            $('#cityModel').modal('toggle');
            Swal.fire({
                title: 'Success!',
                text: 'City has been added successfully!',
                icon: 'success',
                confirmButtonText: 'Done'
            });
            setTimeout(function() {   //calls click event after a certain time
                location.reload()
            }, 2000);

          },
          error: function(response) {
            $('#nameErrorMsg').text(response.responseJSON.errors.name);
          },
          });
        });
</script>
@endpush
