<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpenseCategory;
use App\Models\Expense;
use App\Models\ExpenseType;
use App\Models\StaffRole;
use App\Models\StaffExpense;
use validate;

class ExpenseController extends Controller
{
    /****Expense Part ****/
    public function index()
    {
        $expenses = Expense::with('expenseCategory')->orderBy('name','ASC')->get();
        $expenseType = ExpenseType::orderBy('name','ASC')->get();
        $staffRoles = StaffRole::orderBy('role','ASC')->get();
        $expenseCategories = ExpenseCategory::all();

        return view('expense.index')->with([
            'expenseCategories' => $expenseCategories,
            'expenseType' => $expenseType,
            'expenses' => $expenses,
            'staffRoles' => $staffRoles
        ]);
    }

    public function expenseStore(Request $request)
    {
        $validate = $request->validate([
            'role' => ['required'],
            'name' => ['required'],
            'value' => ['required'],
            'type' => ['required'],
            'wage_type' => ['required'],
            'info_type' => ['required'],
            'expense_category' => ['required'],
        ]);
        $expense =  new Expense();
        $expense->role = $request->role;
        $expense->name = $request->name;
        $expense->value = $request->value;
        $expense->type = $request->type;
        $expense->wage_type = $request->wage_type;
        $expense->info_type = $request->info_type;
        $expense->expense_category = $request->expense_category;
        $expense->amount_per_kilometer = $request->amount_per_kilometer;
        $expense->save();
        return back()->with("success", "Expense has been added successfully!");
    }
    public function expenseEdit($id)
    {
        $expense = Expense::find($id);
        $expenseType = ExpenseType::orderBy('name','ASC')->get();
        $staffRoles = StaffRole::orderBy('role','ASC')->get();
        $expenseCategories = ExpenseCategory::all();
        return view('expense.expenseUpdate')->with([
            'expense' => $expense,
            'expenseCategories' => $expenseCategories,
            'staffRoles' => $staffRoles,
            'expenseType' => $expenseType
        ]);
    }
    public function expenseUpdate(Request $request, $id)
    {
        $validate = $request->validate([
            'name' => ['required'],
            'type' => ['required'],
            'wage_type' => ['required'],
            'info_type' => ['required'],
            'expense_category' => ['required'],
        ]);

        $expense =  Expense::find($id);
        $expense->role = $request->role;
        $expense->name = $request->name;
        $expense->value = $request->value;
        $expense->type = $request->type;
        $expense->wage_type = $request->wage_type;
        $expense->info_type = $request->info_type;
        $expense->expense_category = $request->expense_category;
        $expense->amount_per_kilometer = $request->amount_per_kilometer;
        $expense->save();
        return back()->with("success", "Expense has been updated successfully!");
    }
    public function expenseDelete($id)
    {
        $singleCategory = Expense::find($id);
        $singleCategory->delete();
        return back()->with('success', 'Expense has been deleted Successfully!');
    }

    /****Expense Type ****/
    public function expenseType()
    {
        $expenseType = ExpenseType::orderBy('name','ASC')->get();
        return view('expense.expenseType',compact('expenseType'));
    }
    public function expenseTypeStore(Request $request)
    {
        $validate = $request->validate([
            'name' => ['required', 'unique:expene_types']
        ],[ 'name.unique' => 'Expense type has already been taken' ]);
        $expenseType = new ExpenseType();
        $expenseType->name = $request->name;
        $expenseType->save();
        return back();
    }
    public function expenseTypeEdit($id)
    {
        $expenseType = ExpenseType::find($id);
        return view('expense.expenseTypeEdit',compact('expenseType'));
    }
    public function expenseTypeUpdate(Request $request, $id)
    {
        $validate = $request->validate([
            'name' => ['required', 'unique:expene_types']
        ],[ 'name.unique' => 'Expense type has already been taken' ]);
        $expenseType = ExpenseType::find($id);
        $expenseType->name = $request->name;
        $expenseType->save();
        return back()->with('success', 'Expense type has been updated successfully!');
    }
    public function expenseTypeDelete($id)
    {
        $expenseType = ExpenseType::find($id);
        $expenseType->delete();
        return back()->with('success', 'Expense type has been deleted successfully!');
    }

    /***Expense Category Part ****/
    public function expenseCategory()
    {
        $expenseCategories = ExpenseCategory::all();
        return view('expense.category', compact('expenseCategories'));
    }
    public function expenseCategoryStore(Request $request)
    {
        $validate = $request->validate([
            'name' => ['required', 'unique:expense_categories']
        ]);
        $expenseCategory = new ExpenseCategory();
        $expenseCategory->name = $request->name;
        $expenseCategory->save();
        return back()->with('success', 'Expense Category has been adedd Successfully!');
    }
    public function expenseCategoryEdit($id)
    {
        $singleCategory = ExpenseCategory::find($id);
        return view('expense.categoryUpdate', compact('singleCategory'));
    }
    public function expenseCategoryUpdate(Request $request, $id)
    {
        $validate = $request->validate([
            'name' => ['required']
        ]);
        $expenseCategory = ExpenseCategory::find($id);
        $expenseCategory->name = $request->name;
        $expenseCategory->save();
        return back()->with('success', 'Expense Category has been updated Successfully!');
    }
    public function expenseCategoryDelete($id)
    {
        $singleCategory = ExpenseCategory::find($id);
        $singleCategory->delete();
        return back()->with('success', 'Expense Category has been deleted Successfully!');
    }

    /*** Sale Staff part ****/
    public function saleStafExpense()
    {
        $expense = ExpenseType::orderBy('name','ASC')->get();
        $saleStaff = StaffExpense::with('user')->get();
        return view('expense.sale_staf',compact('expense', 'saleStaff'));
    }
    public function dateFilterSaleStaffExpense(Request $request)
    {

        $expense = ExpenseType::orderBy('name','ASC')->get();
        $saleStaff = StaffExpense::with('user')->whereBetween('created_at', [$request->start_date, $request->end_date])->get();
        return view('expense.sale_staf',compact('expense', 'saleStaff'));
    }


    /****Reconcilation Part ****/
    public function reconciliation()
    {
        return view('expense.reconciliation');
    }

}
