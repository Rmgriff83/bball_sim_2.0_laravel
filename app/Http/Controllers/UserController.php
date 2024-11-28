<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function create() {
        $req = request()->all();

        try {
            User::create([
                "name" => $req['first_name'] . ' ' . $req['last_name'],
                "email" => $req['email'],
                "password" => $req['password']
            ], true);
        } catch(\Exception $e){
            return response()->json([
                "success" => false,
                "msg" => "error creating new user"
            ]);
        }

        try {
            $credentials = request()->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);
    
            Auth::attempt($credentials);
            $user = Auth::user();
            $token = $user->createToken('bball_sim_2.0_vue');
        } catch(\Exception $e) {
            return response()->json([
                "success" => false,
                "msg" => "error with auto login of new user"
            ]);
        }


        return response()->json([
            "success" => true,
            "msg" => "user successfully created",
            "user" => $user,
            "token" => $token
        ]);
    }
}
