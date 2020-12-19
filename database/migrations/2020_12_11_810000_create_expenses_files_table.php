<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesFilesTable extends Migration
{

    public function up()
    {
        Schema::create('expenses_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expense_id')->nullable();

            $table->string('file')->nullable();

            $table->tinyInteger('ordered')->default(1);
            $table->boolean('draft')->default(0);


            $table->softDeletes();
            $table->timestamps();
            $table->foreign('expense_id')->references('id')->on('expenses')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('expenses_files');
    }
}
