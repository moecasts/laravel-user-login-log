<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLoginLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_login_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('loggable');
            $table->ipAddress('ip')->default('')->comment('login ip');
            $table->string('device')->default('')->comment('login device');
            $table->string('platform')->default('')->comment('login platform');
            $table->string('platform_version')->default('')->comment('login platform version');
            $table->string('browser')->default('')->comment('login browser');
            $table->string('browser_version')->default('')->comment('login browser version');
            $table->tinyInteger('device_type')->comment('login device type: 1: PC 2: Tablet 3: Phone 4: Robot');
            $table->timestamp('login_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_login_logs');
    }
}
