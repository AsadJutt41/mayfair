<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\City;
use App\Models\StaffExpense;
use App\Models\Expense;
use App\Models\Zone;
use App\Models\Station;
use Auth;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $salestaff = StaffExpense::where('expense_category', 'headquater')->select('expense_id', 'expense_category')->get();

        if (Auth::check()) {
            $totalUsers = User::all()->count();
            $totalCity = City::all()->count();
            $totalZone = Zone::all()->count();
            $totalStation = Station::all()->count();

            if (Auth::user()->user_type == 3) {
                $lineManagerStaff = User::where('line_manager', Auth::user()->firstname.Auth::user()->lastname)->select('id')->get();
                foreach ($lineManagerStaff as $manager) {
                    $id[] = $manager->id;
                }
                $staff = StaffExpense::whereIn('user_id', $id)->whereMonth('created_at', Carbon::now()->month)->where('status', 'Approved')->get();

                foreach ($staff as $item) {
                    foreach (json_decode($item->expense_id) as $key => $expense) {
                        $expense_name[] = $expense->name;
                        $expense_val[] = $expense->value;
                        $sum = array_sum($expense_val);

                        for ($i = 0; $i < 1; $i++) {
                            $expense_value[$key][$i] = $sum;
                        }
                    }
                }
                function flatten(array $array)
                {
                    $return = array();
                    array_walk_recursive($array, function ($a) use (&$return) {
                        $return[] = $a;
                    });
                    return $return;
                }
                if (isset($expense_value)) {
                    $expenseValue = flatten($expense_value);
                } else {
                    $expenseValue = null;
                }

                if (isset($expense_name)) {
                    $expenseName = collect($expense_name);
                } else {
                    $expenseName = collect(['Nothing Available']);
                }
                $unique_expense_name = $expenseName->unique()->values()->all();
            } else {
                $staff = StaffExpense::whereMonth('created_at', Carbon::now()->month)->where('status', 'Approved')->get();
                $staffCount = StaffExpense::count('expense_id');
                // dd($staff);
                foreach ($staff as $item) {
                    foreach (json_decode($item->expense_id) as $key => $expense) {
                        $expense_name[] = $expense->name;
                        $expense_val[] = $expense->value;
                        $sum = array_sum($expense_val);

                        for ($i = 0; $i < 1; $i++) {
                            $expense_value[$key][$i] = $sum;
                        }
                    }
                }
                function flatten(array $array)
                {
                    $return = array();
                    array_walk_recursive($array, function ($a) use (&$return) {
                        $return[] = $a;
                    });
                    return $return;
                }
                if (isset($expense_value)) {
                    $expenseValue = flatten($expense_value);
                } else {
                    $expenseValue = null;
                }
                if (isset($expense_name)) {
                    $expenseName = collect($expense_name);
                } else {
                    $expenseName = collect(['Nothing Available']);
                }
                $unique_expense_name = $expenseName->unique()->values()->all();
            }

            return view('dashboard.index', compact('totalUsers', 'totalCity', 'totalZone', 'totalStation', 'salestaff', 'unique_expense_name', 'expenseValue'));
        } else {
            return redirect()->route('login');
        }
    }

        public function dateFilterGraph(Request $request)
        {
            $salestaff = StaffExpense::where('expense_category', 'headquater')->select('expense_id', 'expense_category')->get();

            $totalUsers = User::all()->count();
            $totalCity = City::all()->count();
            $totalZone = Zone::all()->count();
            $totalStation = Station::all()->count();
                 
            if (Auth::user()->user_type == 3) {
                $lineManagerStaff = User::where('line_manager', Auth::user()->firstname.Auth::user()->lastname)->select('id')->get();
                foreach ($lineManagerStaff as $manager) {
                    $id[] = $manager->id;
                }
                $staff = StaffExpense::whereIn('user_id', $id)->whereBetween('created_at', [$request->start_date, $request->end_date])->where('status', 'Approved')->get();

                foreach ($staff as $item) {
                    foreach (json_decode($item->expense_id) as $key => $expense) {
                        $expense_name[] = $expense->name;
                        $expense_val[] = $expense->value;
                        $sum = array_sum($expense_val);

                        for ($i = 0; $i < 1; $i++) {
                            $expense_value[$key][$i] = $sum;
                        }
                    }
                }
                function flatten(array $array)
                {
                    $return = array();
                    array_walk_recursive($array, function ($a) use (&$return) {
                        $return[] = $a;
                    });
                    return $return;
                }
                if (isset($expense_value)) {
                    $expenseValue = flatten($expense_value);
                } else {
                    $expenseValue = null;
                }

                if (isset($expense_name)) {
                    $expenseName = collect($expense_name);
                } else {
                    $expenseName = collect(['Nothing Available']);
                }
                $unique_expense_name = $expenseName->unique()->values()->all();
            } else {
                $staff = StaffExpense::whereBetween('created_at', [$request->start_date, $request->end_date])->where('status', 'Approved')->get();
                $staffCount = StaffExpense::count('expense_id');
                // dd($staff);
                foreach ($staff as $item) {
                    foreach (json_decode($item->expense_id) as $key => $expense) {
                        $expense_name[] = $expense->name;
                        $expense_val[] = $expense->value;
                        $sum = array_sum($expense_val);

                        for ($i = 0; $i < 1; $i++) {
                            $expense_value[$key][$i] = $sum;
                        }
                    }
                }
                function flatten(array $array)
                {
                    $return = array();
                    array_walk_recursive($array, function ($a) use (&$return) {
                        $return[] = $a;
                    });
                    return $return;
                }
                if (isset($expense_value)) {
                    $expenseValue = flatten($expense_value);
                } else {
                    $expenseValue = null;
                }
                if (isset($expense_name)) {
                    $expenseName = collect($expense_name);
                } else {
                    $expenseName = collect(['Nothing Available']);
                }
                $unique_expense_name = $expenseName->unique()->values()->all();
            }

            return view('dashboard.index', compact('totalUsers', 'totalCity', 'totalZone', 'totalStation', 'salestaff', 'unique_expense_name', 'expenseValue'));
        }

}
