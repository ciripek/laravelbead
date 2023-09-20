composer install --no-interaction

# .env

php artisan key:generate

npm install
npm run dev -- build

New-Item ./database/database.sqlite -ItemType file -Force
php artisan migrate:fresh --seed

php artisan serve
