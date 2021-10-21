<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Roster;
use Carbon\Carbon;
use App\User;
use Mail;

class EmailController extends Controller
{
    public function lastedited($id) {
        $user = User::find($id);
        $rosteredits = Roster::all();
        
        foreach($rosteredits as $rosteredit){
            if($rosteredit->updated_at != $rosteredit->last_edited){
                    $roster = Roster::find($rosteredit->id);
                    $roster->updated_at = Carbon::now();
                    $roster->last_edited = $roster->updated_at;
                    $roster->save();
            }
        }        
        Mail::send('admin.email.lastedited', [
            'rosteredits' => $rosteredits,
            'user' => $user,
        ], function ($mail) use($id) {    
            $user = User::find($id);
            $mail->from('no-reply@rosterbuddy.org', "Newskies Managment");
            $mail->to($user->email)->subject("An Update To Your Roster");
        });

        toastr()->success('Agent advised of changes in their roster.', 'Complete');
        return back()->withInput();

        //return view('admin.email.lastedited', compact('rosteredits', 'user'));
    }
}