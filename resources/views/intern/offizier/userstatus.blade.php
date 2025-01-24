<x-app-layout>
    <x-slot name="title">
        User Status
    </x-slot>

    <!-- About -->
    <section class="container g-pt-100 g-pb-70">
        <h1>User Status ändern bei: {{\App\Models\User::getUsername($user)}}</h1>
        <x-button-link link="{{route('start')}}" title="Intern"/>
        <x-button-link link="{{route('offizier.user')}}" title="Zur Übersicht"/>
        <div class="alert alert-primary" role="alert">
            Hier hast du die Möglichkeit den Status eines Users zu ändern. Ein User ist standardmäßig aktiv, er kann sich einloggen und alles nutzten. <br>
            Ist ein User Inaktiv/Gesperrt, kann dieser sich nicht mehr einloggen und sein Squad-XML Eintrag wird entfernt. Dieser Effekt tritt sofort für den User ein.<br><br>
            Aus Sicherheitsgründen wird diese Aktion per Logbuch festgehalten.
        </div>
        @if($user->active === 1)
            <h3>Aktueller Status: <span class="badge badge-success">Aktiv</span></h3>
        @else
            <h3>Aktueller Status: <span class="badge badge-danger">Inaktiv/Gesperrt</span></h3>
        @endif
        <br>
        <form method="POST" action="{{route('offizier.userstatus.store')}}">
            @csrf
            <input type="hidden" id="userid" name="userid" value="{{$user->id}}">
            @if($user->active === 1)
                <button type="submit" class="btn btn-danger">{{\App\Models\User::getUsername($user)}} deaktivieren/sperren</button>
            @elseif($user->active === 0)
                <button type="submit" class="btn btn-success">{{\App\Models\User::getUsername($user)}} aktivieren</button>
            @endif

        </form>
    </section>
    <!-- End About -->
</x-app-layout>
