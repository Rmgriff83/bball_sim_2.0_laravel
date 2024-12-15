<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserTeam;
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

    public function selectTeam() {
        $req = request()->all();

        try {
            $user = Auth::user();

            UserTeam::create([
                "user_id" => $user->id,
                "team_id" => $req['team_id'],
                "campaign_id" => $req['campaign_id']
            ]);

            // $userTeam = $user->team($req['campaign_id']);
            // if( !isset($userTeam) ) {
            //     UserTeam::create([
            //         "user_id" => $user->id,
            //         "team_id" => $req['team_id'],
            //         "campaign_id" => $req['campaign_id']
            //     ]);
            // } else {
            //     return response()->json([
            //         "success" => false,
            //         "msg" => "user team already created for this campaign"
            //     ]);
            // }
        } catch(\Exception $e) {
            return response()->json([
                "success" => false,
                "msg" => "user team creation failed",
                "e" => $e
            ]);
        }

        return response()->json([
            "success" => true,
            "msg" => "team added successfully!",
        ]);
    }

    public function getCampaigns() {
        $user = Auth::user();

        try {
            $campaigns = $user->campaigns();
        } catch (\Exception $e) {
            return respons()->json([
                "success" => false,
                "msg" => "failed getting user campaigns"
            ]);
        }

        return response()->json([
            "success" => true,
            "msg" => "user campaigns found",
            "user_campaigns" => $campaigns,
            "user" => $user
        ]);
    }

    public function getTeam() {
        $req = request()->all();

        try {
            $user = Auth::user();
            $userTeam = $user->team($req['campaign_id']);
            
        } catch (\Exception $e){
            return response()->json([
                "success" => false,
                "msg" => "error finding user team",
                "error" => $e->getMessage(),
                "req" => $req
            ]);
        }

        return response()->json([
            "success" => true,
            "msg" => "user team found",
            "user_team" => $userTeam
        ]);
    }
}
