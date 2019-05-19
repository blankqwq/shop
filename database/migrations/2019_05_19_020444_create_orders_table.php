<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no')->unique()->comment('订单号');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade')
            ->onUpdate('cascade');

            $table->text('address')->comment('用户收获地址');
            $table->decimal('total_amount',10,2)->comment('需求量');

            $table->text('remark')->nullable()->comment('订单备注');
            $table->dateTime('paid_at')->nullable()->comment('支付时间');
            $table->string('payment_method')->nullable()->comment('支付方式');
            $table->string('payment_no')->nullable()->comment('支付流水');

            $table->string('refund_no')->nullable()->comment('退款单号');
            $table->string('refund_status')->default(\App\Models\Order::REFUND_STATUS_PENDING)->comment('支付状态默认未处理');


            $table->boolean('closed')->default(false)->comment('订单是否关闭');
            $table->boolean('reviewed')->default(false)->comment('订单是否评价');
            $table->string('ship_status')->default(\App\Models\Order::SHIP_STATUS_PENDING)->comment('发货状态默认未处理');
            $table->text('ship_data')->nullable()->comment('发货数据');
            $table->text('extra')->nullable()->comment('其他数据');

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
        Schema::dropIfExists('orders');
    }
}
