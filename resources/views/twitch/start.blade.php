<x-app-layout>
    <x-slot name="title">
        Twitch Livestreams
    </x-slot>

    <!-- About -->
    <section class="container g-pt-100 g-pb-70">
        <script src= "{{asset('assets/js/twitch_tv_js_embed_v1.js')}}"></script>
        <h2>Live-Streams von Mitgliedern des Tactical Training Teams</h2>
        <br>
        <p class="lead">Möchtest du auch hier angezeigt werden? Dein Stream sollte unbedingt die Schlüsselwörter 'tacticalteam.de' oder 'Tactical Training Team' enthalten.</p>
        @if(count($streams) > 0)
            @foreach($streams as $stream)
                <h3><a href="https://twitch.tv/{{$stream->user_login}}" target="_blank">twitch.tv/{{$stream->user_login}}</a></h3>
                <span id="{{$stream->user_login}}"></span>
                <script type="text/javascript">
                    var options = {
                        width: 400,
                        height: 300,
                        channel: "{{$stream->user_login}}",
                    };
                    var player{{$stream->user_login}} = new Twitch.Player("{{$stream->user_login}}", options);
                    player{{$stream->user_login}}.setVolume(0.5);
                </script>
            @endforeach
        @else
            <p class="lead">Aktuell sind keine Streams für das TTT verfügbar.</p>
        @endif
    </section>
    <!-- End About -->
</x-app-layout>
