<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillItemsTable extends Migration
{

    public function up()
    {
        Schema::create('bill_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bill_id')->nullable();
            $table->unsignedBigInteger('item_id')->nullable();

            $table->double('cost_before')->default(0);
            $table->double('cost_after')->default(0);

            $table->tinyInteger('quantity')->default(1);
            $table->float('total_cost');


            $table->tinyInteger('ordered')->default(1);
            $table->boolean('draft')->default(0);

            $table->softDeletes();
            $table->timestamps();
            $table->foreign('bill_id')->references('id')->on('bills')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bill_items');
    }
}
