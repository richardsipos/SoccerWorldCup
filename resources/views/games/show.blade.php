<x-guest-layout>
    <div class="merkozesekPage">
        <div class="container">
            <div class="allGames">
                <div class="oneGame">
                    <div class="teamLeft">

                        {{$imageFound = false;}}
                        @foreach ($teams as $team)
                                @if ($team -> image !== null && $team->id == $game->homeTeam->id)
                                    <img src="{{ Storage::url('images/'.$team -> image) }}" alt="">
                                    {{$imageFound = true;}}
                                @endif

                        @endforeach
                        @if (!$imageFound)
                            <img src="/wcIMG.jpg" alt="">
                        @endif

                        <h1>{{$game->homeTeam->name}}</h1>



                    </div>
                    <div class="vs">
                        <br><br><br><br>
                        <h2>Kezdés</h2>
                        {{$game -> start}}<br>
                        <h2>Állás</h2>
                        @forelse($gameScores as $score)
                            @if($game->id == $score['game_id'])
                                <p>{{$score['home_team_score']}} vs {{$score['away_team_score']}}</p>

                            @endif
                        @empty
                        @endforelse
                        <br><br><br><br><br><br>
                        @auth
                            @if(Auth::user()->is_admin)
                                <form action="{{ route('games.edit',  ['game' => $game ])}}" method="GET">
                                    @csrf
                                    <input class="bg-[#60B922] text-white p-2 inline-block" type="submit" value="Mérkőzés módosítása" />
                                </form>
                            @endif
                        @endauth

                        @forelse($eventsBothTeams as $eventHomeTeam)
                            @foreach($events as $event)
                                @if($event->id == $eventHomeTeam['id'])
                                    @if ($eventHomeTeam['homeTeam'])
                                        <p>{{$eventHomeTeam['minute']." perc: ".$eventHomeTeam['team']." csapat ".$eventHomeTeam['type']." ". $eventHomeTeam['playerName'] }} _____________________________________________</p>

                                        @can('delete', $event)
                                            <form action="{{ route('events.destroy', ['event' => $event ])}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="game_id" value="{{$game->id}}" >
                                                <button type="submit" class="p-2 inline-block bg-[#60B922] hover:bg-[#fcfcfc] text-white hover:text-[#60B922] border  hover:border-[#60B922]">Törlés</button>
                                            </form>
                                        @endcan
                                    @elseif (!$eventHomeTeam['homeTeam'])
                                        <p>________________________________________________{{$eventHomeTeam['minute']." perc: ".$eventHomeTeam['team']." csapat ".$eventHomeTeam['type']." ". $eventHomeTeam['playerName'] }} </p>

                                        @can('delete', $event)
                                            <form action="{{ route('events.destroy', ['event' => $event,'game_id' => $game->id ])}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="game_id" value="{{$game->id}}" >
                                                <button type="submit" class="p-2 inline-block bg-[#60B922] hover:bg-[#fcfcfc] text-white hover:text-[#60B922] border  hover:border-[#60B922]">Törlés</button>
                                            </form>
                                        @endcan
                                    @endif
                                @endif
                            @endforeach
                        @empty
                        @endforelse

                        {{-- <a href="{{ route('games.show', ['game' => $game] ) }}" class="p-2 block bg-sky-900 hover:bg-sky-700 text-white">Mérkőzésrészletezés </a> --}}
                    </div>
                    <div class="teamRight">
                        {{$imageFound = false;}}
                        @foreach ($teams as $team)
                                @if ($team -> image !== null && $team->id == $game->awayTeam->id)
                                    <img src="{{ Storage::url('images/'.$team -> image) }}" alt="">
                                    {{$imageFound = true;}}
                                @endif

                        @endforeach
                        @if (!$imageFound)
                            <img src="/wcIMG.jpg" alt="">
                        @endif


                        <h1>{{$game->awayTeam->name}}</h1>
                    </div>
                    <button>
                        @can('delete', $game)
                            <form action="{{ route('games.destroy', ['game' => $game ])}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 inline-block bg-[#60B922] hover:bg-[#fcfcfc] text-white hover:text-[#60B922] border  hover:border-[#60B922]">Törlés</button>
                            </form>
                        @endcan
                    </button>
                </div>
            </div>
        </div>
    </div>
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
    @auth
        @if(Auth::user()->is_admin)
            <div class="mb-px-153 h-screen flex items-center justify-center flex-col">
                @if($game->finished==true)

                @else

                    <p class="text-4xl">Új esemény létrehozása:</p>

                    {{-- <form action="{{ route('addEvent.store',['game' => $game])}}" method="POST" enctype="multipart/form-data"> --}}
                    <form action="{{ route('events.store')}}" method="POST">
                        @csrf
                        Hanyadik perc: <input type="text" name="minute" value="0"><br>
                        @error('minute')
                            {{ $message }}<br>
                        @enderror

                        Tipus (gól, öngól, sárga lap, piros lap):<br>
                        <input  type="text" name="type" ><br>
                        @error('type')
                            {{ $message }}<br>
                        @enderror

                        <h2>Játékosok:</h2>
                        <h4>Otthoni csapat játékosai:</h4>
                        @foreach($players as $player)
                            @if ($player->team_id == $game->hometeams_id)
                                <input  type="radio" name="player_id" value="{{ $player -> id }}"> {{$player-> name}}
                            @endif
                        @endforeach
                        <h4>Idegen csapat játékosai:</h4>
                        @foreach($players as $player)
                            @if ($player->team_id == $game->awayteams_id)
                                <input  type="radio" name="player_id" value="{{ $player -> id }}"> {{$player-> name}}
                            @endif
                        @endforeach
                        <input  type="hidden" name="game_id" value="{{$game->id}}">



                        <button type="submit" class="p-2 inline-block bg-[#60B922] hover:bg-[#fcfcfc] text-white hover:text-[#60B922] border  hover:border-[#60B922]">Mentés</button>
                    </form>
                @endif
            </div>
        @endif
    @endauth
</x-guest-layout>
