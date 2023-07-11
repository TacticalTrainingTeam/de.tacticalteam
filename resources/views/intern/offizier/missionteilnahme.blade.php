<x-app-layout>
    <x-slot name="title">
        Internes
    </x-slot>

    <!-- About -->
    <section class="container g-pt-100 g-pb-70">
        <h1>Teilnahme der TTT-Mitspieler</h1>
        <x-button-link link="{{route('start')}}" title="Intern"/>
        <div class="alert alert-info" role="alert">
            Auf dieser Seite wird angezeigt, wann ein registrierter Spieler, das letzte mal an einem Event teilgenommen hat. <br> Dabei wird jeder Spieler nur einmal angezeigt, jeweils mit seiner letzten Anmeldung an einem Event.<br>Es werden nur Spieler beachtet, die in mindestens einer der folgenden Gruppen sind: Rekrut, Soldat, Veteran, Unteroffizier, Offizier oder Gastspieler.<br><br> Mehr Informationen zur Handhabung der Tabelle, sind unter der Tabelle zu finden.
        </div>
        <table id="example" class="display" style="width:100%">
            <thead>
            <tr>
                <th>Name</th>
                <th>Event</th>
                <th>Slotting-Time</th>
                <th>Differenz in Tagen zu Heute</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($result as $row) {
                $now = time();
                $your_date = strtotime($row['TimeOfSelectingSlot']);
                $datediff = $now - $your_date;
                $diff = round($datediff / (60 * 60 * 24));

                echo "<tr>";
                //echo "<td>" . $row['UserId'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['title'] . "</td>";
                echo "<td>" . $row['TimeOfSelectingSlot'] . "</td>";

                $now = time();
                $your_date = strtotime($row['TimeOfSelectingSlot']);
                $datediff = $now - $your_date;

                echo "<td style='background-color: " . getColorForMissions($diff)['bg-color'] . ";color:" . getColorForMissions($diff)['font'] . "'>" . $diff . " Tage</td>";
                echo "</tr>";
            }
            ?>
            </tbody>
            <tfoot>
            <tr>
                <th>Name</th>
                <th>Event</th>
                <th>Slotting-Time</th>
                <th>Differenz in Tagen zu Heute</th>
            </tr>
            </tfoot>
        </table>
        <br><br>
        <div class="alert alert-secondary" role="alert">
            Die Tabelle ist dynamisch aufgebaut, durch einen Klick auf die Spalten wird die Sortierung geändert. Man kann aufsteigen oder absteigend sortieren lassen. Des Weiteren kann man in der rechten oberen Ecke
            nach jedem Begriff suchen, der in der Tabelle vorkommt.<br> Über die Pagination unten rechts, kann man sich weitere Daten anzeigen. So wird verhindert, dass die Tabelle nicht zu lange wird. In der oberen linken Ecke, kann man einstellen, wie viele Daten jeweils aufeinmal angezeigt werden sollen.
        </div>
    </section>
    <!-- End About -->
</x-app-layout>
