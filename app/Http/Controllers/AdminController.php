<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request){
        $posts = Post::paginate(5);
        if($request->ajax()){
            $view = view('admin.posts',compact('posts'))->render();
            return response()->json(['html'=>$view]);
        }
        return view('admin.index',compact('posts'));
    }
}