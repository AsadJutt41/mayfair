<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffExpense extends Model
{
    use HasFactory;
    protected $table = "staff_expenses";

    public function expenses()
    {
        return $this->belongsTo(Expense::class, 'expenseId', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
