<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostCommentsController extends Controller
{
    public function store(Post $post){

        //dd(request()->all());

        // validate
        request()->validate([
            'body' => 'required'
        ]);

        $post->comments()->create([
            'body' => request('body'),
            'user_id' => auth()->user()->id
        ]);

        return redirect()->back();
    }
}
