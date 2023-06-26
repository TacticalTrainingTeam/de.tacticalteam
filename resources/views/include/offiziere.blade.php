<section class="container g-pt-100 g-pb-70">
    <!-- Heading -->
    <div class="row justify-content-center text-center g-mb-50">
        <div class="col-lg-9">
            <h2 class="h2 g-color-white g-font-weight-600 mb-2">
                Die Offiziere
            </h2>
            <div class="d-inline-block g-width-30 g-height-2 g-bg-primary mb-2"></div>
            <p class="lead mb-0">
                Unsere schlauen Köpfe arbeiten an vielen Projekten gleichzeitig
                und bringen frischen Wind in die Arma-Welt. Wenn du Ideen
                mitbringst, kannst du dich in den zahlreichen Projektgruppen
                beteiligen. Gemeinsam setzen wir neue Vorhaben schneller um als
                andere Communities!
            </p>
        </div>
    </div>
    <!-- End Heading -->

    <div class="row">
        @foreach($offiziere as $offizier)
            <div class="col-lg-4 col-sm-6 g-mb-30">
                <!-- Team Block -->
                <div class="u-info-v6-1">
                    <!-- Figure -->
                    <figure class="u-block-hover">
                        <!-- Figure Image -->
                        <img class="w-100" src="{{asset($offizier->img_path)}}" alt="Image Description" />
                        <!-- End Figure Image-->
                    </figure>

                    <!-- Figure Info -->
                    <div class="g-bg-gray-dark-v2 g-pt-25" style="padding: 10px">
                        <div class="g-mb-15">
                            <h2 class="h5 g-color-white g-font-weight-600">
                                {{$offizier->name}}
                            </h2>
                            <em
                                class="d-block u-info-v6-1__item g-font-style-normal g-font-size-11 text-uppercase g-color-primary">{{$offizier->posten}}</em>
                        </div>

                        <p style="padding: 10px">
                            {{$offizier->posten_text}}
                        </p>
                        Offizier seit: {{date('d.m.Y', strtotime($offizier->off_seid))}}
                    </div>
                    <!-- End Figure Info-->
                </div>
                <!-- End Team Block -->
            </div>
        @endforeach
    </div>
</section>
