<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

class Migrate04_create_roles_table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(Builder $schema)
    {
        if ( !$schema->hasTable('roles')) {
            $schema->create('roles', function (Blueprint $table) {
                $table->id();
                $table->string('key');
                $table->string('name');
                $table->string('description')->nullable();
                $table->timestamps();
            });

            $schema->table('users', function(Blueprint $table) {
                $table->foreignId('role_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(Builder $schema)
    {
        if ( $schema->hasColumn('users', 'role_id') ) {
            $schema->table('users', function(Blueprint $table) {
                $table->dropForeign('role_id');
            });
        }
        $schema->dropIfExists('roles');
    }
}
