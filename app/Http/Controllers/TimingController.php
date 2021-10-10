<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Timing;

class TimingController extends Controller
{
    public function index(){
        $timings = Timing::all();
        return view('admin.team.timings.index', compact('timings'));
    }

    public function edit($id){
        $timing = Timing::find($id);
        return view('admin.team.timings.edit', compact('timing'));
    }

    public function create(){
        return view('admin.team.timings.create');
    }

    public function store(Request $request){
         Timing::create([
            'name' => $request->name,
            'shift_start' => $request->shift_start,
            'shift_end' => $request->shift_end,
        ]);
        toastr()->success('Time Created Successfully!');
        return redirect()->route('timing.index');
    }

    public function update(Request $request, $id){
        $timing = timing::find($id);
        $timing->shift_start = $request->shift_start;
        $timing->shift_end = $request->shift_end;
        $timing->save();

        toastr()->success('Time Updated Successfully!');
        return redirect()->route('timing.index');
    }    
}
