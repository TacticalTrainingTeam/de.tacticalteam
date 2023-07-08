<x-app-layout>
    <x-slot name="title">
        Internes
    </x-slot>

    <!-- About -->
    <section class="container g-pt-100 g-pb-70">
        <h1>Willkommen im TTT Internen Bereich</h1>
        Angemeldet als: {{\Illuminate\Support\Facades\Auth::user()->global_name}}<br><br>
        @php
        $userRolesReadable = \App\Models\User::getAllRolesOfUser(null, true);
        //$userRoles         = \App\Models\User::getAllRolesOfUser();
        @endphp
        Du hast folgende Gruppen: {{implode(",", $userRolesReadable)}}
        <br>
        <br>
        Dir stehen folgende Möglichkeiten zur Verfügung:
        <ul>
            @if(\App\Models\User::UserIn(\App\Enums\Roles::Offizier))
                <li><a href="{{route('offizier.missionsteilnahme')}}">Missionsteilnahme</a></li>
            @endif
            @if(\App\Models\User::UserIn(\App\Enums\Roles::Missionsbauer))
                <li><a href="{{route('missionupload.index')}}">Missionsupload</a></li>
            @endif
        </ul>
    </section>
    <!-- End About -->
</x-app-layout>
