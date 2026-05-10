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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('item_id');
            $table->string('item_name')->nullable();
            $table->string('unit');
            $table->string('holding_cost');
            $table->double('ordering_cost');
            $table->integer('beginning_inventory')->nullable();
            $table->integer('beginning_inventory_fixed')->nullable();
            $table->integer('daily_usage')->nullable();
            $table->string('reorder_point');
            $table->date('ordering_date')->nullable();
            $table->date('arrival_date')->nullable();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('products');
    }
};
