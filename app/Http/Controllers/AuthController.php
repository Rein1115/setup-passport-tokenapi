<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Eloquent\Model;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $user_id = Auth::user()->id;
        try{
            $posts = Post::where("user_id",$user_id)->get();

            if($posts){
             return response()->json(['status' => true, 'posts'=> $posts]);
            }
            else{
             return response()->json(['status' => false, 'message'=> "You have no post(s)"]);
            }
        }catch(\Exception $e){
            return response()->json(['status' => false, 'Error'=> $e->getMessage()]);
        }
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{

            $valitor = $request->validate([
                "posts" => "required",
            ]);

            if(!empty($valitor)){
                Post::create([
                    "user_id" => Auth::user()->id,
                    "posts" => $valitor['posts']
                ]);

                return response()->json(["status" =>true, "Message" => "Posts Inserted Successfully"]);
                
            }else{
                return response()->json(["status" =>false, "Error" => "Not Inserted"]);
            }


        }catch(\Exception $e){
            return response()->json(["status" =>false, "Error" => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
          
            $post = Post::find($id);
    
            
            if (!$post) {
                return response()->json(['error' => 'Post not found'], 404);
            }
    
            
            if (Auth::user()->id !== $post->user_id) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
    
      
            $post->delete();
    
            return response()->json(['message' => 'Post deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(["status" => false, "error" => $e->getMessage()]);
        }

    }

    public function retrieveData(string $id){
        try {
       
            $post = Post::withTrashed()->find($id);
    
            if (!$post) {
                return response()->json(['error' => 'Soft-deleted post not found'], 404);
            }
    
           
            if ($post->trashed()) {
                
                $post->restore();
    
                return response()->json(['message' => 'Post restored successfully']);
            } else {
                return response()->json(['error' => 'Post is not soft-deleted'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(["status" => false, "error" => $e->getMessage()]);
        }
    }


}


