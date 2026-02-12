<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    protected $fillable = [
        'user_id',
        'tool_id',
        'borrow_date',
        'return_date',
        'status',
        'qty'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }

    public function returnTool()
    {
        return $this->hasOne(ReturnTool::class);
    }
}
