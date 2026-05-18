#!/bin/bash
set -e

echo "Waiting for MySQL..."

until php -r "
try {
    new PDO('mysql:host=db;dbname=testdb', 'testuser', 'testpass');
} catch (Exception \$e) {
    exit(1);
}
"; do
  echo "MySQL not ready, retrying..."
  sleep 2
done

echo "MySQL is up!"

# Only run composer if composer.json exists
if [ -f "/var/www/html/composer.json" ]; then
    echo "Installing Composer dependencies..."
    composer install --no-interaction --optimize-autoloader
else
    echo "No composer.json found, skipping Composer."
fi

# Start Apache
exec apache2-foreground