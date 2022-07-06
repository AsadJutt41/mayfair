@extends('layouts.base')

@section('content')
<div class="card">
    <div class="card-header">
         <div class="col-md-12">
            <div class="row">
                <div class="col-md-10">
                    <div class="card-title">Reconciliation Report</div>
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
                            <th class="border-bottom-0">Role</th>
                            <th class="border-bottom-0">Sale Expense Allocation</th>
                            <th class="border-bottom-0">H.Q. Town Exepense</th>
                            <th class="border-bottom-0">Daily Traveling Exepense</th>
                            <th class="border-bottom-0">Controles</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        {{-- @foreach($allocations as $item)
                            <tr>
                               <td>@php echo $i++; @endphp</td>
                               <td>{{ $item->role }}</td>
                               <td>
                                    @if($item->maintance > 1) Maintance, @endif
                                    @if($item->fare > 1) Fare/Tail/Tol/Tax/Road, @endif
                                    @if($item->staff > 1) Staff Meeting JC & Hotels, @endif
                                    @if($item->phone > 1) Phone, @endif
                                    @if($item->internet > 1) Internet, @endif
                                    @if($item->courier > 1) Courier, @endif
                                    @if($item->photostate > 1) Photostate/Stationary, @endif
                                    @if($item->sampling > 1) Sampling, @endif
                                    @if($item->fuel > 1) Fuel, @endif
                                    @if($item->traveling > 1) Traveling @endif
                               </td>
                               <td>{{ $item->maintance + $item->fare + $item->phone + $item->staff + $item->internet + $item->courier + $item->courier + $item->photostate + $item->sampling  }}</td>
                               <td>{{ $item->traveling }}</td>
                            </tr>
                        @endforeach --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
