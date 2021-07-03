<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

class Migrate02_create_profiles_table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(Builder $schema)
    {
        if ( !$schema->hasTable('profiles')) {
            $schema->create('profiles', function (Blueprint $table) {
                $table->id();
                $table->string('firstname')->nullable();
                $table->string('lastname')->nullable();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
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
        $schema->table('profiles', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        $schema->dropIfExists('profiles');
    }
}
