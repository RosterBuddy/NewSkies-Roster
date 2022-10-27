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
        // $commentThreads = Youtube::getCommentThreadsByVideoId($id);
        // $comments = json_decode(json_encode($commentThreads),true);

        $playlist = Youtube::getPlaylistItemsByPlaylistId($id);

        foreach($playlist["results"] as $result){
            $results = json_decode(json_encode($result),true);
            $video = json_decode(json_encode(Youtube::getVideoInfo($results["snippet"]["resourceId"]["videoId"])),true);
            $videoid = $results["snippet"]["resourceId"]["videoId"];
            try{
                if($video["statistics"]["commentCount"] ?? '0' > 0){
                    $commentThreads = Youtube::getCommentThreadsByVideoId($videoid);
                    $comments = json_decode(json_encode($commentThreads),true);
                }
            }catch(Exception $ignored){                
            }
        }

        return view('test.youtube', compact('comments'));
    }

    public function videos($id)
    {
        $playlist = Youtube::getPlaylistItemsByPlaylistId($id);
        foreach($playlist["results"] as $result){
            $results = json_decode(json_encode($result),true);
            $video = json_decode(json_encode(Youtube::getVideoInfo($results["snippet"]["resourceId"]["videoId"])),true);
            $videoid = $results["snippet"]["resourceId"]["videoId"];
            try{
                if($video["statistics"]["commentCount"] ?? '0' > 0){
                    $commentThreads = Youtube::getCommentThreadsByVideoId($videoid);
                    $comments = json_decode(json_encode($commentThreads),true);
                }
            }catch(Exception $ignored){                
            }

            return view('test.youtube', compact('comments'));

        }
    }
}