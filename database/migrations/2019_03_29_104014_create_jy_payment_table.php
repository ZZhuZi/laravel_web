<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJyPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jy_payment', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pay_name',30)->default('')->comment('支付方式名称');
            $table->string('pay_desc',50)->default('')->comment('支付简单描述');
            $table->tinyInteger('pay_order')->default()->comment('支付顺序');
            $table->string('pay_config',30)->default('')->comment('支付方式的配置');
            $table->enum('status',[1,2])->default('1')->comment('状态 1 可用 2 禁用');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jy_payment');
    }
}
