<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function(Blueprint $table)
        {
            $table->increments('id')->unique();
            $table->unsignedInteger('owner_id');
            //$table->foreign('owner_id')->references('id')->on('users');
            $table->unsignedInteger('mediaable_id');
            $table->string('mediaable_type');
            $table->string('displayname')->nullable();
            $table->string('actualname')->nullable();
            $table->string('caption')->nullable();
            $table->string('description')->nullable();
            $table->string('url')->nullable();
            $table->string('thumbsUrl')->nullable();
            $table->string('filetype')->nullable();
            $table->unsignedInteger('filesize')->nullable();
            $table->boolean('scanned')->nullable();

            $table->timestamps();
        });

        Schema::create('example_object1', function(Blueprint $table)
        {
            $table->increments('id')->unique();
            $table->string('name',150);
            $table->string('description',150)->nullable();
            $table->timestamps();
        });

        Schema::create('example_object2', function(Blueprint $table)
        {
            $table->increments('id')->unique();
            $table->unsignedInteger('avatarID')->nullable();
            $table->string('name',150);
            $table->string('description',150)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('media');
        Schema::drop('example_object1');
        Schema::drop('example_object2');
    }
}
