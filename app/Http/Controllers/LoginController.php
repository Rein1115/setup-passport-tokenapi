<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;


class LoginController extends Controller
{
    public function login(Request $request) 
    { 
        try{

            $credentials = $request->only('email', 'password'); 

            if (Auth::attempt($credentials)) 
            { 
                $user = Auth::user(); 
                $token = $user->createToken('APP_ENV')->accessToken; 
                $data['token'] = $token;
                $data['user'] = Auth::user();
                return response()->json(['token' => $data], 200); 
            } 
            else 
            { 
                return response()->json(['error' => 'Wrong Credentials'], 401); 
            }

        }catch(\Exception $e){

            return response()->json(['status'=>false, 'error' => $e->getMessage()]);
        }
       
    }

    public function register(Request $request){

        try{
            $validator = $request->validate([
                'name' => 'required',
                'email' => 'email',
                'password' => 'required',
                're-password' => 'required',
            ]);
            
            if($validator['password'] != $validator['re-password']){
                return response()->json(["status" => false, "message" => "Password not match"]);
            }

            $emailExist = User::where('email',$validator['email'])
                        ->exists();
            if($emailExist){
                return response()->json(['status' => false, 'message' => "Email Already Exists"]);
            }

            $user = User::create([
                'name' => $validator['name'],
                'email' => $validator['email'],
                'password' => $validator['password']
            ]);

            if($user){
                return response()->json(["status" => true, "message" => "Inserted Successfully"]);
            }
            
        }catch(\Exception $e){
            return response()->json(["status"=>false, "message" => $e]);
        }

    }

    public function logout(Request $request){
        try {
            $user = $request->user();
    
            if ($user) {
                $user->tokens()->delete();
    
                return response()->json(['status' => true, 'message' => 'Logout Successfully']);
            } else {
                return response()->json(['status' => false, 'message' => 'User not authenticated'], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
   
    }
}
