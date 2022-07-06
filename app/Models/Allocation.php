<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allocation extends Model
{
    use HasFactory;
    protected $table = "allocations";

    public function expenses()
    {
        return $this->belongsTo(Expense::class,'expense_id','id');
    }
}
