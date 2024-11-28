<?php

namespace App\Http\Controllers;

abstract class Controller
{
    //
    public function get() {
        return response()->json([
            "real" => "team"
        ]);
    }
}
