<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

class Migrate01_create_users_table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(Builder $schema)
    {
        if ( !$schema->hasTable('users')) {
            $schema->create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->softDeletes();
                $table->timestamps();
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
        $schema->dropIfExists('users');
    }
}