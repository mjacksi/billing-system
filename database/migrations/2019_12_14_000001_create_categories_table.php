<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{

    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->timestamps();

            $table->tinyInteger('ordered')->default(1);
            $table->boolean('draft')->default(0);


        });
    }


    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
