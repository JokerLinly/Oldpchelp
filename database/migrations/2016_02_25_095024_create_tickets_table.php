<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('wcuser_id');//关联微信用户
            $table->string('name');//报修人联系方式   
            $table->string('number');//报修人联系方式
            $table->string('shortnum')->nullable();
            $table->char('area',1)->default(0);// 0是东区 1是西区
            $table->string('address');//报修人具体地址
  
            $table->char('date',1);//1-5 代表星期一到星期五
            $table->string('hour');

            $table->char('date1',1)->nullable();//1-5 代表星期一到星期五
            $table->string('hour1')->nullable();

            $table->string('problem');

            $table->integer('pcer_id')->nullable();//关联PC志愿者
            $table->integer('pcadmin_id')->nullable();//关联PC管理员
            
            $table->char('state',1)->default(0);// 1订单未完成

            $table->char('assess')->nullable();//  1好评 2中评 3差评
            $table->string('suggestion')->nullable();
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
        Schema::drop('tickets');
    }
}
