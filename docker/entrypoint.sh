#!/bin/bash
set -e

## Ajustar permissões dos diretórios do Laravel
#chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
#chmod -R 775 /var/www/storage /var/www/bootstrap/cache
#
## Execute Laravel optimization/setup commands
#composer install --optimize-autoloader --no-dev
#php artisan optimize
#php artisan config:cache
#php artisan route:cache
#php artisan view:cache
#
#npm install
#npm run build

# Now that optimizations are done, start the Apache server in the foreground
apache2-foreground
