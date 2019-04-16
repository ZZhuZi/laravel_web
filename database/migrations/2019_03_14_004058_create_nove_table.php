<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoveTable extends Migration
{
    /**
     * Run the migrations.
     * 小说表
     * @return void
     */
    public function up()
    {
        Schema::create('novel', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('c_id')->comment('小说类型id');
            $table->integer('a_id')->comment('作者id');
            $table->string('name',100)->default('')->comment('小说名字');
            $table->string('image_url',120)->default('')->comment('小说封面');
            $table->string('tags',120)->default('')->comment('小说标签');
            $table->string('desc',200)->default('')->comment('小说标签');
            $table->enum('status',['1','2'])->default('1')->comment('小说状态 1 连载 2 完结');
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
        Schema::dropIfExists('novel');
    }
}
