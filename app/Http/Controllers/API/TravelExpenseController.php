<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Distance;
use App\Models\Expense;
use App\Models\Station;
use App\Models\FuelRate;
use App\Models\TravelExpense;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
//use Illuminate\Support\Str;
class TravelExpenseController extends Controller
{
    public function submitTravelExpense(Request $request)
    {
        $travelExpense = new TravelExpense();
        $travelExpense->user_id = Auth::user()->id;
        $travelExpense->night_stay = $request->night_stay;
        $travelExpense->travel_to = $request->travel_to;
        $travelExpense->station = $request->station;
        $travelExpense->kilometer = $request->kilometer;
        $travelExpense->fuel_amount = $request->fuel_amount;
        $travelExpense->note = $request->note;
        $travelExpense->grand_total = $request->grand_total;
        $travelExpense->current_date = $request->current_date;
        $travelExpense->save();
        return response()->json(['Status' => true, 'Message' => 'Travel Expense submitted successfully!']);
    }
    public function getTravelExpense()
    {
        $travelExpense = TravelExpense::where('user_id', Auth::user()->id)->get();
        return response()->json(['Status' => true, 'data' => $travelExpense]);
    }
    public function getTravelExpenseById(Request $request)
    {
        $travelExpense = TravelExpense::find($request->id);
        return response()->json(['Status' => true, 'data' => $travelExpense]);
    }
    public function updateTravelExpenseById(Request $request)
    {
        $travelExpense = TravelExpense::find($request->id);
        $travelExpense->user_id = Auth::user()->id;
        $travelExpense->night_stay = $request->night_stay;
        $travelExpense->travel_to = $request->travel_to;
        $travelExpense->station = $request->station;
        $travelExpense->kilometer = $request->kilometer;
        $travelExpense->fuel_amount = $request->fuel_amount;
        $travelExpense->note = $request->note;
        $travelExpense->grand_total = $request->grand_total;
        $travelExpense->current_date = $request->current_date;
        $travelExpense->save();
        return response()->json(['Status' => true, 'Message' => 'Travel Expense updated successfully!']);
    }

    public function allDistance()
    {
        $distances = Distance::where('city_from', Auth::user()->base_town)->select('city_to', 'kilometer', 'created_at', 'updated_at')->get();

        $now = Carbon::now();
        $fuelRate = FuelRate::all();

        $travelDailyAllowance = Expense::where('expense_category', '2')->where('role', Auth::user()->role)->sum('value');

        return response()->json(['Status' => true, 'data' => ['city_to' => $distances, 'fuel_rates' => $fuelRate, 'travel_daily_allowance' => $travelDailyAllowance]]);
    }

    public function allNotification() {
        $allnotification = Notification::with('user')->get();
         return response()->json(['Status' => true, 'data' => ['notifications' => $allnotification, ]]);
    }


}
