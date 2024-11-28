<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeamController extends Controller
{
    //
    public function get(){
        return response()->json([
            "hmm" => "ight",
            "req" => request()->team
        ]);
    }
}
