<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnTool extends Model
{
    protected $table = 'returns';

    protected $fillable = [
        'borrowing_id',
        'returned_at',
        'fine',
        'return_condition',
    ];

    public function borrowing()
    {
        return $this->belongsTo(Borrowing::class);
    }
}
