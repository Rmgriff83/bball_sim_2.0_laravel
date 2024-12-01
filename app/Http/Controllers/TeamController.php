<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AllTeams;

class TeamController extends Controller
{
    //
    public function getAllTeams(){
        try {
            $allTeams = AllTeams::all();
        } catch(\Exception $e) {
            return response()->json([
                "success" => false,
                "msg" => "error getting all teams"
            ]);
        }

        return response()->json([
            "success" => true,
            "all_teams" => json_encode($allTeams)
        ]);
    }
}
