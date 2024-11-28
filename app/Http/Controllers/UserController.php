<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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
                "msg" => "error"
            ]);
        }


        return response()->json([
            "success" => true,
            "msg" => "user successfully created"
        ]);
    }
}
