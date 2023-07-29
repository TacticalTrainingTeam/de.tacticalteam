<x-app-layout>
    <x-slot name="title">
        {{$campaign->name}}
    </x-slot>

    <!-- About -->
    <section class="container g-pt-100 g-pb-70">
        <h1>Kampagne: {{$campaign->name}} bearbeiten</h1>
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
        <form action="{{route('campaign.store', ['slug' => $campaign->slug])}}" method="post">
            @csrf
            <div class="form-group">
                <label for="name">Namen</label>
                <input type="text" class="form-control" id="name" name="name" aria-describedby="name" value="{{old('name', $campaign->name)}}">
                <small id="name" class="form-text text-muted">ACHTUNG: Das Ändern des Namens wird den Slug (also die URL) ändern, alte URLs werden somit ungültig werden!</small>
            </div>
            <div class="form-group">
                <label for="description">Kurze Beschreibung</label>
                <input type="text" class="form-control" id="description" name="description" aria-describedby="description" value="{{old('description', $campaign->shortDescription)}}">
            </div>
            <div class="form-group">
                <label for="editor">Info</label>
                <textarea class="form-control" id="editor" name="editor">{{old('editor', $campaign->info)}}</textarea>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status">
                    <option value="0">0 - Unsichtbar</option>
                    <option value="1">1 - Inaktiv</option>
                    <option value="5">5 - Öffentlich für alle</option>
                </select>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Speichern</button>
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
