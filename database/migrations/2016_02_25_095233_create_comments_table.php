<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ticket_id');
            $table->char('from',1);// 0是用户 1是pc队员给管理员 2是pc队员给用户 3是pc管理员发给该订单的用户 4是pc管理员发给该订单负责的队员
            $table->char('state',1)->default(0);// 1 是已阅读
            $table->integer('wcuser_id');//关联微信用户
            $table->string('text');
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
        Schema::drop('comments');
    }
}
