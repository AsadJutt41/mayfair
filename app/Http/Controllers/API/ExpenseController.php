<?php

namespace App\Http\Controllers\API;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\StaffExpense;
use App\Models\StaffTravelExpense;
use App\Models\User;
use Auth;
use Carbon\CarbonPeriod;
use Carbon\Carbon;
use App\Models\Notification;

class ExpenseController extends Controller
{
    public function allExpense()
    {
        $expense = Expense::where('role', Auth::user()->role)->where('expense_category', '1')->get();
        return response()->json(['Status' => true, 'data' => $expense]);
    }
    public function expenseStoreHeadquater(Request $request)
    {
        $user = auth()->user()->line_manager;
        $fcmtoken = User::where('id',$user)->value('fcm_token');

        foreach ($request->expense_id as $da) {
            $myData[] = $da;
            $sum[] = $da['value'];
        }
        $grandTotal = array_sum($sum);
            $expense = new StaffExpense();
            $expense->expense_id = json_encode($myData);
            $expense->expense_category = 'headquater';
            $expense->user_id = Auth::user()->id;
            $expense->current_date = $request->current_date;
            $expense->status = 'Rejected';
            $expense->total = $grandTotal;
            $success = $expense->save();

        if($success){
            $notification['title'] = "Add Staff";
            $notification['body'] = "New expenses added by staff";
            $responsesms = Helpers::send_push_notif_to_device($fcmtoken,$notification);
            if($responsesms) {
                $notif = new Notification;
                $notif->type =  "Add Staff";
                $notif->title = $notification['title'];
                $notif->body = $notification['body'];
                $notif->user_id = auth()->user()->id;
                $notif->save();
            }

            return response()->json(['Status' => true, 'message' => 'Expense added Successfully!']);
        }else{
            return response()->json(['Status' => false, 'message' => 'Something Went Wrong']);
        }
    }
    public function expenseAccespted()
    {
        $staff = StaffExpense::where('status','Approved')->where('user_id', Auth::user()->id)->get();
        // $total = StaffExpense::where('status','Approved')->where('user_id', Auth::user()->id)->sum('total');
        return response()->json(['Status' => true, 'data' => $staff], 200);
    }
    public function expenseAccesptedDate(Request $request)
    {
        $staff = StaffExpense::where('status','Approved')->where('user_id', Auth::user()->id)->whereBetween('current_date', [$request->startDate, $request->endDate])->get();
        return response()->json(['Status' => true, 'data' => $staff]);
    }
    public function expenseRejected()
    {
        $staff = StaffExpense::where('status','Rejected')->where('user_id', Auth::user()->id)->get();
        // $total = StaffExpense::where('status','Rejected')->where('user_id', Auth::user()->id)->sum('total');
        return response()->json(['Status' => true, 'data' => $staff]);
    }
    public function expenseRejectedDate(Request $request)
    {
        $staff = StaffExpense::where('status','Rejected')->where('user_id', Auth::user()->id)->whereBetween('current_date', [$request->startDate, $request->endDate])->get();
        return response()->json(['Status' => true, 'data' => $staff]);
    }

    public function expenseByUserID()
    {
        $staff = StaffExpense::where('user_id', Auth::user()->id)->get();
        return response()->json(['Status' => true, 'data' => $staff]);
    }

 public function updateHeadQuaterExpenseByUserIDAndDate(Request $request)
    {
        $user = auth()->user()->line_manager;
        $fcmtoken = User::where('id',$user)->value('fcm_token');
        foreach ($request->expense_id as $da) {
            $myData[] = $da;
            $sum[] = $da['value'];
        }
        $grandTotal = array_sum($sum);
            $expense = StaffExpense::find($request->id);
            $expense->expense_id = json_encode($myData);
            $expense->expense_category = 'headquater';
            $expense->user_id = Auth::user()->id;
            $expense->current_date = $request->current_date;
            $expense->status = 'Rejected';
            $expense->total = $grandTotal;
            $success = $expense->save();

        if($success){
            $notification['title'] = "Add Staff";
            $notification['body'] = "HeadQuater expenses update by staff";
            $responsesms = Helpers::send_push_notif_to_device($fcmtoken,$notification);
            if($responsesms) {
                $notif = new Notification;
                $notif->type =  "Add Staff";
                $notif->title = $notification['title'];
                $notif->body = $notification['body'];
                $notif->user_id = auth()->user()->id;
                $notif->save();
            }

            return response()->json(['Status' => true, 'message' => 'Expense updated Successfully!']);
        }else{
            return response()->json(['Status' => false, 'message' => 'Something Went Wrong']);
        }
    }

    public function autoFillHeadquaterExpenseStore(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $period = CarbonPeriod::create($startDate, $endDate)->toArray();

        $expense = Expense::where('role', Auth::user()->role)->where('expense_category', '1')->select('id as expense_id','expense_category')->get()->toArray();

        foreach($period as $date) {

            $cdate = $date->format('Y-m-d');
            $staffExpense = StaffExpense::select('current_date')->where('current_date', $cdate)->first();

           if(!$staffExpense) {
                $expsense = Expense::where('role', Auth::user()->role)->select('name', 'value')->get();
                $grandTotal = Expense::where('role', Auth::user()->role)->sum('value');

                $expense = new StaffExpense();
                $expense->expense_id = json_encode($expsense);
                $expense->expense_category = 'headquater';
                $expense->user_id = Auth::user()->id;
                $expense->current_date = $cdate;
                $expense->status = 'Rejected';
                $expense->total = $grandTotal;
                $success = $expense->save();

           }
        }
         $expense = StaffExpense::where('user_id', Auth::user()->id)->select('id', 'current_date', 'expense_id')->get();
        return response()->json(['status' => true, 'data'=>$expense]);
    }

    public function singleExpense(Request $request)
    {
        $expense = StaffExpense::where('current_date', $request->date)->where('user_id', Auth::user()->id)->get();
        return response()->json(['status' => true, 'data'=>$expense]);
    }

    public function allNotification() {
        $allnotification = Notification::with('user')->get();
         return response()->json(['Status' => true, 'data' => ['notifications' => $allnotification, ]]);
    }
}
