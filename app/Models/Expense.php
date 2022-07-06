<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $table = "expenses";

    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category', 'id');
    }

    public function allocation()
    {
        return $this->belongsToMany(Allocation::class);
    }

    public function staffExpense()
    {
        return $this->belongsToMany(StaffExpense::class);
    }
}
