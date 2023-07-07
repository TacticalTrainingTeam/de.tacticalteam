<x-app-layout>
    <x-slot name="title">
        Missions-Upload Übersicht
    </x-slot>
    <!-- About -->
    <section class="container g-pt-100 g-pb-70">
        <h1>Mission hochladen</h1>
        <h4><a href="https://wiki.tacticalteam.de/de/Missionsbau" target="_blank">>>>Missionsbau-Hinweise<<<</a></h4>
        <br>
        <form action="{{route("missionsupload.store")}}" method="post" enctype="multipart/form-data">
            @csrf
            <label for="missionfinal">Ist das eine fertige Mission die bereit zum Spielen ist?</label>

            <select name="missionfinal" id="missionfinal">
                <option value="0" disabled selected>--- Bitte auswählen</option>
                <option value="1">Ja</option>
                <option value="2">Nein</option>
                <option value="3" disabled>Ich habe keine Ahnung -> In diesem Fall sollte ich mir die Missionbau-Hinweise nochmal durchlesen!</option>
            </select>
            <div id="missiontester" style="display: none">
                <input type="checkbox" id="tests" name="tests" value="1">
                <label for="tests">Ich habe einen Alpha- und Beta-Test gemacht und mich an alle Missionsbau-Hinweise gehalten</label>
            </div>
            <hr>
            <input type="file" name="mission" accept=".pbo">
            <br><br>
            <button type="submit">Mission hochladen</button>
        </form>
    </section>
    <!-- End About -->
</x-app-layout>
