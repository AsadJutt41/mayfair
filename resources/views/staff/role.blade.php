@extends('layouts.base')

@section('content')
<div class="card">
    <div class="card-header">
         <div class="col-md-12">
            <div class="row">
                <div class="col-md-10">
                    <div class="card-title">Add Role</div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#roleModel">Add New Role</button>
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
                            <th class="border-bottom-0">Role Name</th>
                            <th class="border-bottom-0">Controls</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($roles as $item)
                            <tr>
                                <td>@php echo $i++ @endphp</td>
                                <td>{{ $item->role }}</td>
                                <td>
                                    <a href="{{ route('roleEdit', ['id'=>$item->id]) }}"><i class="fa fa-edit" style="font-size: 22px; color: blue;"></i></a>
                                    <a href="{{ route('roleDelete', ['id'=>$item->id]) }}" class="delete-confirm"><i class="fa fa-trash" style="font-size: 22px; color: red; margin-left: 10px;"></i></a>
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
<div class="modal fade" id="roleModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Role Model</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger print-error-msg" style="display:none">
                    <ul></ul>
                </div>
                <form id="SubmitForm">
                    @csrf

                    <div class="col-md-12">
                        <label for="" class="label-control">Role Name</label>
                        <input type="text" class="form-control" id="role" name="role"  required :value="old('role')">
                        <span class="text-danger" id="roleErrorMsg"></span>
                    </div>

                    <div class="col-md-12 mt-4">
                        <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')

<script type="text/javascript">



    $('#SubmitForm').on('submit',function(e){
        e.preventDefault();

        let role = $('#role').val();

        $.ajax({
          url: "/admin/role/store",
          type:"POST",
          data:{
            "_token": "{{ csrf_token() }}",
            role:role,
          },
          success:function(response){
            $('#roleModel').modal('toggle');
            Swal.fire({
                title: 'Success!',
                text: 'Role has been added successfully',
                icon: 'success',
                confirmButtonText: 'Done'
            });
            setTimeout(function() {   //calls click event after a certain time
                location.reload()
            }, 2000);

          },
          error: function(response) {
            $('#roleErrorMsg').text(response.responseJSON.errors.role);
          },
          });
        });
</script>
@endpush
