<x-app-layout>
    <x-slot name="title">
        Internes
    </x-slot>

    <!-- About -->
    <section class="container g-pt-100 g-pb-70">
        @php
            $userRolesReadable = \App\Models\User::getAllRolesOfUser(null, true);
            //$userRoles         = \App\Models\User::getAllRolesOfUser();
        @endphp
        <h1>Willkommen im TTT Internen Bereich</h1>
        <p class="lead">Angemeldet als: {{\Illuminate\Support\Facades\Auth::user()->global_name}}. Du hast folgende Gruppen: {{implode(", ", $userRolesReadable)}}</p>
        <div class="mt-3">
            @if(\App\Models\User::UserIn(\App\Enums\Roles::Offizier))
                <p class="lead mt-3 mb-3">Da du zu den Offizieren des TTT gehörst, stehen dir folgende Möglichkeiten zur Verfügung </p>
                <x-button-link link="{{route('offizier.missionsteilnahme')}}" title="Missionsteilnahme einsehen"/>
                <x-button-link link="{{route('offizier.user')}}" title="Übersicht alle Mitglieder"/>
            @endif
            <br>
            @if(\App\Models\User::UserIn(\App\Enums\Roles::Missionsbauer))
                <p class="lead mt-3 mb-3">Du bist Missionsbauer bist, kannst du auf den Missionsupload zugreifen</p>
                <x-button-link link="{{route('missionupload.index')}}" title="Missionsupload"/>
            @endif
                <br>
                <p class="lead mt-3 mb-3">Folgende Möglichkeiten stehen dir zur Verfügung</p>
                <x-button-link link="{{route('squadxml.index')}}" title="SquadXML"/>
        </div>

    </section>
    <!-- End About -->
</x-app-layout>
