<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fid')->default(0)->comment('父类id');
            $table->string('name',100)->default('')->comment('权限名字');
            $table->string('url',100)->default('')->comment('权限url地址');
            $table->enum('is_menu',['1','2'])->default('1')->comment('是否超管 1非 2 是');
            $table->integer('sort')->default(100)->comment('权限排序');
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
        Schema::dropIfExists('permission');
    }
}
