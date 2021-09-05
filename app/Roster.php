<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roster extends Model
{
    protected $fillable = ['name', 'description', 'shift_start', 'shift_end'];

}
