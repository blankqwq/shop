<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->comment('用户id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('province')->comment('省');
            $table->string('city')->comment('市区');
            $table->string('district')->comment('区');
            $table->string('address')->comment('详细地址');
            $table->string('contact_name')->comment('收货人');
            $table->string('contact_phone',11)->comment('电话');
            $table->string('zip')->comment('邮编');
            $table->timestamp('last_use')->comment('最后一次使用时间');
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
        Schema::dropIfExists('user_addresses');
    }
}
