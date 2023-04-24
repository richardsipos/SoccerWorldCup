<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Event;
use App\Models\Team;
use Illuminate\Http\Request;

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
        //$teams = Team::all();
        //$events = Event::all();
        //$ongoingGames = $allGames -> ongoingGames()->sortByDesc('start');

        $event = new Event;
        // $gamesEvents = $event->gamesEvents();

        $gameScores = Game::gameScores();

        // dd($gameScores);
        return view('games.index', [
            'finishedGames' => $finishedGames,'ongoingGames' => $ongoingGames,
            'gameScores' => $gameScores
            // 'gamesEvents' => $gamesEvents //,'teams' => $teams, 'events' => $events
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        $events = Event::where ('game_id','=',$game->id)->get();
        $gameScores = Game::gameScores();
        // dd($events);
        $eventsBothTeams = Game::eventsHomeAndAwayTeam($game);
        //dd($eventsHomeTeam);

        return view('games.show', [
            'game' => $game,
            'gameScores' => $gameScores,
            'eventsBothTeams' => $eventsBothTeams,
            // 'eventsAwayTeam' => $eventsAwayTeam
        ]);
    }
    // public function show(Post $post)
    // {
    //     $categories = Category::all();
    //     return view('posts.show', ['post' => $post, 'categories' => $categories ]);
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        //
    }
}
