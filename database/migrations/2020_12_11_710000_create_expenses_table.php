<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{

    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();

            $table->string('title')->nullable();
            $table->string('details')->nullable();
            $table->double('cost')->nullable();

            $table->tinyInteger('ordered')->default(1);
            $table->boolean('draft')->default(0);


            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('expenses');
    }
}
