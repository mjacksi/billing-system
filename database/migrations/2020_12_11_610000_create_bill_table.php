<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillTable extends Migration
{

    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->date('date')->nullable();
            $table->date('expire_date')->nullable();
            $table->string('uuid')->nullable();
            $table->string('note')->nullable();
            $table->double('total_cost')->nullable();

            $table->tinyInteger('ordered')->default(1);
            $table->boolean('draft')->default(0);


            $table->softDeletes();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bills');
    }
}
