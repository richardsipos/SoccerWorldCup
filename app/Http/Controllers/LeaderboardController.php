<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Event;
use App\Models\Team;
use App\Models\Player;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function index()
    {
        $leaderboard = Game::leaderBoard();
        return view('leaderboards.index', ['leaderboard' => $leaderboard]);
    }
}
