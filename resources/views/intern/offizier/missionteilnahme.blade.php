<x-app-layout>
    <x-slot name="title">
        Mitgliederteilnahme
    </x-slot>

    <!-- About -->
    <section class="container g-pt-100 g-pb-70">
        <h1>Mitgliederteilnahme</h1>
        <x-button-link link="{{route('start')}}" title="Intern"/>
        <div class="alert alert-info" role="alert">
            Diese Seite zeigt an, wann ein registrierter Spieler zuletzt an einem Event teilgenommen hat. <br> Jeder Spieler wird dabei nur einmal angezeigt, jeweils mit seiner letzten Anmeldung zu einem Event.<br>Berücksichtigt werden nur Spieler, die mindestens einer der folgenden Gruppen angehören: Rekrut, Soldat, Veteran, Unteroffizier, Offizier oder Gastspieler.<br><br> Weitere Informationen zur Handhabung der Tabelle befinden sich unterhalb der Tabelle.
        </div>
        <table id="example" class="display" style="width:100%">
            <thead>
            <tr>
                <th>Name</th>
                <th>Event</th>
                <th>Slottungszeit</th>
                <th>Differenz in Tagen zu heute</th>
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
                <th>Slottungszeit</th>
                <th>Differenz in Tagen zu heute</th>
            </tr>
            </tfoot>
        </table>
        <br><br>
        <div class="alert alert-secondary" role="alert">
            Die Tabelle ist dynamisch aufgebaut und ermöglicht es, die Sortierung durch einen Klick auf die Spalten zu ändern. Du kannst aufsteigend oder absteigend sortieren lassen.
            Außerdem steht dir in der rechten oberen Ecke eine Suchfunktion zur Verfügung, mit der du nach jedem Begriff suchen kannst, der in der Tabelle vorkommt. Um die Tabelle übersichtlich zu halten, kannst du unten rechts die Pagination nutzen, um weitere Daten anzuzeigen.
            Dadurch wird verhindert, dass die Tabelle zu lange wird. In der oberen linken Ecke kannst du außerdem einstellen, wie viele Daten gleichzeitig angezeigt werden sollen.
        </div>
    </section>
    <!-- End About -->
</x-app-layout>
