<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditorDebtorTable extends Migration
{

    public function up()
    {
        Schema::create('creditor_debtor', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->boolean('isManager');//هل  الدفعة لصاحب الموقع ام لا

            $table->double('amount')->default(0);// المبلغ المعطى
            $table->boolean('status')->default(0);// الحالة مدفوعة ام لا
            $table->string('note')->nullable();// الحالة مدفوعة ام لا


            $table->tinyInteger('ordered')->default(1);
            $table->boolean('draft')->default(0);


            $table->softDeletes();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('manager_id')->references('id')->on('managers')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('creditor_debtor');
    }
}
