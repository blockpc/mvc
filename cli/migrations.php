<?php

require __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

use App\Core\Database;
use splitbrain\phpcli\CLI;
use splitbrain\phpcli\Options;

class Migrations extends CLI
{
    protected $database;

    // register options and arguments
    protected function setup(Options $options)
    {
        $options->setHelp('Run migrations and seeder files');
        $options->registerOption('migrate', 'Run migrations','m');
        $options->registerOption('fresh', 'Regenerate migrations','f');
        $options->registerOption('seed', 'Run seeders', 's');
    }

    /**
     * Your main program
     *
     * Arguments and options have been parsed when this is run
     *
     * @param Options $options
     * @return void
     */
    protected function main(Options $options)
    {
        $this->database = new Database();

        if ($options->getOpt('help')) {
            echo $options->help();
        }

        if ($options->getOpt('migrate')) {
            //$this->info('migrate');
            $this->database->migrations($options->getOpt('fresh'));
        }

        if ($options->getOpt('seed')) {
            //$this->info('seeder');
            $this->database->seeders();
        }
    }
}

$cli = new Migrations();
$cli->run();