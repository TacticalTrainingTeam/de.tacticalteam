<x-app-layout>
    <x-slot name="title">
        User-Übersicht
    </x-slot>
    <!-- About -->
    <section class="container g-pt-100 g-pb-70">
        <h1>Übersicht aller User</h1>
        <x-button-link link="{{route('start')}}" title="Intern"/>
        <table id="example" class="display" style="width:100%">
            <thead>
            <tr>
                <th>Discord-ID</th>
                <th>Discord-Anzeigename</th>
                <th>Discord-Globalname</th>
                <th>Steam-ID</th>
                <th>Dabei-Seit</th>
                <th>Rollen</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($usersArray as $row) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['globalName'] . "</td>";
                echo "<td>" . $row['steam'] . "</td>";
                echo "<td>" . $row['erstellt'] . "</td>";
                echo "<td>" . $row['roles'] . "</td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
    </section>
    <!-- End About -->
</x-app-layout>
