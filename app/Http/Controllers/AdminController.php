<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $posts = Post::select('*')
        ->orderby('created_at','desc')
        ->get();
        return view('admin.index')->with('posts',$posts);
        //return 'Admin';
    }
}