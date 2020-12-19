<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillFilesTable extends Migration
{

    public function up()
    {
        Schema::create('bill_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bill_id')->nullable();
            $table->string('file');

            $table->tinyInteger('ordered')->default(1);
            $table->boolean('draft')->default(0);

            $table->softDeletes();
            $table->timestamps();
            $table->foreign('bill_id')->references('id')->on('bills')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bill_files');
    }
}
