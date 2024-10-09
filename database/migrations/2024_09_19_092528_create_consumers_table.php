<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsumersTable extends Migration
{
    public function up()
    {
        Schema::create('consumers', function (Blueprint $table) {
            $table->id();
            $table->string('nni')->unique();
            $table->string('fname');
            $table->string('lname');
            $table->string('phonenumber');
            $table->text('address');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('consumers');
    }
}