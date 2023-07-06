<x-app-layout>
    <x-slot name="title">
        Internes
    </x-slot>

    <!-- About -->
    <section class="container g-pt-100 g-pb-70">
        <h1>Willkommen im TTT Internen Bereich</h1>
        Angemeldet als: {{\Illuminate\Support\Facades\Auth::user()->global_name}}<br><br>
        Du hast folgende Gruppen: {{implode(",", \App\Models\User::getAllRolesOfUser(null, true))}}
    </section>
    <!-- End About -->
</x-app-layout>
