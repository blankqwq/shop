<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->increments('id')->comment('商品主键id');
            $table->integer('category_id')->nullable()->comment('商品类别id');
            $table->string('name')->comment('商品名');
            $table->text('desc')->comment('商品描述');
            $table->tinyInteger('state')->default(0)->comment('产品状态 0 下架  1 上架');
            $table->dateTime('state_date')->nullable()->comment('商品上架时间');
            $table->integer('pv')->default(0)->comment('商品点击量');
            $table->integer('sale')->default(0)->comment('销售量');
            $table->integer('sort')->default(0)->comment('排序');
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
        Schema::dropIfExists('goods');
    }
}
