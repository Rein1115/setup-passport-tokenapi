<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Post;
use DB;

class PublicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $db = DB::table('posts')
            ->select('posts.posts', 'users.name')
            ->join('users', 'users.id','=','posts.user_id')
            ->where('posts.status','=','0')
            ->get();

            if($db){
                return response()->json(["status" => true, "posts"=>$db]);
            }else{
                return response()->json(["status" => false, "message"=>"No posts available"]);
            }
            
        }catch(\Exception $e){
            return response()->json(["status" => false, "Error"=>$e->getMessage()]);

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
        //
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
        //
    }
}
