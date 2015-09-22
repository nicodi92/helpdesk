<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComputerTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('software', function(Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();
            $table->integer('user_id')->unsigned();
            $table->string('name');
            $table->string('version')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('operating_systems', function(Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();
            $table->integer('user_id')->unsigned();
            $table->string('name');
            $table->string('version');
            $table->string('service_pack')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('computer_types', function(Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();
            $table->integer('user_id')->unsigned();
            $table->string('name');

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('computers', function(Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();
            $table->integer('user_id')->unsigned();
            $table->integer('type_id')->unsigned();
            $table->integer('os_id')->unsigned();
            $table->string('dn');
            $table->string('name');
            $table->string('description');
            $table->string('model')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('type_id')->references('id')->on('computer_types');
            $table->foreign('os_id')->references('id')->on('operating_systems');
        });

        Schema::create('computer_software', function(Blueprint $table)
        {
            $table->integer('computer_id')->unsigned();
            $table->integer('software_id')->unsigned();

            $table->foreign('computer_id')->references('id')->on('computers');
            $table->foreign('software_id')->references('id')->on('software');
        });

        Schema::create('computer_processors', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('computer_id')->unsigned();
            $table->string('name');
            $table->string('family')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('speed')->nullable();

            $table->foreign('computer_id')->references('id')->on('computers');
        });

        Schema::create('computer_processor_records', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('processor_id')->unsigned();
            $table->integer('load');
            $table->string('status')->nullable();

            $table->foreign('processor_id')->references('id')->on('computer_processors');
        });

        Schema::create('computer_hard_disks', function(Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();
            $table->integer('user_id')->unsigned();
            $table->integer('computer_id')->unsigned();
            $table->string('name');
            $table->double('capacity');
            $table->dateTime('installed')->nullable();
            $table->string('description')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('computer_id')->references('id')->on('computers');
        });

        Schema::create('computer_hard_disk_records', function(Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();
            $table->integer('user_id')->unsigned();
            $table->double('free');
            $table->string('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('computer_hard_disk_records');
        Schema::dropIfExists('computer_hard_disks');
        Schema::dropIfExists('computer_processor_records');
        Schema::dropIfExists('computer_processors');
        Schema::dropIfExists('computer_software');
        Schema::dropIfExists('computers');
        Schema::dropIfExists('computer_types');
        Schema::dropIfExists('operating_systems');
        Schema::dropIfExists('software');
    }
}
