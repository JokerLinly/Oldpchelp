<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relys', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');//自动回复标题
            $table->string('question')->nullable();//关键词
            $table->string('answer')->nullable();//自动回复内容
            $table->char('state',1)->default(0);//判断自动回复属性，0是被添加自动回复，1是消息自动回复，2是关键词自动回复
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
        Schema::drop('relys');
    }
}
