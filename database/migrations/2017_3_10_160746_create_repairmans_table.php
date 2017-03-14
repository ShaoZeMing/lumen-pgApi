<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Phaza\LaravelPostgis\Schema\Blueprint;

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
            $table->tinyInteger('status')->default(0)->comment('状态：0正常，1锁定');
            $table->text('address')->comment('地址');
            $table->bigInteger('uid')->comment('对应mysql师傅表id')->default(0);
            $table->geometry('geom',4326)->comment('geom位置数据');
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

        Schema::drop('repairmans');
    }
}
