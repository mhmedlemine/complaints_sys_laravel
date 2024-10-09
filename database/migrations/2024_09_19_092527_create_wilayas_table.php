<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWilayasTable extends Migration
{
    public function up()
    {
        Schema::create('wilayas', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('name_ar');
            $table->decimal('lat', 10, 8);
            $table->decimal('lon', 11, 8);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wilayas');
    }
}