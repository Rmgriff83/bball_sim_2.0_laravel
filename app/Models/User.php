<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use App\Models\Campaign;
use App\Models\UserTeam;
use App\Models\Coach;
use App\Models\Player;
use App\Models\AllTeams;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function campaigns() {
        $userCampaigns = Campaign::where('user_id', Auth::user()->id)->get();
        return $userCampaigns;
    }

    public function team( $campaign_id ) {
        $userTeam = UserTeam::where('campaign_id', $campaign_id)->where('user_id', Auth::user()->id)->firstOrFail();
        $coach = Coach::where('id', $userTeam->coach_id)->firstOrFail();
        $teamInfo = AllTeams::where('id', $userTeam->team_id)->firstOrFail();

        $players = json_decode($userTeam->players_object, true);
        $players_array = [];

        foreach( $players as $index => $player ) {
            $rawPlayer = Player::find(json_decode($index));
            // $playerAddOns = json_decode($player, true);

            $players_array[$index] = [
                "raw" => $rawPlayer, 
                "addons" => $player
            ];
        };


        $team = [
            "team_info" => $teamInfo,
            "coach" => $coach,
            "players" => json_encode($players_array),
            "meta" => $userTeam->meta
        ];
        return $team;
    }
}
