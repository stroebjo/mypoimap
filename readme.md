# POI Map

## Development infos

- Reload autoloading: `$ composer dump-autoload`
- Enter Docker container for database relevant tasks: `$ docker-compose exec webserver bash`
- Execute all migration and refresh: `$ php artisan migrate:refresh --seed`
- Deploy `$ php deployer.phar deploy production`
