<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(){
        
    }

    public function index(){
        //posts->comment
        $posts= Post::with('comment')->get();
        return view ('index',[
            'posts' => $posts,
        ]);
    }

    public function commentOnPost(Request $request){
        $request->validate([
            'comment' =>['required'],
        ]);
        print_r($request->comment);die();
        try{
            Comment::create([
                'comment' => $request->comment,
                'post_id' => $request->post,
            ]);
            
        }catch(\Exception $e){
            
        }
    }
}
