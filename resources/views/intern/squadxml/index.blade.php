<x-app-layout>
    <x-slot name="title">
        SquadXML Einträge
    </x-slot>
    <!-- About -->
    <section class="container g-pt-100 g-pb-70">
        <h1>In SquadXML Eintragen</h1>
        <br>
        <x-button-link link="{{route('start')}}" title="Intern"/>
        <br><br>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger center" role="alert">
                    {{$error}}
                </div>
            @endforeach
        @endif
        @if(session('success'))
            <div class="alert alert-success center" role="alert">
                {{session('success')}}
            </div>
        @endif
        <p class="lead">
            Auf dieser Seite kannst du deinen SquadXML Eintrag erstellen und ansehen. Willst du einen Eintrag bearbeiten/löschen, wende dich bitte im TTT-Discord an Isaac, Menom oder Addi.
        </p>
        <br>
        <div class="row">
            <div class="col-6">
                <h3>Neuen Eintrag erstellen</h3>
                @if($locked === true)
                    <div class="alert alert-warning" role="alert">
                        Du hast bereits einen Eintrag erstellt, deswegen kannst du keinen neuen erstellen!
                    </div>
                @else
                    <form method="post" action="{{route("squadxml.store")}}">
                        @csrf
                        <div class="form-group">
                            <label for="steam">Steam64 ID</label>
                            <input type="text" class="form-control" id="steam" name="steam" required value="{{ old('steam') }}">
                        </div>
                        <div class="form-group">
                            <label for="username">Dein Name</label>
                            <input type="text" class="form-control" id="username" name="username" required value="{{ old('username') }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Eintragen</button>
                    </form>
                @endif
            </div>
            <div class="col-6">
                <h3>Deine bisherige Einträge</h3>
                <table id="example" class="display" style="width:100%">
                    <thead>
                    <tr>
                        <td>Steam64 ID</td>
                        <td>Name in der SquadXML</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($entries as $entry)
                        <tr>
                            <td>{{$entry['steam_id']}}</td>
                            <td>{{$entry['name']}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </section>
    <!-- End About -->
</x-app-layout>
