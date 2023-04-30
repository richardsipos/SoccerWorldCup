<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Event;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this -> authorize('create', Player::class);
        $teams = Team::all();
        return view('teams.index', ['teams' => $teams]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this -> authorize('create', Player::class);

        $validated = $request -> validate(
            ['name' => 'required|string',
            'number' => 'required|integer',
            'birthdate' => 'required|date|before:today',
            'team_id' => 'required|exists:teams,id'
        ]);

        $player = Player::create($validated);


        Session::flash('player-created');
        return to_route('teams.show',['team' => $validated['team_id']]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Player $player)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Player $player)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Player $player)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Player $player)
    {
        $events = Event::all();
        $team_id = $player->team_id;
        $canDelete = true;
        foreach($events as $event){
            if($event->player_id == $player->id){
                $canDelete=false;
            }
        }
        if($canDelete){
            $this -> authorize('delete', Player::class);
            $player -> delete();

        }

        return to_route('teams.show',['team' => $team_id]);
    }
}
