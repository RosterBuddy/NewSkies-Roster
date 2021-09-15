<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Roster;
use App\User;
use App\Team;

class RostersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rosters = Roster::all();
        $teams = Team::all();

        $unacc = "";
        $coms = "";
        $disrupt = "";
        $system = "";
        
        foreach($teams as $team){
            if($team->id == 1){
                $unacc = $team->color;
            }elseif($team->id == 2){
                $coms = $team->color;
            }elseif($team->id == 3){
                $disrupt = $team->color;
            }elseif($team->id == 4){
                $system = $team->color;
            }
        }

        return view('rosters.index', compact('rosters', 'teams', 'unacc', 'coms', 'disrupt', 'system'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
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
}
