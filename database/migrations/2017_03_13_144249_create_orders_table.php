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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id')->comment('订单号')->unique();
            $table->text('description')->nullable()->comment('订单描述');
            $table->unsignedTinyInteger('state')->default(0)->comment('订单状态:0 未接单，1 已接单，2 已完成，3已取消');
            $table->string('merchant_name',64)->default('')->comment('商家名称');
            $table->string('merchant_telphone', 12)->comment('商家电话')->default('');
            $table->bigInteger('category_id')->default(0)->comment('分类id')->index();
            $table->string('category_name',200)->default('')->comment('分类名称');
            $table->string('user_name',255)->default('')->comment('用户姓名');
            $table->string('user_mobile', 12)->comment('用户电话')->default('');
            $table->string('full_address')->default('')->comment('用户地址');
            $table->geometry('geom',4326)->comment('位置geom');
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