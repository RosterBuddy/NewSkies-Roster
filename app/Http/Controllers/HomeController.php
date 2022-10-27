<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Alaouy\Youtube\Facades\Youtube;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function youtube($id)
    {
        $commentThreads = Youtube::getCommentThreadsByVideoId($id);
        $comments = json_decode(json_encode($commentThreads),true);

        $channel = Youtube::getChannelById('UCM9kUKETf6Bu8P0lpUQGWwg');
        dd($channel);

        return view('test.youtube', compact('comments'));
    }
}
