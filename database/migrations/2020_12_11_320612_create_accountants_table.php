<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountantsTable extends Migration
{
    public function up()
    {
        Schema::create('accountants', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');

            $table->enum('local', ['en','ar'])->default('ar');

            $table->tinyInteger('ordered')->default(1);
            $table->boolean('draft')->default(0);




            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('accountants');
    }
}
