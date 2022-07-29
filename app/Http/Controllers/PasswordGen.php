<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PasswordGen extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id){
        $chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz?!@+_-'.
                  '0123456789`-=~!@#$%^&*()_+,./<>?;:[]{}\|';
      
        $str = '';
        $max = strlen($chars) - 1;
      
        for ($i=0; $i < $id; $i++)
          $str .= $chars[random_int(0, $max)];
      
        return view('password', compact('str'));
    }
}
