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
