@extends('layouts.base')

@section('content')
<div class="card">
    <div class="card-header">
         <div class="col-md-12">
            <div class="row">
                <div class="col-md-10">
                    <div class="card-title">Role And Permissions</div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#permsssionModel">Add New Permission</button>
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
                            <th class="border-bottom-0">User Name</th>
                            <th class="border-bottom-0">Role</th>
                            <th class="border-bottom-0">Permission</th>
                            <th class="border-bottom-0">Controles</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>01</td>
                            <td>Sale name</td>
                            <td>Sale name</td>
                            <td>Sale name</td>
                            <td>
                                <a href=""><i class="fa fa-edit" style="font-size: 22px; color: blue;"></i></a>
                                <a href=""><i class="fa fa-trash" style="font-size: 22px; color: red; margin-left: 10px;"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="permsssionModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Role And Permission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="">
                    @csrf

                    <div class="col-md-12 mt-3">
                        <label class="label-control" for="name">Select User</label>
                        <select name="" class="form-control">
                            <option value="">Select User</option>
                            <option value="">abc</option>
                            <option value="">abc</option>
                        </select>
                    </div>

                    <div class="col-md-12 mt-3">
                        <label class="label-control" for="name">Select User Role</label>
                        <select name="" class="form-control">
                            <option value="">Select User Role</option>
                            <option value="">abc</option>
                            <option value="">abc</option>
                        </select>
                    </div>

                    <div class="col-md-12 mt-3">
                        <label class="label-control" for="name">Select Permission</label>
                        <select name="" class="form-control">
                            <option value="">Select Permission</option>
                            <option value="">abc</option>
                            <option value="">abc</option>
                        </select>
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
