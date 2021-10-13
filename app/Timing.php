<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timing extends Model
{
    protected $fillable = [
        'name', 'shift_start', 'shift_end', 'user_type'
    ];
}
