<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{

    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('accountant_id')->nullable();
            $table->unsignedBigInteger('manager_id')->nullable();


            $table->integer('type'); //فاتورة ام سداد دين

            $table->unsignedBigInteger('creditor_debtor_id')->nullable();
            $table->unsignedBigInteger('bill_id')->nullable();
            $table->double('amount')->default(0);//كم دفع
            $table->string('note')->nullable();

            $table->tinyInteger('ordered')->default(1);
            $table->boolean('draft')->default(0);


            $table->softDeletes();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('creditor_debtor_id')->references('id')->on('creditor_debtor')->onDelete('cascade');
            $table->foreign('bill_id')->references('id')->on('bills')->onDelete('cascade');
            $table->foreign('manager_id')->references('id')->on('managers')->onDelete('cascade');


        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
