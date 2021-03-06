<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWcusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wcusers', function (Blueprint $table) {
            $table->increments('id');
	        $table->string('openid');
	        $table->char('state',1)->default(0);//判断用户属性，0是普通用户，1是pc队员，2是pc管理员，3是骏哥哥
	        $table->char('subscribe',1)->default(0);//判断用户是否关注，0是未关注，或者已经取消关注，1是已关注
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
        //
    }
}
