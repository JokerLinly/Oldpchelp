<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePcersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pcers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('wcuser_id');
            $table->string('name');
            $table->string('nickname');//昵称
            $table->string('school_id');//学号
            $table->char('school_level',2);//年级
            $table->string('long_number');
            $table->string('number')->nullable();//短号
            $table->string('department');//学系
            $table->string('major');//专业
            $table->string('clazz');//班级
            $table->string('address');//具体地址
            $table->char('area',1)->default(0);// 0是东区 1是西区
            $table->char('state',1)->default(0);//0是pc队员 1是管理员
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
        Schema::drop('pcers');
    }
}
