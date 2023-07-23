<x-app-layout>
    <x-slot name="title">
        Missionsupload
    </x-slot>
    <!-- About -->
    <section class="container g-pt-100 g-pb-70">
        <h1>Missionsübersicht</h1>
        <br>
        <x-button-link link="{{route('missionsupload.upload')}}" title="Neue Mission hochladen"/>
        <x-button-link link="{{route('start')}}" title="Intern"/>
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
                <td>Letzte Änderung/Datumstempel</td>
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
