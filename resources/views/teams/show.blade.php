{{-- maybe later for the form --}}
<x-guest-layout>
    <div class="csapatokPage">
        <div class="container">
            <div class="title">
                Csapat név: {{$team->name}}
                @if (isset($team->img))
                    <img src={{$team->img}} alt="">
                @else
                    <img src="/wcIMG.jpg" alt="">
                @endif
            </div>
            <div class="grid grid-cols-3 gap-2">
                <h1 class='text-5xl'>A csapat játékosai:</h1><br><br>
                @forelse($playersInfo as $playerInfo)

                    <div class="p-2 border-2 border-green-600 csapatok">
                        {{$playerInfo['player_name']}}<br>
                        {{$playerInfo['szuletes']}}<br>
                        A játékos statisztikája:
                        sárgalapok
                        {{$playerInfo['sargalapok']}}
                        piroslapok
                        {{$playerInfo['piroslapok']}}
                        szerzett gólok
                        {{$playerInfo['golok']}}
                        öngólok
                        {{$playerInfo['ongolok']}}


                    </div>

                @empty
                @endforelse
            </div>
            <div class="merkozesekPage">
                <div class="container">
                    <div class="allGames">
                        <h1>A csapat mérközései</h1>

                            @forelse($games as $game)
                                @if($game->hometeams_id == $team->id || $game->awayteams_id == $team->id)
                                    <div class="oneGame">
                                        <div class="teamLeft">
                                            @if (isset($game->homeTeam->img))
                                                <img src={{$game->hometeam->img}} alt="">
                                            @else
                                                <img src="/wcIMG.jpg" alt="">
                                            @endif
                                            <h1>{{$game->homeTeam->name}}</h1>
                                        </div>
                                        <div class="vs">
                                            @forelse($gameScores as $score)
                                                @if($game->id == $score['game_id'])
                                                    <p>{{$score['home_team_score']}} vs {{$score['away_team_score']}}</p>

                                                @endif
                                            @empty
                                            @endforelse
                                            <a href="{{ route('games.show', ['game' => $game] ) }}" class="p-2 block bg-sky-900 hover:bg-sky-700 text-white">Mérkőzésrészletezés </a>
                                        </div>
                                        <div class="teamRight">
                                            @if (isset($game->awayTeam->img))
                                                <img src={{$game->awayTeam->img}} alt="">
                                            @else
                                                <img src="/wcIMG.jpg" alt="">
                                            @endif
                                            <h1>{{$game->awayTeam->name}}</h1>
                                        </div>
                                    </div>

                                @endif

                            @empty
                            @endforelse

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
