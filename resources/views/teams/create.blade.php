<x-guest-layout >
    <h2>Új csapat létrehozása</h2>

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

    <form action="{{ route('teams.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        Csapat név: <input type="text" name="name" value=""><br> <br>
        Csapat röviditése: <br> <input type="text" name="shortname" value=""><br> <br>
        Csapat logó (opcionális): <br> Fájl: <input type="file" name="image"><br>



        <button type="submit" class="p-2 inline-block bg-[#60B922] hover:bg-[#fcfcfc] text-white hover:text-[#60B922] border  hover:border-[#60B922]">Létrehozás</button>
    </form>
</x-guest-layout>
