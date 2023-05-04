<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Event;
use App\Models\Team;
use App\Models\Player;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$allGames = new Game;//Game::all();
        //$finishedGames = $allGames -> finishedGames()->sortByDesc('start'); //-> paginate(5);
        $allGames = Game::all();

        $ongoingGames = Game:: where ('finished','=',false ) -> orderByDesc('start') ->get();
        $finishedGames = Game:: where ('finished','=',true ) -> orderByDesc('start') -> paginate(5);
        $teams = Team::all();


        $event = new Event;


        $gameScores = Game::gameScores();

        // dd($gameScores);
        return view('games.index', [
            'finishedGames' => $finishedGames,'ongoingGames' => $ongoingGames,
            'gameScores' => $gameScores,
            'teams' => $teams
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this -> authorize('create',Game::class);
        $teams = Team::all();
        return view('games.create', ['teams' => $teams ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this -> authorize('create',Game::class);

        $validated = $request -> validate(
            ['hometeams_id' => 'required|distinct',
            'awayteams_id' => 'required|distinct|different:hometeams_id',
            'start' => 'required|after:today',
        ]);

        $game = Game::create($validated);


        Session::flash('game-created');
        return to_route('games.index');

    }


    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        $events = Event::where ('game_id','=',$game->id)->get();
        $gameScores = Game::gameScores();

        $eventsBothTeams = Game::eventsHomeAndAwayTeam($game);
        $teams = Team::all();
        $players = Player::all();
        return view('games.show', [
            'game' => $game,
            'gameScores' => $gameScores,
            'eventsBothTeams' => $eventsBothTeams,
            'players' => $players,
            'events' =>  $events,
            'teams' => $teams
            // 'eventsAwayTeam' => $eventsAwayTeam
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game)
    {
        $teams = Team::all();
        return view('games.edit', ['game' => $game,'teams' => $teams]);//, 'teams' => $categories ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {
        $this -> authorize('update',Game::class);

        $validated = $request -> validate(
            ['hometeams_id' => 'required|distinct',
            'awayteams_id' => 'required|distinct|different:hometeams_id',
            'start' => 'required|after:today',
        ]);

        $game -> update($validated);


        Session::flash('game-update');
        return to_route('games.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        $events = Event::where('game_id','=',$game->id)->get();
        if(!count($events)){
            $this -> authorize('delete', Game::class);
            $game -> delete();
        }


        return to_route('games.index');
    }
}
