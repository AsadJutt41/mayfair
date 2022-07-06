@extends('layouts.base')
@push('style')
  <style>
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
                <div class="col-md-8">
                    <div class="card-title">All Staff Members</div>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staffModel">Add New Staff Member</button>
                    <a href="{{route('import.staff')}}" class="btn btn-outline-primary"><i class="fe fe-download"></i>
                        Import Staff</a>
                </div>
            </div>
         </div>
    </div>
    <div class="card-body">
        <div class="">
            <div class="col-md-6">
                <form action="{{ route('dateFilterSaleStaff') }}" method="post">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-md-5">
                            <input placeholder="Enter your start date" type="text" name="start_date" required class="form-control" onfocus="(this.type='date')" id="date">
                        </div>
                        <div class="col-md-5">
                            <input placeholder="Enter your end date" type="text" name="end_date" required class="form-control" onfocus="(this.type='date')" id="date">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary" type="submit">Filter users data</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
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
                @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    @foreach ($errors->all() as $error)
                        <ul>
                            <li>{{$error}}</li>
                        </ul>
                    @endforeach
                </div>
                @endif
                <table id="example" class="table table-bordered text-nowrap key-buttons">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">No #</th>
                            <th class="border-bottom-0">Name</th>
                            <th class="border-bottom-0">Role</th>
                            <th class="border-bottom-0">Zone</th>
                            <th class="border-bottom-0">City</th>
                            <th class="border-bottom-0">Phone Number</th>
                            <th class="border-bottom-0">Designation</th>
                            <th class="border-bottom-0">Joining Date</th>
                            <th class="border-bottom-0">Controls</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($staff as $item)
                            <tr>
                                <td>@php echo $i++ @endphp</td>
                                <td>{{ $item->firstname }}</td>
                                <td>{{ $item->role }}</td>
                                <td>{{ $item->zone }}</td>
                                <td>{{ $item->base_town }}</td>
                                <td>{{ $item->phone_number }}</td>
                                <td>{{ $item->designation }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->joining_date)->format('j-F-Y') }}</td>
                                <td>
                                    <a href="{{ route('staffEdit', ['id'=>$item->id]) }}"><i class="fa fa-edit" style="font-size: 22px; color: blue;"></i></a>
                                    <a href="{{route('staffDelete', ['id'=>$item->id])}}" class="delete-confirm"><i class="fa fa-trash" style="font-size: 22px; color: red; margin-left: 10px;"></i></a>
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
<div class="modal fade" id="staffModel" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Staff Model</h5>
                <button type="button" class="btn-close btn-close-blue" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-window-close" aria-hidden="true" style="color:blue"></i></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('staffStore') }}" id="staffForm" enctype="multipart/form-data" method="POST">
                    @csrf

                    <div class="row mt-2">
                        <div class="col-md-12">
                            <label for="" class="label-control">Profile Imagge <span class="required"> * </span></label>
                            <input type="file" class="form-control" accept="image/*" name="profile_photo_path" id="profile_photo_path" required onchange="loadFile(event)">
                            <img id="output" style="height: 150px; width: 150px; border-radius: 25px; border: none; margin-top: 10px;"/>
                            <span class="text-danger" id="photoErrorMsg"></span>
                            @if($errors->has('profile_photo_path'))
                                <div style="color: red;">{{ $errors->first('profile_photo_path') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="" class="label-control">First Name <span class="required"> * </span></label>
                            <input type="text" class="form-control" name="firstname" id="firstname" required :value="old('firstname')">
                            <span class="text-danger" id="firstErrorMsg"></span>
                            @if($errors->has('firstname'))
                                <div style="color: red;">{{ $errors->first('firstname') }}</div>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <label for="" class="label-control">Last Name <span class="required"> * </span></label>
                            <input type="text" class="form-control" name="lastname" id="lastname" required :value="old('lastname')">
                            <span class="text-danger" id="lastErrorMsg"></span>
                            @if($errors->has('lastname'))
                                <div style="color: red;">{{ $errors->first('lastname') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="" class="label-control">Email <span class="required"> * </span></label>
                            <input type="email" class="form-control" name="email" id="email" required :value="old('email')">
                            <span class="text-danger" id="emailErrorMsg"></span>
                            @if($errors->has('email'))
                                <div style="color: red;">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <label class="form-label"> Select User Designation</label>
                            <select class="form-control" name="designation" data-placeholder="Choose one (with searchbox)">
                                <option disabled>Select User Designation</option>
                                @foreach ($designations as $item)
                                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="desigErrorMsg"></span>
                            @if($errors->has('designation'))
                                <div style="color: red;">{{ $errors->first('designation') }}</div>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <label class="label-control" for="name">Select User Role <span class="required"> * </span></label>
                            <select name="role" id="role" required class="form-control">
                                <option selected disabled>Select User Role</option>
                                @foreach ($staffRole as $item)
                                        <option value="{{ $item->role }}">{{ $item->role }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="roleErrorMsg"></span>
                            @if($errors->has('role'))
                                <div style="color: red;">{{ $errors->first('role') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <label class="label-control" for="name">Select Line Manager</label>
                            <select name="line_manager" id="line_manager" required class="form-control">
                                <option selected disabled >Select Line Manager</option>
                                @foreach ($manager as $item)
                                    <option value="{{ $item->firstname }}{{ $item->lastname }}">{{ $item->firstname }}{{ $item->lastname }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="lineErrorMsg"></span>
                            @if($errors->has('line_manager'))
                                <div style="color: red;">{{ $errors->first('line_manager') }}</div>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <label class="label-control" for="name">Select Over Limit Approver <span class="required"> * </span></label>
                            <select name="over_limit_approver" id="over_limit_approver" required class="form-control">
                                <option selected disabled>Select Over Limit Approver</option>
                                <option value="yes">yes</option>
                                <option value="no">No</option>
                            </select>
                            <span class="text-danger" id="overErrorMsg"></span>
                            @if($errors->has('over_limit_approver'))
                                <div style="color: red;">{{ $errors->first('over_limit_approver') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <label for="" class="label-control">Password <span class="required"> * </span></label>
                            <input type="password" class="form-control" name="password" id="password" required :value="old('password')">
                            <span class="text-danger" id="passErrorMsg"></span>
                            @if($errors->has('password'))
                                <div style="color: red;">{{ $errors->first('password') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <label for="" class="label-control">Phone Number <span class="required"> * </span></label>
                            <input type="tel"  class="form-control" name="phone_number" id="phone_number" required :value="old('phone_number')">
                            <span class="text-danger" id="phoneErrorMsg"></span>
                            @if($errors->has('phone_number'))
                                <div style="color: red;">{{ $errors->first('phone_number') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <label for="" class="label-control">Sap ID <span class="required"> * </span></label>
                            <input type="text" class="form-control" name="sap_id" id="sap_id" required :value="old('sap_id')">
                            <span class="text-danger" id="sapErrorMsg"></span>
                            @if($errors->has('sap_id'))
                                <div style="color: red;">{{ $errors->first('sap_id') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <label for="" class="label-control">Joning Date <span class="required"> * </span></label>
                            <input type="date" class="form-control" name="joining_date" id="joining_date" required :value="old('joining_date')">
                            <span class="text-danger" id="jndateErrorMsg"></span>
                            @if($errors->has('joining_date'))
                                <div style="color: red;">{{ $errors->first('joining_date') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                           <label class="form-label"> Select Base Town <span class="required"> * </span></label>
                            <select class="form-control" name="base_town" id="select2insidemodal" data-placeholder="Choose one (with searchbox)">
                                    <option selected disabled>Select Base Town</option>
                                    @foreach ($cities as $item)
                                            <option value="{{ $item->name }}">{{ $item->name }}</option>
                                    @endforeach
                            </select>
                            <span class="text-danger" id="baseErrorMsg"></span>
                            @if($errors->has('base_town'))
                                <div style="color: red;">{{ $errors->first('base_town') }}</div>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <label class="label-control" for="name">Select zone <span class="required"> * </span></label>
                            <select name="zone" id="zone" required class="form-control">
                                <option selected disabled>Select zone</option>
                                @foreach ($zone as $item)
                                        <option value="{{ $item->zone }}">{{ $item->zone }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="zoneErrorMsg"></span>
                            @if($errors->has('zone'))
                                <div style="color: red;">{{ $errors->first('zone') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <label for="" class="label-control">Address <span class="required"> * </span></label>
                            <input type="text" class="form-control" name="address" id="address" required :value="old('address')">
                            <span class="text-danger" id="addressErrorMsg"></span>
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
    </div>
</div>




@endsection

@push('scripts')
    <script>
        jQuery(document).ready(function(){

            $(".flex-wrap").css('display', 'none');
        });
    </script>

@endpush
