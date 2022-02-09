<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function index($id)
    {
        $post = Post::find($id);

        if (!$post)
        {
            return response([
                'message' => 'Post not'
            ], 403);
        }
        return response([
            'post' => $post->comments()->with('user:id, name, image')->get()
        ], 200);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $post = Post::find($id);

        if (!$post)
        {
            return response([
                'message' => 'Post not'
            ], 403);
        }

        //validation des données
        $attrs = $request->validate([
            'comment' => 'required|string',
        ]);

        Comment::create([
            'comment' => $attrs['comment'],
            'post_id' => $id,
            'user_id' => auth()->user()->id
        ]);

        return response([
            'message' => 'Comment created.'
        ], 200);
    }
}
