<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'start',
        'finished',

        'hometeams_id',
        'awayteams_id'
    ];

    public function homeTeam()
    {
        return $this->belongsTo(Team::class,'hometeams_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class,'awayteams_id');
    }

    public function events(){
        return $this->hasMany(Event::class);
    }


    public static function gameScores(){
        $games = Game::all();
        $teams = Team::all();
        $players = Player::all();
        $gameScores = new Collection();

        foreach($games as $game){
            $events = Event::where('game_id','=',$game->id)->get();
            $awayTeamPlayers = Player::where('team_id','=', $game->awayteams_id)->get();
            $homeTeamPlayers = Player::where('team_id','=', $game->hometeams_id)->get();
            $homeTeamPoints = 0;
            $awayTeamPoints = 0;

            foreach ($events as $event){

                if($awayTeamPlayers->contains('id',$event->player_id)){
                    if($event->type=='gól'){
                        $awayTeamPoints++;
                    }else if($event->type=='öngól'){
                        $homeTeamPoints++;
                    }
                }else if($homeTeamPlayers->contains('id',$event->player_id)){
                    if($event->type=='gól'){
                        $homeTeamPoints++;
                    }else if($event->type=='öngól'){
                        $awayTeamPoints++;
                    }
                }
            }

            $gameScores->push([
                'game_id' => $game->id,
                'away_team_score' => $awayTeamPoints,
                'home_team_score' => $homeTeamPoints,
            ]);
        }
        return $gameScores;
    }

    public static function eventsHomeAndAwayTeam($game){

        $players = Player::all();
        $bothTeamEvents = new Collection();


        $homeTeamPlayers = Player::where('team_id','=', $game->hometeams_id)->get();
        $awayTeamPlayers = Player::where('team_id','=', $game->awayteams_id)->get();

        $events = Event::where('game_id','=',$game->id)->orderBy('minute', 'ASC')->get();

        foreach ($events as $event){

            $homeTeam = Team::where('team_id','=', $game->hometeams_id)->get();
            $awayTeam = Team::where('team_id','=', $game->awayteams_id)->get();

            if($homeTeamPlayers->contains('id',$event->player_id)){

                $playerName = Player::where('id','=',$event->player_id)->get('name')[0]->name;

                // dd($playerName);
                $bothTeamEvents->push([
                    'playerName' => $playerName,
                    'team' =>$game->homeTeam->name,
                    'type' => $event->type,
                    'minute' => $event->minute,
                    'homeTeam' => true
                ]);
            }
            else if($awayTeamPlayers->contains('id',$event->player_id)){

                $playerName = Player::where('id','=',$event->player_id)->get('name')[0]->name;

                // dd($playerName);
                $bothTeamEvents->push([
                    'playerName' => $playerName,
                    'team' =>$game->awayTeam->name,
                    'type' => $event->type,
                    'minute' => $event->minute,
                    'homeTeam' => false
                ]);
            }
        }

        return $bothTeamEvents;
    }



}
