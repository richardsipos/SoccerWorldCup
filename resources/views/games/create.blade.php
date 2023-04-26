<x-guest-layout >
    <h2>Új bejegyzés</h2>

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

    <form action="{{ route('games.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @csrf

        Otthoni csapat: <br>
        @foreach($teams as $team)
            <input type="radio" name="hometeams_id" value={{$team->id}}>{{$team->name}}
        @endforeach
        Idegen csapat: <br>
        @foreach($teams as $team)
            <input type="radio" name="awayteams_id" value={{$team->id}}>{{$team->name}}
        @endforeach


        Dátum: <input type="datetime-local" name="start"><br>


        <button type="submit" class="p-2 inline-block bg-sky-900 hover:bg-sky-700 text-white">Létrehozás</button>
    </form>
</x-guest-layout>



{{-- For Creating Event --}}
{{-- <x-guest-layout >
    <h2>Új bejegyzés</h2>

    <form action="{{ route('games{{$game->id}}.store') }}" method="POST" enctype="multipart/form-data">
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
        @foreach($players as $player)
        <input  type="radio" name="players[]" value="{{ $player -> id }}"> {{$player-> name}}
        @endforeach

        <button type="submit" class="p-2 inline-block bg-sky-900 hover:bg-sky-700 text-white">Mentés</button>
    </form>
</x-guest-layout> --}}
