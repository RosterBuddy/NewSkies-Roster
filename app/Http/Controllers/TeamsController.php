<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;
use App\User;
use Auth;

class TeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $teams = Team::all();
        $users = User::all();

        $unassigned = 0;
        $coms = 0;
        $disruptions = 0;
        $systems = 0;

        foreach($users as $user){
            if($user->team_id == 1){
                $unassigned++;
            }elseif($user->team_id == 2){
                $coms++;
            }elseif($user->team_id == 3){
                $disruptions++;
            }elseif($user->team_id == 4){
                $systems++;
            }
        }

        return view('admin.team.index', compact('teams', 'unassigned', 'coms', 'disruptions', 'systems'));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $users = User::where('team_id', $id)->get();

        return view('admin.team.show', compact('users'));
    }
    public function myteam(){
        $teamid = Auth::user()->team_id;
        $myteam = Team::find($teamid);

        $users = User::all();

        return view('team.myteam', compact('myteam', 'users'));
    }
}
