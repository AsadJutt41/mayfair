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
                    <div class="card-title">Role Management</div>
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
                            <th class="border-bottom-0">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $key=> $role)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$role->name}}</td>
                            <td  id="tddesign">
                                <a href="{{route('roles.edit',$role->id)}}"><i class="fa fa-edit" style="font-size: 22px; color: blue;"></i></a>
                                <a href=""><i class="fa fa-trash" style="font-size: 22px; color: red; margin-left: 10px;"></i></a>
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
                <div class="alert alert-danger" style="display:none"></div>
                <form  action="{{route('roles.store')}}" method="get">
                    @csrf
                    <div class="col-md-12 mt-3">
                        <label class="label-control" for="name">Enter Role Name</label>
                        <input type="text" class="form-control " name="name"  id="name" required :value="old('name')">

                    </div>

                    <div class="col-md-12 mt-4">
                        <button class="btn btn-primary" id="formSubmit">Submit</button>
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
       jQuery('#formSubmit').click(function(e){
          e.preventDefault();
          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

          jQuery.ajax({
             url: "{{ route('roles.store') }}",
             method: 'post',
             data: {
                name: jQuery('#name').val(),
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
                     jQuery('.alert-danger').hide();
                     $('#open').hide();
                     $('#roleModel').modal('hide');
                     location.reload();
                 }
             }});
          });
       });
 </script>




@endpush
