<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ClickTrack extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('click_track', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('link_id')->index();
            $table->string('browser', 64)->nullable()->index();
            $table->string('browser_version', 64)->nullable();
            $table->string('is_mobile', 64)->nullable()->index();
            $table->string('device_type', 64)->nullable();
            $table->string('os', 64)->nullable();
            $table->string('os_version', 64)->nullable();
            $table->string('timezome', 64)->nullable();
            $table->string('city', 64)->nullable()->index();
            $table->string('state', 64)->nullable()->index();
            $table->string('country', 64)->nullable()->index();
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
        Schema::drop('click_track');
    }
}
