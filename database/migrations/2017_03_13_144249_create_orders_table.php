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
            $table->string('o_id')->default('200030232323')->comment('订单号');
            $table->tinyInteger('status')->default(0)->comment('订单状态:0 未接单，1 已接单，2 已完成，3已取消');
            $table->bigInteger('b_id')->default(0)->comment('商家id')->index();
            $table->string('b_name',255)->comment('商家名称');
            $table->Integer('c_id')->default(0)->comment('分类id')->index();
            $table->string('c_name',255)->comment('分类名称');
            $table->string('u_name',255)->comment('用户姓名');
            $table->string('mobile', 12)->comment('用户电话')->default(13333333333);
            $table->string('address')->comment('用户地址');
            $table->point('geom')->comment('位置geom');
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