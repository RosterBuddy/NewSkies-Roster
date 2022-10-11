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
        // $chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.'0123456789-=!@#$%&';
      
        // $str = '';
        // $max = strlen($chars) - 1;
      
        // for ($i=0; $i < $id; $i++)
        //   $str .= $chars[random_int(0, $max)];

        $str = '';
        function password_generate($chars) {
          $data = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-=!@#$%&';
          return substr(str_shuffle($data), 0, $chars);
        }

        for($t=0; $t < 500; $t++){
          $str = password_generate($id)."\n";
        }
      
        return view('password', compact('str'));
    }
}
