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
            $table->string('order_num')->default('200030232323')->comment('订单号')->unique();
            $table->text('description')->nullable()->comment('订单描述');
            $table->unsignedTinyInteger('order_status')->default(0)->comment('订单状态:0 未接单，1 已接单，2 已完成，3已取消');
            $table->unsignedBigInteger('firm_id')->default(0)->comment('商家id')->index();
            $table->string('firm_name',255)->default('')->comment('商家名称');
            $table->string('firm_mobile', 12)->comment('商家电话')->default(13333333333);
            $table->Integer('class_id')->default(0)->comment('分类id')->index();
            $table->string('class_name',255)->default('')->comment('分类名称');
            $table->unsignedBigInteger('user_id')->default(0)->comment('用户关联id')->index();
            $table->string('user_name',255)->default('')->comment('用户姓名');
            $table->string('user_mobile', 12)->comment('用户电话')->default(13333333333);
            $table->string('address')->default('')->comment('用户地址');
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