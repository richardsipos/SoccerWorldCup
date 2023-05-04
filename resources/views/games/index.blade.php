<x-guest-layout>
    <div class="merkozesekPage">
        <div class="container">
            <div class="">
                @auth
                    @if(Auth::user()->is_admin)
                        <form action="{{ route('games.create')}}" method="GET">
                            @csrf
                            <input class="bg-[#60B922] text-white p-2 inline-block" type="submit" value="Mérkőzés létrehotása" />
                        </form>
                    @endif
                @endauth


            </div>
            @if (Session::get('game-created'))
                <div class="w-full text-center bg-green-700 mb-4 rounded-md text-white">
                    A bejegyzés sikeresen létrejött!
                </div>
            @endif
            <div class="allGames">
                <h1>Folyamatban levő mérkőzések</h1>

                    @forelse($ongoingGames as $ongoingGame)
                    <div class="oneGame">
                        <div class="teamLeft">
                            {{-- Ez egy hulyeseg mert a homeTeam idt add vissza, ezt meg kell old meg. --}}
                            {{$imageFound = false;}}
                            @foreach ($teams as $team)
                                    @if ($team -> image !== null && $team->id == $ongoingGame->homeTeam->id)
                                        <img src="{{ Storage::url('images/'.$team -> image) }}" alt="">
                                        {{$imageFound = true;}}
                                    @endif

                            @endforeach
                            @if (!$imageFound)
                                <img src="/wcIMG.jpg" alt="">
                            @endif

                            <h1>{{$ongoingGame->homeTeam->name}}</h1>
                        </div>
                        <div class="vs">
                            <h2>Kezdés</h2>
                            {{$ongoingGame -> start}}<br>
                            <h2>Állás</h2>
                            @forelse($gameScores as $score)
                                @if($ongoingGame->id == $score['game_id'])
                                    <p>{{$score['home_team_score']}} vs {{$score['away_team_score']}}</p>

                                @endif
                            @empty
                            @endforelse
                            <a href="{{ route('games.show', ['game' => $ongoingGame] ) }}" class="p-2 block bg-[#60B922] hover:bg-[#fcfcfc] text-white hover:text-[#60B922] border  hover:border-[#60B922]">Mérkőzésrészletezés </a>
                        </div>
                        <div class="teamRight">
                            {{$imageFound = false;}}
                            @foreach ($teams as $team)
                                    @if ($team -> image !== null && $team->id == $ongoingGame->awayTeam->id)
                                        <img src="{{ Storage::url('images/'.$team -> image) }}" alt="">
                                        {{$imageFound = true;}}
                                    @endif

                            @endforeach
                            @if (!$imageFound)
                                <img src="/wcIMG.jpg" alt="">
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
                            {{$imageFound = false;}}
                            @foreach ($teams as $team)
                                    @if ($team -> image !== null && $team->id == $finishedGame->hometeam->id)
                                        <img src="{{ Storage::url('images/'.$team -> image) }}" alt="">
                                        {{$imageFound = true;}}
                                    @endif

                            @endforeach
                            @if (!$imageFound)
                                <img src="/wcIMG.jpg" alt="">
                            @endif

                            <h1>{{$finishedGame->homeTeam->name}}</h1>
                        </div>
                        <div class="vs">

                            <h2>Kezdés</h2>
                            {{$finishedGame -> start}}<br>
                            <h2>Állás</h2>
                            @forelse($gameScores as $score)
                                @if($finishedGame->id == $score['game_id'])
                                    {{-- <p>{{$finishedGame->id}}</p> --}}
                                    <p>{{$score['home_team_score']}} vs {{$score['away_team_score']}}</p>

                                @endif
                            @empty
                            @endforelse
                            {{-- <a href="{{ route('posts.show', ['post' => $p] ) }}" class="p-2 block bg-sky-900 hover:bg-sky-700 text-white">Mérkőzésrészletezés </a> --}}
                            <a href="{{ route('games.show', ['game' => $finishedGame] ) }}" class="p-2 block bg-[#60B922] hover:bg-[#fcfcfc] text-white hover:text-[#60B922] border  hover:border-[#60B922]">Mérkőzésrészletezés </a>
                        </div>
                        <div class="teamRight">
                            {{$imageFound = false;}}
                            @foreach ($teams as $team)
                                    @if ($team -> image !== null && $team->id == $finishedGame->awayTeam->id)
                                        <img src="{{ Storage::url('images/'.$team -> image) }}" alt="">
                                        {{$imageFound = true;}}
                                    @endif

                            @endforeach
                            @if (!$imageFound)
                                <img src="/wcIMG.jpg" alt="">
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
