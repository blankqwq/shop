<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePicturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pictures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable()->comment('图片名称');
            $table->string('url')->comment('图片地址');
            $table->integer('goods_id')->comment('商品id');
            $table->string('size')->nullable()->comment('商品规格');
            $table->boolean('is_main')->nullable()->comment('是否为主图');
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
        Schema::dropIfExists('pictures');
    }
}
