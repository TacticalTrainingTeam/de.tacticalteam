<x-app-layout>
    <x-slot name="title">
        Kampagnen-Übersicht
    </x-slot>


    <section class="container g-pt-100 g-pb-70">
        <h1>Kampagnen-Übersicht</h1>
        <x-button-link link="{{route('start')}}" title="Intern"/>
        <x-button-link link="{{route('campaign.add')}}" title="Neue Kampagne"/>

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

        <table id="example" class="display" style="width:100%">
            <thead>
            <tr>
                <td>Name</td>
                <td>Beschreibung</td>
                <td>Missionsbauer</td>
                <td>Erstellt</td>
                <td>Status</td>
                <td>Aktion</td>
            </tr>
            </thead>
            <tbody>

            @foreach($tabCam as $campaign)
                <tr>
                    <td>{{$campaign['name']}}</td>
                    <td>{{$campaign['shortDes']}}</td>
                    <td>{{implode(", ", $campaign['authors'])}}</td>
                    <td>{{$campaign['created']}}</td>
                    <td>{!! getStatusForCampaign($campaign['status']) !!}</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary  dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{route('campaign.edit', ['slug' => $campaign['slug']])}}">Bearbeiten</a>
                                <a class="dropdown-item" href="#">Missionsbauer Bearbeiten (WIP)</a>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>
    <!-- End About -->
</x-app-layout>
