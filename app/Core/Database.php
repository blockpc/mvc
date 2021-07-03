<?php
namespace App\Core;

use Database\Seeders\Seed;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Support\Facades\Schema;

defined('DB_CONNECTION') or define('DB_CONNECTION', $_ENV['DB_CONNECTION']);
defined('DB_HOST') or define('DB_HOST', $_ENV['DB_HOST']);
defined('DB_DATABASE') or define('DB_DATABASE', $_ENV['DB_DATABASE']);
defined('DB_USERNAME') or define('DB_USERNAME', $_ENV['DB_USERNAME']);
defined('DB_PASSWORD') or define('DB_PASSWORD', $_ENV['DB_PASSWORD']);

class Database
{
    public Capsule $capsule;

    public function __construct()
    {
        $this->capsule = new Capsule();
        $this->capsule->addConnection([
            'driver' => DB_CONNECTION,
            'host' => DB_HOST,
            'database' => DB_DATABASE,
            'username' => DB_USERNAME,
            'password' => DB_PASSWORD,
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]);
        // Setup the Eloquent ORM
        $this->capsule->setAsGlobal();
        $this->capsule->bootEloquent();
        $this->migration_table();
    }

    public function migration_table()
    {
        if ( !Capsule::schema()->hasTable('migrations') ) {
            Capsule::schema()->create('migrations', function ($table) {
                $table->id();
                $table->string('migration')->unique();
                $table->timestamps();
            });
        }
    }

    public function migrations(bool $fresh = false)
    {
        $dir = __DIR__.'/../../database/migrations';
        $schema = $this->capsule->schema();
        if ( $fresh ) {
            Capsule::table('migrations')->truncate();
        }
        $applies = Capsule::table('migrations')->pluck('migration')->toArray();
        $to_apply = $this->scan_dir($dir);
        if ( !$migrations = array_diff($to_apply, $applies) ) {
            $this->log("All migrations done");
        }
        $schema->disableForeignKeyConstraints();
        foreach( $migrations as $migration ) {
            $now = date("Y-m-d H:i:s");
            require_once "{$dir}/{$migration}.php";
            $instance = new $migration();
            if ( $fresh ) {
                $instance->down($schema);
            }
            $instance->up($schema);
            Capsule::insert("INSERT INTO migrations (migration, created_at, updated_at) VALUES (:migration, :created_at, :updated_at);", ['migration' => $migration, 'created_at' => $now, 'updated_at' => $now]);
            $this->log("Migration: {$migration} done");
        }
        $schema->enableForeignKeyConstraints();
    }

    public function seeders()
    {
        $schema = $this->capsule->schema();
        $schema->disableForeignKeyConstraints();
        $seeder = new Seed;
        $seeder->run();
        $schema->enableForeignKeyConstraints();
        $seeders = $this->scan_dir(__DIR__.'/../../database/seeders');
        foreach( $seeders as $seed ) {
            $this->log("Seeder: {$seed} done");
        }
    }

    protected function log(string $message)
    {
        echo '[' . date('Y-m-d H:i:s') . '] ' . $message . PHP_EOL;
    }

    protected function scan_dir(string $dir): array
    {
        $temp = [];
        foreach ($files = scandir($dir) as $file) {
            if ( $file === '.' || $file === '..' || $file === 'Seed.php' ) {
                continue;
            }
            $temp[] = str_replace(".php", "", $file);
        }
        return $temp;
    }
}