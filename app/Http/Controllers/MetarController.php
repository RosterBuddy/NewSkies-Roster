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
    public function index()
    {
        return view('metar.index');
    }
}
