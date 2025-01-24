<x-app-layout>
    <x-slot name="title">
        Kampagnen-Übersicht
    </x-slot>


    <section class="container g-pt-100 g-pb-70">
        <h1>Kampagnen-Übersicht</h1>
        <x-button-link link="{{route('start')}}" title="Intern"/>
        <x-button-link link="{{route('campaign.showall')}}" title="Kampagne Übersicht"/>

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
        <form action="{{route('campaignmgt.store')}}" method="post">
            @csrf
            <div class="form-group">
                <label for="name">Namen</label>
                <input type="text" class="form-control" id="name" name="name" aria-describedby="name" value="{{old('name')}}">
                <small id="name" class="form-text text-muted">Beim Anlegen wird ein Slug von der URL gebildet.</small>
            </div>
            <div class="form-group">
                <label for="description">Kurze Beschreibung</label>
                <input type="text" class="form-control" id="description" name="description" aria-describedby="description" value="{{old('description')}}">
            </div>
            <div class="form-group">
                <label for="editor">Info</label>
                <textarea class="form-control" id="editor" name="editor">{{old('editor')}}</textarea>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Anlegen</button>
        </form>
    </section>
    <script src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>
    <script>
        ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>
    <!-- End About -->
</x-app-layout>
