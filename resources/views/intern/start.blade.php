<x-app-layout>
    <x-slot name="title">
        Internes
    </x-slot>

    <!-- About -->
    <section class="container g-pt-100 g-pb-70">
        <h1>Willkommen im TTT Internen Bereich</h1>
        <p class="lead">Angemeldet als: {{\Illuminate\Support\Facades\Auth::user()->global_name}}<br></p>
        @php
        $userRolesReadable = \App\Models\User::getAllRolesOfUser(null, true);
        //$userRoles         = \App\Models\User::getAllRolesOfUser();
        @endphp
        <p class="lead">Du hast folgende Gruppen: {{implode(", ", $userRolesReadable)}}</p>
        <div class="mt-3">
            @if(\App\Models\User::UserIn(\App\Enums\Roles::Offizier))
                <x-button-link link="{{route('offizier.missionsteilnahme')}}" title="Missionsteilnahme"/>
            @endif
            @if(\App\Models\User::UserIn(\App\Enums\Roles::Missionsbauer))
                    <x-button-link link="{{route('missionupload.index')}}" title="Missionsupload"/>
            @endif
                <x-button-link link="{{route('squadxml.index')}}" title="SquadXML"/>
        </div>

    </section>
    <!-- End About -->
</x-app-layout>
