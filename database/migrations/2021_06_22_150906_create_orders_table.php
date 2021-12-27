<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('rooms_amount');
            $table->decimal('total_price', $precision = 8, $scale = 2);
            $table->text('additional_services')->nullable();
            $table->biginteger('client_id');
            $table->biginteger('cleaner_id');
            $table->text('address');
            $table->timestamp('order_date_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
