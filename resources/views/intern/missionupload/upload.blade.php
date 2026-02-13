<x-app-layout>
    <x-slot name="title">
        Missionsupload
    </x-slot>
    <!-- About -->
    <section class="container g-pt-100 g-pb-70">
        <h1>Mission hochladen</h1>
        <x-button-link link="{{route('missionupload.index')}}" title="Missionsübersicht"/>
        <x-button-link link="{{route('start')}}" title="Intern"/>
        <h4><a href="https://wiki.tacticalteam.de/de/Missionsbau" target="_blank">>>>Missionsbau-Hinweise<<<</a></h4>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger center" role="alert">
                    {{$error}}
                </div>
            @endforeach
        @endif
        <br>
        <form action="{{route("missionsupload.store")}}" method="post" enctype="multipart/form-data">
            @csrf
            <div id="missionuploadcheck">
                <input type="checkbox" id="uploadcheck" name="uploadcheck" value="1">
                <label for="uploadcheck">Mir ist bewusst, dass eine auf den Server hochgeladene Mission von jedem gestartet werden kann.</label>
            </div>
            <hr>
            <input type="file" name="mission" accept=".pbo">
            <br><br>
            <button type="submit">Mission hochladen</button>
        </form>
    </section>
    <!-- End About -->
</x-app-layout>
