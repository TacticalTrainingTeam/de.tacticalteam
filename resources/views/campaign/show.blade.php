<x-app-layout>
    <x-slot name="title">
        {{$campaign->name}}
    </x-slot>
    <style>
        p {font-size:1.25rem;font-weight:300}
    </style>


    <section class="container g-pt-100">
        <h1>{{$campaign->name}}</h1>
        <hr>
        <p class="lead">Erstellt durch: {{implode(", ", $authorsArray)}}</p>
        <p class="lead">{!! $campaign->info !!}</p>
    </section>
    <!-- End About -->
</x-app-layout>
