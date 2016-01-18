<?php

use jlourenco\base\Database\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagingTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('WarningType', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('color', 6);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('Warning', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('warningtype')->unsigned();
            $table->text('message');
            $table->string('permissions', 250)->nullable();
            $table->timestamp('release_date')->nullable();
            $table->timestamp('remove_date')->nullable();
            $table->string('position', 20);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('warningtype')->references('id')->on('WarningType');
        });

        Schema::create('Message', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sent_by')->unsigned();
            $table->integer('parent')->unsigned();
            $table->text('body');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('sent_by')->references('id')->on('User');
            $table->foreign('parent')->references('id')->on('Message');
        });

        Schema::create('MessageLog', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('message')->unsigned();
            $table->tinyinteger('status');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('message')->references('id')->on('Message');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::drop('WarningType');
        Schema::drop('Warning');
        Schema::drop('MessageLog');
        Schema::drop('Message');

    }

}
