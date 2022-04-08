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
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('type_id')->constrained('delivery_management')->onDelete('cascade');
            $table->double('total', 20, 2);
            $table->string('total_bs', 200);
            $table->enum('status', ['refused', 'canceled', 'pending_for_payment', 'added_payment', 'approved_payment', 'order_on_hold', 'order_on_the_way', 'order_pending_by_customer', 'order_delivered']);
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
        Schema::dropIfExists('orders');
    }
}
