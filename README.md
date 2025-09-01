# Installationshilfe

Mittels `cd` in das Stammverzeichniss wechseln:

### Nur beim erstmaligen Installieren:

* `cp .env.example .env`
* In der neu erstellen .env Datei die nötigen Werte einstellen
* `php artisan key:generate`
* `php composer.phar install`

### Bei jedem Update:
* OPTIONAL: Wartungsmodus ein `php artisan down`
* `php artisan migrate`
* `php composer.phar install --optimize-autoloader --no-dev`
* `php artisan config:cache`
* OPTIONAL: Wartungsmodus aus `php artisan up`

### Crontab
Da jeden Tag um Mitternacht die SquadXML neu erstellt werden soll, muss für das Laravel Framework die Aufgabenplanung/Crontab gesetzt werden.
Dazu muss der folgende Eintrag adaptiert werden (Es muss jede Minute ausgeführt werden):
* `* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1`
