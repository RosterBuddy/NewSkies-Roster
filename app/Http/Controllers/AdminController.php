<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Roster;
use App\User;
use App\Team;
use App\Timing;
use Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Carbon\CarbonInterval;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.index');
    }

    public function create(){
        $users = User::all();
        return view('admin.roster.single_roster_create', compact('users'));
    }

    public function store(Request $request) {
        $desc = "";

        if(isset($request->description)){
            $desc = $request->description;
        }else{
            $desc = "custom";
        }
        Roster::create([
            'user_id' => $request->user_id,
            'description' => $desc,
            'shift_start' => $request->shift_start,
            'shift_end' => $request->shift_end,
            'day_off' => $request->day_off,
        ]);
        toastr()->success('Time Successfully Added!');
        return redirect()->route('admin.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function block()
    {
        $users = User::all();
        return view('admin.roster.roster_create', compact('users'));
    }

    public function create_block(Request $request){
            Roster::create([
                'user_id' => $request->user_id,
                'description' => $request->description,
                'shift_start' => $request->shift_start,
                'shift_end' => $request->shift_end,
            ]);
        return redirect()->route('admin.select_user_profile');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function makeuser(){
        $teams = Team::all();
        return view('admin.users.new_user', compact('teams'));
    }

    public function createuser(Request $request) {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'team_id' => $request['team'],
            'isAdmin' => $request['isAdmin'],
        ]);
        toastr()->success('User Created Successfully!');
        return redirect()->route('admin.index');
    }

    public function select_user_profile(){
        $users = User::all();
        $terminatedcount = 0;
        foreach($users as $user){
            if($user->isTerminated){
                $terminatedcount++;
            }
        }
        return view('admin.users.select_user', compact('users', 'terminatedcount'));
    }
    
    public function view_user_profile($id){
        $user = User::find($id);
        $teams = Team::all();
        return view('admin.users.view_user', compact('user', 'teams'));
    }

    public function update_user_profile(Request $request, $id) {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        $user = User::find($id);
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->team_id = $request->team;
        $user->isAdmin = $request->isAdmin;
        $user->isTerminated = $request->isTerminated;
        $user->save();


        toastr()->success('User Updated Successfully!');
        return redirect()->route('admin.select_user_profile');
    }



    //===================Calendar Stuff======================//
    
    public function user_calendar() {
        $users = User::all();
        return view('admin.roster.list', compact('users'));
    }

    public function show_user_calendar($id) {
        $rosters = Roster::all();
        $count = 0;
        
        foreach($rosters as $rosteredit){
            if($rosteredit->updated_at != $rosteredit->last_edited && $rosteredit->last_edited != NULL && $rosteredit->user_id == $id){
                $count++;
            }
        }      
        $user = User::find($id);
        return view('admin.roster.show', compact('rosters', 'user', 'id', 'count'));
    }

    public function delete_user_roster($id){
        $rosters = Roster::all();
        $user = User::find($id);
        foreach($rosters as $roster){
            if($roster->user_id == $user->id){
                $ros = Roster::find($roster->id);
                $ros->delete();
            }
        }
        return redirect()->route('admin.show_user_calendar', $user->id);
    }

    public function edit_user_calendar($id) {
        $roster = Roster::find($id);
        $timings = Timing::all();

        $starttime = Carbon::createFromFormat('Y-m-d H:i:s', $roster->shift_start)->format('Y-m-d\TH:i');
        $endtime = Carbon::createFromFormat('Y-m-d H:i:s', $roster->shift_end)->format('Y-m-d\TH:i');
        

        return view('admin.roster.edit', compact('roster', 'starttime', 'endtime', 'timings'));
    }

    public function update_user_calendar(Request $request, $id){
        $roster = Roster::find($id);
        $timings = Timing::all();

        $shift_start_date = substr($roster->shift_start, 0,10);
        $shift_end_date = substr($roster->shift_end, 0,10);

        $shift = $request->shift;
        $dayoff = $request->day_off;
        
        if($dayoff == 0){
            foreach($timings as $timing){
                if($timing->name == $shift){
                    if($timing->shift_end == "00:00:00"){
                        $new_shift_start = $shift_start_date . " " . $timing->shift_start;
                        $new_shift_end = $shift_end_date . " 23:59:00";
    
                        $roster->shift_start = $new_shift_start;
                        $roster->shift_end = $new_shift_end;

                        $roster->last_edited = "1970-01-01 00:00:01";

                        $roster->save();                    
    
                        toastr()->success('Shift Updated Successfully!');
                        return redirect()->route('admin.show_user_calendar', $roster->user_id);
                    }else{
                    $new_shift_start = $shift_start_date . " " . $timing->shift_start;
                    $new_shift_end = $shift_end_date . " " . $timing->shift_end;

                    $roster->shift_start = $new_shift_start;
                    $roster->shift_end = $new_shift_end;

                    $roster->last_edited = "1970-01-01 00:00:01";

                    $roster->save();                    

                    toastr()->success('Shift Updated Successfully!');
                    return redirect()->route('admin.show_user_calendar', $roster->user_id);
                    }
                }
            }
        }elseif($dayoff == 1){

            $roster->day_off = 1;
            $roster->save();

            toastr()->success('Annual Leave Added Successfully!');
            return redirect()->route('admin.show_user_calendar', $roster->user_id);

        }elseif($dayoff == 2){

            $roster->day_off = 2;
            $roster->save();

            toastr()->success('Bank Holiday Added Successfully!');
            return redirect()->route('admin.show_user_calendar', $roster->user_id);

        }
    }

    public function delete_day_from_user_calendar($id) {
        $roster = Roster::find($id);
        $roster->delete();

        toastr()->success('Day Deleted Successfully!');
        return redirect()->route('admin.show_user_calendar', $roster->user_id);
    }

    public function missingtimes() {
        $rosters = Roster::all();

        $missingtimes = [];

        foreach($rosters as $roster){
            $start = $roster->shift_start;
            if(substr($start,11, 19) == "00:00:00" && $roster->description != "off" && $roster->day_off == 0){
               $missingtimes[] = $roster;
            }
        }

        return view('admin.missingtimes', compact('missingtimes'));

        
    }
}