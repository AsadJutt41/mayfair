<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Allocation;
use App\Models\StaffExpense;
use App\Models\TravelExpense;
use App\Models\Expense;
use Auth;

class DashboardController extends Controller
{
    public function expenseHQ(Request $request)
    {
        $expense = StaffExpense::where('expense_category', 'headquater')->whereBetween('current_date', [$request->date_start, $request->date_end])->where('user_id', Auth::user()->id)->get();
        if($expense) {
            return response()->json(['Status' => true, 'data' => $expense]);
        }
    }
    public function expenseTR(Request $request)
    {
        $expense = TravelExpense::whereBetween('current_date', [$request->date_start, $request->date_end])->where('user_id', Auth::user()->id)->get();
        if($expense) {
            return response()->json(['Status' => true, 'data' => $expense]);
        }
    }
    public function expense()
    {
        $expense = StaffExpense::select('id', 'current_date','expense_id')->where('user_id', Auth::user()->id)->get();
        return response()->json(['Status' => true, 'data' => $expense]);
    }
}
