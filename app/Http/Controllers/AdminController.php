<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Roster;
use App\User;
use App\Team;
use Auth;
use Carbon\Carbon;

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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('admin.roster.roster_create', compact('users'));
    }

    public function store(Request $request)
    {
        Roster::create($request->all());
        return redirect()->route('admin.index');
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
        return view('admin.users.select_user', compact('users'));
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
        $user = User::find($id);
        return view('admin.roster.show', compact('rosters', 'user', 'id'));
    }

    public function edit_user_calendar($id) {
        $roster = Roster::find($id);

        $starttime = Carbon::createFromFormat('Y-m-d H:i:s', $roster->shift_start)->format('Y-m-d\TH:i');
        $endtime = Carbon::createFromFormat('Y-m-d H:i:s', $roster->shift_end)->format('Y-m-d\TH:i');
        

        return view('admin.roster.edit', compact('roster', 'starttime', 'endtime'));
    }

    public function update_user_calendar($id){
        # code...
    }
}
