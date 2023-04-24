<x-guest-layout>
    <div class="merkozesekPage">
        <div class="container">
            <div class="adminFunctions">
                <p>ide kerulnek az admin funkciok, csak az admin lattja ezt.</p>
            </div>
            <div class="allGames">
                <h1>Folyamatban levő mérkőzések</h1>

                    @forelse($ongoingGames as $ongoingGame)
                    <div class="oneGame">
                        <div class="teamLeft">
                            @if (isset($ongoingGame->homeTeam->img))
                                <img src={{$ongoingGame->hometeam->img}} alt="">
                            @else
                                <img src="/images/wcIMG.jpg" alt="">
                            @endif
                            <h1>{{$ongoingGame->homeTeam->name}}</h1>
                        </div>
                        <div class="vs">
                            @forelse($gameScores as $score)
                                @if($ongoingGame->id == $score['game_id'])
                                    <p>{{$score['home_team_score']}} vs {{$score['away_team_score']}}</p>

                                @endif
                            @empty
                            @endforelse
                            <a href="{{ route('games.show', ['game' => $ongoingGame] ) }}" class="p-2 block bg-sky-900 hover:bg-sky-700 text-white">Mérkőzésrészletezés </a>
                        </div>
                        <div class="teamRight">
                            @if (isset($ongoingGame->awayTeam->img))
                                <img src={{$ongoingGame->awayTeam->img}} alt="">
                            @else
                                <img src="/images/wcIMG.jpg" alt="">
                            @endif
                            <h1>{{$ongoingGame->awayTeam->name}}</h1>
                        </div>
                    </div>
                    @empty
                    @endforelse

            </div>
            <div class="allGames">
                <h1>Befejezett mérkőzések</h1>

                    @forelse($finishedGames as $finishedGame)
                    <div class="oneGame">

                        <div class="teamLeft">
                            @if (isset($team->img))
                                <img src={{$finishedGame->hometeam->img}} alt="">
                            @else
                                <img src="/images/wcIMG.jpg" alt="">
                            @endif
                            <h1>{{$finishedGame->homeTeam->name}}</h1>
                        </div>
                        <div class="vs">

                            @forelse($gameScores as $score)
                                @if($finishedGame->id == $score['game_id'])
                                    {{-- <p>{{$finishedGame->id}}</p> --}}
                                    <p>{{$score['home_team_score']}} vs {{$score['away_team_score']}}</p>

                                @endif
                            @empty
                            @endforelse
                            {{-- <a href="{{ route('posts.show', ['post' => $p] ) }}" class="p-2 block bg-sky-900 hover:bg-sky-700 text-white">Mérkőzésrészletezés </a> --}}
                            <a href="{{ route('games.show', ['game' => $finishedGame] ) }}" class="p-2 block bg-sky-900 hover:bg-sky-700 text-white">Mérkőzésrészletezés </a>
                        </div>
                        <div class="teamRight">
                            @if (isset($finishedGame->awayTeam->img))
                                <img src={{$finishedGame->awayTeam->img}} alt="">
                            @else
                                <img src="/images/wcIMG.jpg" alt="">
                            @endif
                            <h1>{{$finishedGame->awayTeam->name}}</h1>
                        </div>
                    </div>
                    @empty
                    @endforelse



            </div>
            {{ $finishedGames -> links() }}


        </div>


    </div>

    {{-- <h1>Itt kene megjelenjen</h1> --}}

</x-guest-layout>
