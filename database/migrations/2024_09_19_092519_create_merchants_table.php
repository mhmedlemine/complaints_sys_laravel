<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantsTable extends Migration
{
    public function up()
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->id();
            $table->string('nni')->nullable();
            $table->string('fname');
            $table->string('lname')->nullable();
            $table->string('phonenumber')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('merchants');
    }
}