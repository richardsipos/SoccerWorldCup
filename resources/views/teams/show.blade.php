{{-- maybe later for the form --}}
<x-guest-layout>
    <div class="csapatokPage">
        <div class="container">
            <div class = "m-3 flex items-center justify-center flex-col">
                @auth
                    @if(Auth::user()->is_admin)
                        <form action="{{ route('teams.edit',  ['team' => $team ])}}" method="GET">
                            @csrf
                            <input class="bg-[#60B922] hover:bg-[#fcfcfc] text-white hover:text-[#60B922] border  hover:border-[#60B922] p-2 inline-block" type="submit" value="Csapat módosítása" />
                        </form>
                    @endif
                @endauth
            </div>
            <div class="title">
                Csapat név: {{$team->name}}

                @if ($team -> image !== null)
                    <img src="{{ Storage::url('images/'.$team -> image) }}" alt="">
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

                        {{$playerToSend = null}}
                        @foreach ( $players as $player )
                            @if ( $player->name == $playerInfo['player_name'])
                                {{$playerToSend = $player}}

                            @endif

                        @endforeach

                        <button>
                            @can('delete', $player)
                                <form action="{{ route('players.destroy', ['player' => $playerToSend])}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 inline-block bg-[#60B922] hover:bg-[#fcfcfc] text-white hover:text-[#60B922] border  hover:border-[#60B922]">Törlés</button>
                                </form>
                            @endcan
                        </button>

                    </div>

                @empty
                @endforelse
            </div>
            <div class="merkozesekPage">
                <div class="container">
                    <div class="allGames m-3.5">
                        <h1>A csapat mérkőzései</h1>

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
                                            <h2>Kezdés</h2>
                                            {{$game -> start}}<br>
                                            <h2>Állás</h2>
                                            @forelse($gameScores as $score)
                                                @if($game->id == $score['game_id'])
                                                    <p>{{$score['home_team_score']}} vs {{$score['away_team_score']}}</p>

                                                @endif
                                            @empty
                                            @endforelse
                                            <a href="{{ route('games.show', ['game' => $game] ) }}" class="p-2 block bg-[#60B922] hover:bg-[#fcfcfc] text-white hover:text-[#60B922] border  hover:border-[#60B922]">Mérkőzésrészletezés </a>
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


    <div class="mb-px-153 h-screen flex items-center justify-center flex-col">
        @auth
            @if(Auth::user()->is_admin)
                <h2>Új játékos:</h2>

                <div class='pb-8'>
                    @if ($errors -> any())
                        <div>
                            Something went wrong
                        </div>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>
                                    {{$error}}
                                </li>

                            @endforeach
                        </ul>
                    @endif
                </div>
                <form action="{{ route('players.store')}}" method="POST">
                    @csrf
                    Játékos neve: <input type="text" name="name" value=""><br>

                    Játékos mezszáma<input  type="text" name="number" ><br>

                    Születési dátum: <input type="datetime-local" name="birthdate"><br>

                    <input  type="hidden" name="team_id" value="{{$team->id}}">


                    <button type="submit" class="p-2 inline-block bg-[#60B922] hover:bg-[#fcfcfc] text-white hover:text-[#60B922] border  hover:border-[#60B922]">Mentés</button>
                </form>
            </div>
        @endif
    @endauth
</x-guest-layout>
