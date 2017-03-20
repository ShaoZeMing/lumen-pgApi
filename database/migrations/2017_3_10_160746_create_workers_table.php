<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Phaza\LaravelPostgis\Schema\Blueprint;

class CreateWorkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100)->comment('姓名');
            $table->string('mobile', 12)->comment('电话');
            $table->tinyInteger('state')->default(0)->comment('状态：0正常，1锁定');
            $table->decimal('worker_lat')->comment('纬度');
            $table->decimal('worker_lng')->comment('经度');
            $table->text('full_address')->comment('地址');
            $table->unsignedBigInteger('uid')->comment('关联lsd_workers表id')->default(0)->index();
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

        Schema::drop('workers');
    }
}
