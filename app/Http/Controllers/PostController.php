<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $posts = Post::with('user')->get();
        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        //
        $validatedata=$request->validated();

        $post=Post::create([
            'user_id'=>Auth::id(),
            'title'=>$validatedata['title'],
            'content'=>$validatedata['content']
        ]);

        return response()->json([
            'data'=>$post,
            'message'=>'Post created successfully',
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $post=Post::with('user')->findOrFail($id);

        return new PostResource($post);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, $id)
    {
        //
        $post=Post::findOrFail($id);
        $user_id=Auth::id();

        // if the authenticated user is not the owner of the post
        $response = $this->check_owner($post->user_id,$user_id,'update');
        if ($response) return $response;

        $data= $request->validated();

        $post->update($data);
        return response()->json([
            'data'=>$post,
            'message'=>'post update successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $post = Post::findOrFail($id);
        $user_id=Auth::id();

        $response = $this->check_owner($post->user_id,$user_id,'delete');
        if ($response) return $response;

        $post->delete();

        return response()->json([
            'message'=>'post deleted successfully'
        ],200);
    }

    // if the authenticated user is not the owner of the post
    private function check_owner($owner_id,$user_id,$action){

        if($owner_id !== $user_id){
            return response()->json([
                'message'=> "User unauthorized to {$action} this post"
            ],403);
        }
    }
}
