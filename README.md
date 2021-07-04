# Framework BlockPC

Framework en PHP

## Compile CSS
- `npx tailwindcss -i resources/css/tailwind.css -o public/css/tailwind.css`

## Run migrations
- `php ./cli/migrations.php -m -s -f`

-m: For run migrations
-s: For run seeder, optional
-f: Refresh database, optional
