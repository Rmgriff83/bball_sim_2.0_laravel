<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    //
    public function login() {
        $credentials = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $req = request()->all();

        if (Auth::attempt($credentials)) {
 
            $user = Auth::user();

            if ( isset($user) ) {
                $token = $user->createToken('bball_sim_2.0_vue');
            }

            // try {
            //     $user_team = UserTeam::where('user_id', $user->id)->firstOrFail();

            // } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            //     return response()->json([
            //         "success" => true,
            //         "user" => $user,
            //         "token" => $token,
            //         "msg" => "team not found"
            //     ]);
            // } catch (\Exception $e) {
            //     return response()->json([
            //         "success" => false,
            //         "req" => $req,
            //         "msg" => "error finding team"
            //     ]);
            // }

            return response()->json([
                "success" => true,
                "user" => $user,
                "token" => $token,
            ]);
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function check(Request $request) {
        $user = $request->user();

        if ( isset($user) ) {
            return response()->json([
                "success" => true,
                "user" => $user,
                "msg" => "user found"
            ]);
        } else {
            return response()->json([
                "success" => false,
                "msg" => "user not found"
            ]);
        }
    }

    public function logout(Request $request) {
        try {
            $request->user()->tokens()->delete();
        } catch (\Exception $e){
            return response()->json([
                "success" => false,
                "msg" => "error logging out user"
            ]);
        }

        return response()->json([
            "success" => true,
            "msg" => "user logged out successfully"
        ]);
    }
}
