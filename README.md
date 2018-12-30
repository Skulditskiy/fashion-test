Example commands for working with phinx migrations:
```
phinx create --configuration ../../phinx.yml NameOfMigration
phinx migrate --configuration ../../phinx.yml
```

Execute migrations and seeder in container:
```
docker exec -it fashiontest_app_1 /var/www/vendor/bin/phinx migrate --configuration ../phinx.yml
docker exec -it fashiontest_app_1 /var/www/vendor/bin/phinx seed:run --configuration ../phinx.yml
```

Run unit tests with coverage report:
```
php ./vendor/phpunit/phpunit/phpunit --coverage-text --bootstrap ./vendor/autoload.php --configuration ./tests/phpunit.xml ./tests
```
