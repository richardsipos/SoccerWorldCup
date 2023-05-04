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
                'hometeams_id' => $game->hometeams_id,
                'awayteams_id' => $game->awayteams_id,
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
                    'homeTeam' => true,
                    'id'=> $event->id
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
                    'homeTeam' => false,
                    'id'=> $event->id
                ]);
            }
        }

        return $bothTeamEvents;
    }

    public static function leaderBoard(){

        // $gameScore = gameScores();
        $leaderboard = new Collection();
        $teams = Team::all();
        foreach ($teams as $team){
            $leaderboard -> push([
                'id' => $team->id,
                'name' => $team->name,
                'shortname' => $team->shortname,
                'score' => 0,
                'goalsScored' => 0,
                'goalsGot' => 0
            ]);
        }

        $events = Event::all();
        $games = Game::where('finished','=',true)->get();



        foreach ($games as $game) {
            $gameEvents = Game::eventsHomeAndAwayTeam($game);
            // dd($gameEvents);
            $homeTeamScore = 0;
            $awayTeamScore = 0;
            foreach ($gameEvents as $gameEvent) {


                if($gameEvent['type']== 'öngól'){

                    if($gameEvent['homeTeam']){
                        $awayTeamScore = $awayTeamScore + 1 ;
                    }else{
                        $homeTeamScore = $homeTeamScore + 1 ;
                    }

                    $leaderboard = $leaderboard->map(function($item) use ($gameEvent){
                        if($item['name'] == $gameEvent['team']){
                            $item['goalsGot'] +=1;
                        }
                        return $item;
                    });
                }else if($gameEvent['type']== 'gól'){

                    if($gameEvent['homeTeam']){
                        $homeTeamScore = $homeTeamScore + 1 ;

                    }else{
                        $awayTeamScore = $awayTeamScore + 1 ;
                    }

                    $leaderboard = $leaderboard->map(function($item) use ($gameEvent){
                        if($item['name'] == $gameEvent['team']){
                            $item['goalsScored'] +=1;
                        }
                        return $item;
                    });
                }


            }
            if($homeTeamScore > $awayTeamScore){
                $leaderboard = $leaderboard->map(function($item) use ($game){
                    if($item['id'] == $game['hometeams_id']){
                        $item['score'] +=3;
                    }
                    return $item;
                });
            }else if($homeTeamScore < $awayTeamScore){
                $leaderboard = $leaderboard->map(function($item) use ($game){
                    if($item['id'] == $game['awayteams_id']){
                        $item['score'] +=3;
                    }
                    return $item;
                });
            }else if($homeTeamScore == $awayTeamScore){
                $leaderboard = $leaderboard->map(function($item) use ($game){
                    if($item['id'] == $game['awayteams_id']){
                        $item['score'] +=1;
                    }else if($item['id'] == $game['hometeams_id']){
                        $item['score'] +=1;
                    }
                    return $item;
                });
            }
        }
        // dd($leaderboard);


        $leaderboard = $leaderboard->sortByDesc(function($item) {

            return $item['goalsScored'] - $item['goalsGot'];


        })->sortByDesc('score');

        return $leaderboard;
    }


}
