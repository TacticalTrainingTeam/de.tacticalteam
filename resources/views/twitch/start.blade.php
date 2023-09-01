<x-app-layout>
    <x-slot name="title">
        Twitch Livestreams
    </x-slot>

    <!-- About -->
    <section class="container g-pt-100 g-pb-70">
        <script src= "https://player.twitch.tv/js/embed/v1.js"></script>
        <h2>Folgende Leute streamen gerade für das TTT:</h2>
        <p class="lead">Du willst auch hier angezeigt werden? Folgende Schlüsselwörter muss dein Stream enthalten: „tacticalteam.de“ oder „Tactical Training Team“ </p>
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
        @endif
    </section>
    <!-- End About -->
</x-app-layout>
