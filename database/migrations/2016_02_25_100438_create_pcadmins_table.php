<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePcadminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pcadmins', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pcer_id');
            $table->string('pw')->default(bcrypt('ilovepc'));//初始密码
            $table->softDeletes();
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
        Schema::drop('pcadmins');
    }
}
