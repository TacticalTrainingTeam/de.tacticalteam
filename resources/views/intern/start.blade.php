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
                <a class="btn btn-md u-btn-primary g-font-size-default text-uppercase g-py-12 g-px-30 mx-1 g-mb-20"
                   href="{{route('offizier.missionsteilnahme')}}">Missionsteilnahme</a>
            @endif
            @if(\App\Models\User::UserIn(\App\Enums\Roles::Missionsbauer))
                    <a class="btn btn-md u-btn-primary g-font-size-default text-uppercase g-py-12 g-px-30 mx-1 g-mb-20"
                       href="{{route('missionupload.index')}}">Missionsupload</a>
            @endif
        </div>

    </section>
    <!-- End About -->
</x-app-layout>
