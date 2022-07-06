@extends('layouts.base')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
<div class="card">
    <div class="card-header">
         <div class="col-md-12">
            <div class="row">
                <div class="col-md-10">
                    <div class="card-title">All Users</div>
                </div>
                <div class="col-md-2">
                    <a href="{{route('add.user')}}"> <button class="btn btn-primary" >Add New User</button></a>
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
                            <th >No #</th>
                            <th >Name</th>
                            <th >Email</th>
                            <th>Phone NO</th>
                            <th>Role</th>
                            <th>Controls</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($users as $item)
                        <tr>
                            <td>@php echo $i++ @endphp</td>
                            <td>{{ $item->firstname }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{$item->phone_number}}</td>
                            <td>
                                {{--  @if($item->user_type == 0)
                                Admin
                                @elseif ($item->user_type == 1)
                                User
                                @elseif ($item->user_type == 2)
                                User (signin throug mobile)
                                @else
                                Manager
                                @endif  --}}
                                {{ $item->roles->value('name') }}
                            </td>
                            <td>
                                <a href="{{ route('edit.user', ['id'=>$item->id]) }}"><i class="fa fa-edit" style="font-size: 22px; color: blue;"></i></a>
                                <a onclick="return confirm('Are you sure to delete this user?')"  href="{{route('delete.user',$item->id)}}" onclick="return confirm('Are you sure you want to delete this user?');"><i class="fa fa-trash" style="font-size: 22px; color: red; margin-left: 10px;"></i></a>
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
 <script>
    jQuery(document).ready(function(){
        $(".flex-wrap").css('display', 'none');
    });
 </script>
@endpush
