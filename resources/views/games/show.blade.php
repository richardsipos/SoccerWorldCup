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
                    <button>
                        @can('delete', $game)
                            <form action="{{ route('games.destroy', ['game' => $game ])}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 inline-block bg-sky-900 hover:bg-sky-700 text-white">Törlés</button>
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
    <div class="mb-px-153">
        <h2>Új event:</h2>

        <form action="{{ route('events.store')}}" method="POST" enctype="multipart/form-data">
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


            <button type="submit" class="p-2 inline-block bg-sky-900 hover:bg-sky-700 text-white">Mentés</button>
        </form>
    </div>
</x-guest-layout>
