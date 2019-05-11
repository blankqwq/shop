<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsAttributeValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_attribute_values', function (Blueprint $table) {
            $table->increments('id')->comment('商品属性值：主键id');
            $table->string('name')->comment('商品属性值：名称');
            $table->integer('attribute_id')->comment('商品属性值：名称');
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
        Schema::dropIfExists('goods_attribute_values');
    }
}
