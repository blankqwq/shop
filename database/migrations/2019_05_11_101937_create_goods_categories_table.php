<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('类别名称');
            $table->integer('parent_id')->default(0)->comment('父级类别id');
            $table->string('image')->nullable()->comment('分类图片');
            $table->integer('level')->default(0)->comment('分类等级');
            $table->integer('sort')->default(0)->comment('分类排序');
            $table->string('possess')->nullable()->comment('分类path');
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
        Schema::dropIfExists('goods_categories');
    }
}
