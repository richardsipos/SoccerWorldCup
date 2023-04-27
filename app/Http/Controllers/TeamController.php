<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Player;
use App\Models\Event;
use App\Models\Game;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$teams = TEAM::all();// DB::select("SELECT name FROM teams");
        $teams = TEAM::orderBy('name')->get();
        return view('teams.index',['teams'=>$teams]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this -> authorize('create',Team::class);
        $teams = Team::all();
        return view('teams.create', ['teams' => $teams ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this -> authorize('create',Team::class);

        $validated = $request -> validate(
            ['name' => 'required|min:4',
            'shortname' => 'required|min:4|max:4',
            'image' => 'nullable|image',
        ]);


        if ($request -> hasFile('image')){

            $file = $request -> file('image');
            $fname = $file -> hashName();
            Storage::disk('public') -> put('images/' . $fname, $file -> get());
            $validated['image'] = $fname;


        }

        $team = Team::create($validated);


        Session::flash('team-created');
        return to_route('teams.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        $players = Player::where('team_id','=',$team->id)->get();
        $playersInfo = Event::playersInfo($players);
        $gameScores = Game::gameScores();
        $games = Game::orderBy('start', 'ASC')->get();
        return view('teams.show',[
            'playersInfo' => $playersInfo,
            'team' => $team,
            'gameScores' => $gameScores,
            'games'=>$games
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        return view('teams.edit', ['team' => $team]);//, 'teams' => $categories ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Team $team)
    {
        $this -> authorize('update',Team::class);

        $validated = $request -> validate(
            ['name' => 'required|min:4',
            'shortname' => 'required|min:4|max:4',
            'image' => 'nullable|image',
        ]);


        if ($request -> hasFile('image')){

            $file = $request -> file('image');
            $fname = $file -> hashName();
            Storage::disk('public') -> put('images/' . $fname, $file -> get());
            $validated['image'] = $fname;


        }

        $team -> update($validated);


        Session::flash('team-update');
        return to_route('teams.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        //
    }
}
