<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Phaza\LaravelPostgis\Schema\Blueprint;
class CreateOrdersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function(Blueprint $table)
        {
            $table->bigIncrements('id')->comment('主键id');
            $table->string('order_no')->comment('订单号')->index();
            $table->string('order_desc')->comment('订单描述');
            $table->tinyInteger('state')->default(0)->comment('订单状态');
            $table->tinyInteger('order_type')->default(0)->comment('0 保内 1 保外');
            $table->tinyInteger('biz_type')->default(0)->comment('0 安装 1 维修');
            $table->bigInteger('merchant_id')->comment('商家id');
            $table->string('merchant_name',64)->comment('商家名称');
            $table->string('merchant_tel', 12)->comment('商家电话');
            $table->bigInteger('user_id')->comment('用户id');
            $table->string('user_name',255)->comment('用户姓名');
            $table->string('user_mobile', 12)->comment('用户电话');
            $table->decimal('user_lat')->comment('纬度');
            $table->decimal('user_lng')->comment('经度');
            $table->string('full_address')->comment('地址');
            $table->geometry('geom',4326)->comment('位置geom');
            $table->timestamp('published_at')->comment('发布工单时间');
            $table->string('big_cat')->default('')->comment('大类');
            $table->string('middle_cat')->default('')->comment('中类');
            $table->string('small_cat')->default('')->comment('小类');
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
        Schema::drop('orders');
    }

}