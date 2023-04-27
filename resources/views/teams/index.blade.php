{{-- @extends('layouts.app') --}}

{{-- @section('content') --}}
<x-guest-layout>
    <div class="csapatokPage">
        <div class="container">
            <div class="title">
                Csapatok
            </div>
            <div class="grid grid-cols-3 gap-2">

                @forelse($teams as $team)

                    <div class="p-2 border-2 border-green-600 csapatok">

                        @if ($team -> image !== null)
                            <img src="{{ Storage::url('images/'.$team -> image) }}" alt="">
                        @else
                            <img src="/wcIMG.jpg" alt="">
                        @endif
                        <h1>{{$team->name}}</h1>
                        <h2>{{$team->shortname}}
                            <a href="{{ route('teams.show', ['team' => $team] ) }}" class="p-2 block bg-sky-900 hover:bg-sky-700 text-white">Csapatrészletezés</a>
                    </div>

                @empty
                @endforelse
            </div>
        </div>
    </div>
</x-guest-layout>
    {{-- <a href="{{ route('posts.show', ['post' => $p] ) }}" class="p-2 block bg-sky-900 hover:bg-sky-700 text-white">Elolvasom</a> --}}
    {{-- {{ $teams -> links() }} --}}
{{-- @endsection --}}



