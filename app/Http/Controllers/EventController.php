<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Game;
use App\Models\Team;
use App\Models\Player;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Game $game)
    {
        //
        return view('games.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Game $game)
    {
        $this -> authorize('create', Event::class);
        $players = Player::all();
        return view('games.index', ['players' => $players]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this -> authorize('create', Event::class);

        //itt a baj, bele kell irjam a gameId-t...de hogyan?
        $validated = $request -> validate(
            ['minute' => 'required|integer|min:0|max:90',
            'type' => 'required|string|in:öngól,gól,piros lap,sárga lap',
            'player_id' => 'integer|exists:players,id',
            'game_id' => 'required|exists:games,id'
        ]);

        $event = Event::create($validated);
        // $event -> categories() -> sync($validated['players'] ?? []);




        Session::flash('event-created');
        return to_route('games.show',['game' => $validated['game_id']]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        // dd($event->game_id); ez jo
        $game = Game::where('id','=',$event->game_id)->get()[0];
        // $events = Event::where ('game_id','=',$game->id)->get();
        if(!$game->finished){
            $this -> authorize('delete', Event::class);
            $event -> delete();
        }
        return to_route('games.show',['game' => $game->id]);
    }
}
