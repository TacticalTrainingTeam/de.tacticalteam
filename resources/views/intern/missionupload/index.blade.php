<x-app-layout>
    <x-slot name="title">
        Missions-Upload Übersicht
    </x-slot>
    <!-- About -->
    <section class="container g-pt-100 g-pb-70">
        <h1>Übersicht aller Missionen</h1>
        <br>
        <br>
        <table id="example" class="display" style="width:100%">
            <thead>
            <tr>
                <td>#</td>
                <td>Dateiname</td>
                <td>Letzte Änderung/Datumsstempel</td>
            </tr>
            </thead>
            <tbody>
            <?php
            $counter = 1;
            ?>
            @foreach($missions as $mission)
                <tr>
                    <td>{{$counter}}</td>
                    <td>{{$mission['name']}}</td>
                    <td>{{$mission['change']}}</td>
                </tr>
                    <?php
                    $counter = $counter + 1;
                    ?>
            @endforeach
            </tbody>
        </table>
    </section>
    <!-- End About -->
</x-app-layout>
