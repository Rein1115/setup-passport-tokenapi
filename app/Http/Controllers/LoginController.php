<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request) 
    { $credentials = $request->only('email', 'password'); 
        if (Auth::attempt($credentials)) 
        { $user = Auth::user(); $token = $user->createToken('MyAppToken')->accessToken; 
            return response()->json(['token' => $token], 200); 
        } 
        else 
        { 
            return response()->json(['error' => 'Unauthorized'], 401); 
        }
    }
}
