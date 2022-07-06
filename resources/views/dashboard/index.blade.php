@extends('layouts.base')
@canany(['Admin Access','Main Dashboard'])

@push('style')

<style>
    .map-chart .chart{
        padding-top: 0;
    }

    .map-chart .card, .map-chart .card div {
        width: 100% !important;
    }

    .map-chart .col-xl-6 {
        max-width: 100% !important;
        flex: 100% !important;
    }

    .map-chart canvas {
        width: 100% !important;
    }
</style>
@endpush
@section('content')
    <!-- Row-1 -->
    <div class="row" style="@if (Auth::user()->user_type == 3) display:none; @endif">
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden dash1-card border-0 dash1">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-6 col-6">
                            <div class="">
                                <span class="fs-14 font-weight-normal">Total Users</span>
                                <h2 class="mb-2 number-font carn1 font-weight-bold">{{ $totalUsers }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden dash1-card border-0 dash2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-6 col-6">
                            <div class="">
                                <span class="fs-14 font-weight-normal">Total Cities</span>
                                <h2 class="mb-2 number-font carn1 font-weight-bold">{{ $totalCity }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden dash1-card border-0 dash3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-6 col-6">
                            <div class="">
                                <span class="fs-14 font-weight-normal">Total Zone</span>
                                <h2 class="mb-2 number-font carn1 font-weight-bold">{{ $totalZone }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden dash1-card border-0 dash4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-6 col-6">
                            <div class="">
                                <span class="fs-14 font-weight-normal">Total Station</span>
                                <h2 class="mb-2 number-font carn1 font-weight-bold">{{ $totalStation }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="display: none">
        <div class="col-md-12">
            <div >
                @php
                    $i = 1;
                @endphp
                <table id="test">
                    <tbody>
                @foreach ($salestaff as $item)
                <tr>
                    <td>@php echo $i; @endphp</td>
                    @foreach (json_decode($item->expense_id) as $expense)
                    <td id="exname@php echo $i; @endphp"> {{ $expense->name }}</td>
                    <td id="exvalue@php echo $i; @endphp">{{ $expense->value }}</td>

                    @endforeach
                </tr>
                @php $i++; @endphp
            @endforeach
                    </tbody>
        </table>
            </div>
        </div>
    </div>
    <div class="row map-chart">
        <div class="col-md-8 col-md-offset-2">
            <h1>Highest Total  H.Q Town Expenses</h1>
            <div class="col-md-8">
                <form action="{{ route('dateFilterGraph') }}" method="post">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-md-5">
                            <input placeholder="Enter your start date" type="text" name="start_date" required class="form-control" onfocus="(this.type='date')" id="date">
                        </div>
                        <div class="col-md-5">
                            <input placeholder="Enter your end date" type="text" name="end_date" required class="form-control" onfocus="(this.type='date')" id="date">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary" type="submit">Filter expense data</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="chart-container">
                            <div class="chart has-fixed-height" id="bars_basic"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row-1 -->
@endsection
@endcanany

@push('scripts')
<link href="{{asset('assets/css/components.min.css')}}" rel="stylesheet" type="text/css">
<script type="text/javascript" src="{{asset('assets/bootstrap.bundle.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.3.3/echarts.min.js" integrity="sha512-2L0h0GhoIHQEjti/1KwfjcbyaTHy+hPPhE1o5wTCmviYcPO/TD9oZvUxFQtWvBkCSTIpt+fjsx1CCx6ekb51gw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>

    var table = document.getElementById("test");
    var totalRowCount = table.rows.length;
    var arr = [];
    var arrr = [];

    for(i = 1; i <= totalRowCount; ++i){
        var exname = document.getElementById("exname"+i).innerText;
        var exvalue = document.getElementById("exvalue"+i).innerText;
        arr.push(exname);
        arrr.push(exvalue);

    }
        const uniqueString = [...new Set(arr)];
        const uniquee = [...new Set(arrr)];
        const maxValue = Math.max(...arrr);

        var bars_basic_element = document.getElementById('bars_basic');
    if (bars_basic_element) {
        var bars_basic = echarts.init(bars_basic_element);
        <?php
            $s=array($unique_expense_name);
            $s_to_json=json_encode((array)$s);

            $v=array($expenseValue);
            $v_to_json=json_encode((array)$v);

        ?>

        var fromPHP = <?php echo $s_to_json; ?>;
        for (i=0; i<fromPHP.length; i++) {
            expenseName=fromPHP[i];
        }

        var expenseValue = <?php echo $v_to_json; ?>;
        for (i=0; i<expenseValue.length; i++) {
            expenseValueResult=expenseValue[i];
        }

        console.warn(expenseValueResult);

        bars_basic.setOption({
            color: ['#3398DB'],
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'shadow'
                }
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis: [
                {
                    type: 'category',
                    data: expenseName,
                    axisTick: {
                        alignWithLabel: true
                    }
                }
            ],
            yAxis: [
                {
                    type: 'value'
                }
            ],
            series: [
                {
                    name: 'Total Expense',
                    type: 'bar',
                    barWidth: '20%',
                    data: expenseValueResult
                }
            ]
        });
    }

</script>


@endpush
