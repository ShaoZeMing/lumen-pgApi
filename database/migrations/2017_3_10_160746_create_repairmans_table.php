<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepairmansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repairmans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255)->comment('姓名');
            $table->string('mobile', 12)->comment('电话')->default(13333333333);
//            $table->string('mobile', 12)->comment('电话')->unique();
            $table->tinyInteger('status')->default(0)->comment('状态：0正常，1锁定');
            $table->text('address')->comment('地址');
            $table->bigInteger('uid')->comment('对应mysql师傅表id')->default(0);
//            $table->bigInteger('uid')->comment('对应mysql师傅表id')->unique();
//            $table->addColumn('geometry','geom',['LINESTRING',4326])->comment('地理geom');
//           //地理位置geom,无法直接创建，创建表后，执行sql:ALTER TABLE repairmans ADD COLUMN geom geometry(POINT,4326);
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
    }
}
