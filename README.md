# Framework BlockPC

Framework en PHP

## Instal Tailwind CSS
```batch
npm init -y
npm install -D tailwindcss@latest autoprefixer@latest postcss-cli@latest cssnano
npx tailwindcss init -p
```

## Compile CSS
- `'dev': 'npx tailwindcss -i resources/css/tailwind.css -o public/css/tailwind.css'`
- `'build': 'postcss resources/css/tailwind.css -o public/css/tailwind.css'`
- `'watch': 'TAILWIND_MODE=watch postcss resources/css/tailwind.css -o public/css/tailwind.css -w --verbose'`
- `'prod': 'NODE_ENV=production postcss resources/css/tailwind.css -o public/css/tailwind.css'`

## Run migrations
- `php ./cli/migrations.php -m -s -f`

-m: For run migrations
-s: For run seeder, optional
-f: Refresh database, optional
