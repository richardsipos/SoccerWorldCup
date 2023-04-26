<x-guest-layout>

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


    <form action="{{ route('games.update', ['game' => $game]) }}" method="POST">
        @csrf
        @method('PATCH')
        Otthoni csapat: <br>
        @foreach($teams as $team)
            @if ($team->id == old('hometeams_id',$game->hometeams_id))
                <input type="radio" checked name="hometeams_id" value={{$team->id}}>{{$team->name}}
            @else
                <input type="radio" name="hometeams_id" value={{$team->id}}>{{$team->name}}
            @endif
        @endforeach
        Idegen csapat: <br>
        @foreach($teams as $team)
            @if ($team->id == old('awayteams_id',$game->awayteams_id))
                <input type="radio" checked name="awayteams_id" value={{$team->id}}>{{$team->name}}
            @else
                <input type="radio" name="awayteams_id" value={{$team->id}}>{{$team->name}}
            @endif
        @endforeach

        Dátum: <input type="datetime-local" name="start" value="{{ old('date', $game -> start) }}"><br>


        {{-- Tartalom:<br>
        <textarea name="content" cols="80" rows="5">{{ old('content', $post -> content) }}</textarea><br>


        Dátum: <input type="date" name="date" value="{{ old('date', $post -> date) }}"><br> --}}


        <button type="submit" class="p-2 inline-block bg-sky-900 hover:bg-sky-700 text-white">Mentés</button>
    </form>
    </x-guest-layout>
