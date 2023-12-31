<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        if ($posts->isEmpty()) {
            return response([
                'status' => 'error',
                'message' => 'No posts found'
            ], 404);
        }
        return response([
            'status' => 'success',
            'posts' => $posts
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }
        $author = $user->name;
        $post = Post::create([
            'author' => $author,
            'content' => $request->content,
            'images' => $request->images,
            'likes' => 0,
            'comments' => 0,
        ]);
        return response([
            'status' => 'success',
            'post' => $post
        ], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $post = Post::where('_id', $request->id)->first();
        if (!$post) {
            return response([
                'status' => 'error',
                'message' => 'Post not found'
            ], 404);
        }
        return response([
            'status' => 'success',
            'post' => $post
        ], 200);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $post = Post::where('_id', $request->id)->first();
        if (!$post) {
            return response([
                'status' => 'error',
                'message' => 'Post not found'
            ], 404);
        }
        if($request->has('title')){
            $post->update([
                'title' => $request->title,
            ]);
        }
        if($request->has('content')){
            $post->update([
                'content' => $request->content,
            ]);
        }
        if($request->has('email')){
            $post->update([
                'email' => $request->email,
            ]);
        }
        if($request->has('images')){
            $post->update([
                'images' => $request->images,
            ]);
        }

        return response([
            'status' => 'success',
            'post' => $post
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $post = Post::where('_id', $request->id)->first();
        if (!$post) {
            return response([
                'status' => 'error',
                'message' => 'Post not found'
            ], 404);
        }
        $post->delete();
        return response([
            'status' => 'success',
            'message' => 'Post deleted successfully'
        ], 200);

    }

    public function addLikes(Request $request)
    {
        $post = Post::where('_id', $request->id)->first();
        if (!$post) {
            return response([
                'status' => 'error',
                'message' => 'Post not found'
            ], 404);
        }
        $post->update([
            'likes' => $post->likes + 1,
        ]);
        return response([
            'status' => 'success',
            'post' => $post
        ], 200);
    }
}
