<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

class Migrate05_create_permissions_table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(Builder $schema)
    {
        if ( !$schema->hasTable('permissions')) {
            $schema->create('permissions', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('guard_name');
                $table->string('display_name', 255);
                $table->string('key');
                $table->text('description')->nullable();
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
        $schema->dropIfExists('permissions');
    }
}