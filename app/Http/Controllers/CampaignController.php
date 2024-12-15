<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Campaign;

class CampaignController extends Controller
{
    //
    public function createCampaign() {
        try {
            $campaign = Campaign::create([
                "user_id" => Auth::user()->id
            ]);
        } catch(\Exception $e) {
            return response()->json([
                "success" => false,
                "msg" => "error creating campaign"
            ]);
        }

        return response()->json([
            "success" => true,
            "msg" => "campaign created successfully",
            "campaign" => $campaign
        ]);
    }
}
