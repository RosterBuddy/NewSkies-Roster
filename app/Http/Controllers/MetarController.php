<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
