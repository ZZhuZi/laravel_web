<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username',100)->default('')->comment('用户名');
            $table->char('phone',11)->comment('手机号');
            $table->char('password',32)->comment('用户密码');
            $table->string('image_url',200)->default('')->comment('用户头像');
            $table->char('token',32)->comment('token值');
            $table->char('expierd_at',32)->comment('过期时间');
            $table->enum('status',['1','2'])->default('1')->comment('用户状态 1 启用 2 禁用');
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
        Schema::dropIfExists('user');
    }
}
