<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipientsTable extends Migration
{

    public function up()
    {
        Schema::create('recipients', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('accountant_id')->nullable();
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->double('amount')->default(0);// المبلغ المعطى
            $table->string('note')->nullable();// الحالة مدفوعة ام لا
            $table->dateTime('date')->nullable();// الحالة مدفوعة ام لا

            $table->tinyInteger('ordered')->default(1);
            $table->boolean('draft')->default(0);


            $table->softDeletes();
            $table->timestamps();
            $table->foreign('accountant_id')->references('id')->on('accountants')->onDelete('cascade');
            $table->foreign('manager_id')->references('id')->on('managers')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('recipients');
    }
}
