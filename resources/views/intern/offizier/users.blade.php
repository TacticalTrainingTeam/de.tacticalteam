<x-app-layout>
    <x-slot name="title">
        Mitgliederübersicht
    </x-slot>
    <!-- About -->
    <section class="container g-pt-100 g-pb-70">
        <h1>Mitgliederübersicht</h1>
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
        <table id="example" class="display" style="width:100%">
            <thead>
            <tr>
                <th>Discord-ID</th>
                <th>Discord-Globalname</th>
                <th>Discord-Anzeigename</th>
                <th>TTT Server Name</th>
                <th>Steam-ID</th>
                <th>Dabei-seit</th>
                <th>Rollen</th>
                <th>Status</th>
                <th>Aktion</th>
            </tr>
            </thead>
            <tbody>
            @foreach($usersArray as $row)
                <tr>
                    <td>{{$row['id']}}</td>
                    <td>{{$row['username']}}</td>
                    <td>{{$row['globalName']}}</td>
                    <td>{{$row['ttt_nick']}}</td>
                    <td>{{$row['steam']}}</td>
                    <td>{{$row['erstellt']}}</td>
                    <td>{{$row['roles']}}</td>
                    @if($row['active'] === 1)
                        <td><span class="badge badge-success">Aktiv</span></td>
                    @else
                        <td><span class="badge badge-danger">Inaktiv/Gesperrt</span></td>
                    @endif
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary  dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{route('offizier.userstatus', ['userid' => $row['id']])}}" target="_blank">User Status ändern</a>
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
