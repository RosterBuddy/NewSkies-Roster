<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Airport;

class MetarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function metar() {
        return view('test.metar');
    }

    public function flight(){
        return view('test.flight');
    }

    public function airport($id)
    {
        $airport = Airport::where('iata', $id)->get();
        return view('test.airport', compact('airport'));
    }

    public function fir_highlight($id)
    {
        return view('test.fir_highlight', compact('id'));
    }
}
