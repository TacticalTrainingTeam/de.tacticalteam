<x-app-layout>
    <x-slot name="title">
        Missions-Upload Übersicht
    </x-slot>
    <!-- About -->
    <section class="container g-pt-100 g-pb-70">
        <h1>Übersicht aller Missionen</h1>
        <br>
        <a class="btn btn-md u-btn-primary g-font-size-default text-uppercase g-py-12 g-px-30 mx-1 g-mb-20"
           href="{{route('missionsupload.upload')}}">Neue Mission hochladen</a>
        <a class="btn btn-md u-btn-primary g-font-size-default text-uppercase g-py-12 g-px-30 mx-1 g-mb-20"
           href="{{route('start')}}">Zur Startseite</a>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger center" role="alert">
                    {{$error}}
                </div>
            @endforeach
        @endif
        @if(session('success'))
            <div class="alert alert-success center" role="alert">
                {{session('success')}}
            </div>
        @endif
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
