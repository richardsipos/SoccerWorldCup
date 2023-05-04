<x-guest-layout>
    <div class="my-16 text-4xl flex items-center justify-center flex-col">Tabella</div>
    <div class="mb-px-64 flex items-center justify-center flex-col">
        @php
            $i = 0;
        @endphp
        <table class="p-3.5 border-2 border-[#60B922]">
            <tr>
                <th> Sorszám</th>
                <th> Csapatnév</th>
                <th> Pontszám</th>
                <th> Lőt gólok</th>
                <th> Kapott gólok</th>
            </tr>



        {{-- <div class="border-4 border-[#60B922] border-spacing-4"> --}}
            @foreach ($leaderboard as $team)
                <tr>
                    <td>{{$i = $i+1;}}</td>
                    <td>{{$team['name']}}</td>
                    <td>{{$team['score']}}</td>
                    <td>{{$team['goalsScored']}}</td>
                    <td>{{$team['goalsGot']}}</td>
                </tr>

            @endforeach

        {{-- </div> --}}

    </div>
</x-guest-layout>
