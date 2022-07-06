@extends('layouts.base')

@section('content')

	<!-- Row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Staff Update</h3>
                </div>
                <div class="card-body pb-2">
                    <form action="{{ route('staffUpdate', ['id'=>$staff->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label for="" class="label-control">Profile Image</label>
                                <input type="file" class="form-control" accept="image/*" name="profile_photo_path" onchange="loadFile(event)">
                                <img @if($staff->profile_photo_path)src="{{ asset('images/staff') }}/{{ $staff->profile_photo_path }}" alt="{{ $staff->profile_photo_path }}" @endif id="output" style="height: 150px; width: 150px; border-radius: 25px; border: none; margin-top: 10px;"/>
                                @if($errors->has('profile_photo_path'))
                                    <div style="color: red;">{{ $errors->first('profile_photo_path') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label for="" class="label-control">First Name</label>
                                <input type="text" class="form-control" name="firstname" required value="{{ $staff->firstname }}">
                                @if($errors->has('firstname'))
                                    <div style="color: red;">{{ $errors->first('firstname') }}</div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label for="" class="label-control">Last Name</label>
                                <input type="text" class="form-control" name="lastname" required value="{{ $staff->lastname }}">
                                @if($errors->has('lastname'))
                                    <div style="color: red;">{{ $errors->first('lastname') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label for="" class="label-control">Email</label>
                                <input type="email" class="form-control" name="email" required value="{{ $staff->email }}">
                                @if($errors->has('profile_photo_path'))
                                    <div style="color: red;">{{ $errors->first('profile_photo_path') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <label class="label-control" for="name">Select User Designation</label>
                                <select name="designation" class="form-control">
                                    <option selected disabled>Select User Designation</option>
                                    <option value="d1" {{ ( 'd1' == $staff->designation) ? 'selected' : '' }}>designation 01</option>
                                    <option value="d2" {{ ( 'd2' == $staff->designation) ? 'selected' : '' }}>designation 02</option>
                                </select>
                                @if($errors->has('designation'))
                                    <div style="color: red;">{{ $errors->first('designation') }}</div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label class="label-control" for="name">Select User Role</label>
                                <select name="role" class="form-control">
                                    <option selected disabled>Select User Role</option>
                                    @foreach ($staffRole as $item)
                                            <option value="{{ $item->role }}" {{ ( $item->role == $staff->role) ? 'selected' : '' }}>{{ $item->role }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('role'))
                                    <div style="color: red;">{{ $errors->first('role') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <label class="label-control" for="name">Select Line Manager</label>
                                <select name="line_manager" class="form-control">
                                    <option selected disabled >Select Line Manager</option>
                                    @foreach ($users as $item)
                                        <option value="{{ $item->firstname }}{{ $item->lastname }}" {{ ( $item->firstname == $staff->firstname) ? 'selected' : '' }}>{{ $item->firstname }}{{ $item->lastname }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('line_manager'))
                                    <div style="color: red;">{{ $errors->first('line_manager') }}</div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label class="label-control" for="name">Select Over Limit Approver</label>
                                <select name="over_limit_approver" class="form-control">
                                    <option selected disabled>Select Over Limit Approver</option>
                                    <option value="yes" {{ ( 'yes' == $staff->over_limit_approver) ? 'selected' : '' }}>yes</option>
                                    <option value="no" {{ ( 'no' == $staff->over_limit_approver) ? 'selected' : '' }}>No</option>
                                </select>
                                @if($errors->has('over_limit_approver'))
                                    <div style="color: red;">{{ $errors->first('over_limit_approver') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <label for="" class="label-control">Phone Number</label>
                                <input type="number" class="form-control" name="phone_number" required value="{{ $staff->phone_number }}">
                                @if($errors->has('phone_number'))
                                    <div style="color: red;">{{ $errors->first('phone_number') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <label for="" class="label-control">Sap ID</label>
                                <input type="text" class="form-control" name="sap_id" required value="{{ $staff->sap_id }}">
                                @if($errors->has('sap_id'))
                                    <div style="color: red;">{{ $errors->first('sap_id') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <label for="" class="label-control">Joning Date</label>
                                <input type="date" class="form-control" name="joining_date" required value="{{ $staff->joining_date }}">
                                @if($errors->has('joining_date'))
                                    <div style="color: red;">{{ $errors->first('joining_date') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <label class="label-control" for="name">Select Base Town</label>
                                <select name="base_town" class="form-control">
                                    <option selected disabled>Select Base Town</option>
                                    @foreach ($cities as $item)
                                            <option value="{{ $item->name }}" {{ ( $item->name == $staff->base_town) ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('base_town'))
                                    <div style="color: red;">{{ $errors->first('base_town') }}</div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label class="label-control" for="name">Select zone</label>
                                <select name="zone" class="form-control">
                                    <option selected disabled>Select zone</option>
                                    @foreach ($zone as $item)
                                            <option value="{{ $item->zone }}" {{ ( $item->zone == $staff->zone) ? 'selected' : '' }}>{{ $item->zone }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('zone'))
                                    <div style="color: red;">{{ $errors->first('zone') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <label for="" class="label-control">Address</label>
                                <input type="text" class="form-control" name="address" required value="{{ $staff->address }}">
                                @if($errors->has('address'))
                                    <div style="color: red;">{{ $errors->first('address') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <button class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
            </div>
    </div>
@endsection
