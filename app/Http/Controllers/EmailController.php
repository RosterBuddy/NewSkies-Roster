<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Roster;
use Carbon\Carbon;
use App\User;
use Email;

class EmailController extends Controller
{
    public function lastedited(Request $request) {
        $date  = Carbon::now()->subMinutes(5);
        $user = User::find($request->user_id);

        $rosteredits = Roster::where('updated_at', '>=', $date)->get();

        return view('admin.email.lastedited', compact('rosteredits', 'user'));

    }
}