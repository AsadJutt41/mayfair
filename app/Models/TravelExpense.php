<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelExpense extends Model
{
    use HasFactory;
    protected $table = "travel_expenses";

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
