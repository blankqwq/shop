<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsSkusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_skuses', function (Blueprint $table) {
            $table->increments('id')->comment('sku主键id');
            $table->integer('goods_id')->unsigned()->comment('商品id');

            $table->string('attrs')->nullable()->comment('合集 直接从中获取对应的属性值和id');
//            $table->integer('attribute_id')->nullable()->unsigned()->comment('属性id');
//            $table->integer('attribute_value_id')->nullable()->unsigned()->comment('属性值id');

            $table->integer('picture_id')->unsigned()->comment('图片id');
            $table->decimal('price', 8, 2)->default(0)->comment('价格');
            $table->integer('stock')->unsigned()->default(0)->comment('库存');
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
        Schema::dropIfExists('goods_skuses');
    }
}
