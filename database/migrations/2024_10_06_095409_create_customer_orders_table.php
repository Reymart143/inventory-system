<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_orders', function (Blueprint $table) {
            $table->id();
            $table->string('product_id');
            $table->string('stockout_by')->nullable();
            $table->string('stock_out_quantity');
            $table->string('ending_inventory');
            $table->string('type')->default(0);
            $table->string('proof_receipt')->nullable();
            $table->string('reference_no')->nullable();
            $table->string('status')->default('Pending');
            $table->date('date_stockout');
            $table->string('weeks');
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
        Schema::dropIfExists('customer_orders');
    }
};
