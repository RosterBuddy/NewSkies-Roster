<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'team_name'
    ];

    public function User() {
        return $this->belongsTo(User::class);
    }
}
