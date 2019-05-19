<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id')->comment('订单id');
            $table->foreign('order_id')->on('orders')->references('id')->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedInteger('goods_id');
            $table->foreign('goods_id')->on('goods')->references('id')->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedInteger('goods_sku_id');
            $table->foreign('goods_sku_id')->on('goods_skuses')->references('id')->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedInteger('amount')->comment('库存');

            $table->decimal('price',10,2);

            $table->unsignedInteger('rating')->nullable();

            $table->text('review')->nullable()->comment('评价');

            $table->timestamp('review_at')->nullable()->comment('评价时间');
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
        Schema::dropIfExists('order_items');
    }
}
