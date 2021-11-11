<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roster extends Model
{
    protected $fillable = ['name', 'user_id', 'description', 'day_off', 'shift_start', 'shift_end'];

    public function User() {
        return $this->belongsTo(User::class);
    }
}
