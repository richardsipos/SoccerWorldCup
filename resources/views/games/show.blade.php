<x-guest-layout>
    <div class="merkozesekPage">
        <div class="container">
            <div class="allGames">
                <div class="oneGame">
                    <div class="teamLeft">
                        @if (isset($game->homeTeam->img))
                            <img src={{$game->hometeam->img}} alt="">
                        @else
                            <img src="/images/wcIMG.jpg" alt="">
                        @endif
                        <h1>{{$game->homeTeam->name}}</h1>



                    </div>
                    <div class="vs">
                        <br><br><br><br>
                        @forelse($gameScores as $score)
                            @if($game->id == $score['game_id'])
                                <p>{{$score['home_team_score']}} vs {{$score['away_team_score']}}</p>

                            @endif
                        @empty
                        @endforelse
                        <br><br><br><br><br><br>

                        @forelse($eventsBothTeams as $eventHomeTeam)
                            @if ($eventHomeTeam['homeTeam'])
                                <p>{{$eventHomeTeam['minute']." perc: ".$eventHomeTeam['team']." csapat ".$eventHomeTeam['type']." ". $eventHomeTeam['playerName'] }} ____</p>
                            @elseif (!$eventHomeTeam['homeTeam'])
                                <p>____{{$eventHomeTeam['minute']." perc: ".$eventHomeTeam['team']." csapat ".$eventHomeTeam['type']." ". $eventHomeTeam['playerName'] }} </p>
                            @endif
                        @empty
                        @endforelse

                        {{-- <a href="{{ route('games.show', ['game' => $game] ) }}" class="p-2 block bg-sky-900 hover:bg-sky-700 text-white">Mérkőzésrészletezés </a> --}}
                    </div>
                    <div class="teamRight">
                        @if (isset($game->awayTeam->img))
                            <img src={{$game->awayTeam->img}} alt="">
                        @else
                            <img src="/images/wcIMG.jpg" alt="">
                        @endif
                        <h1>{{$game->awayTeam->name}}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
p
