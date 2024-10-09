<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoughataasTable extends Migration
{
    public function up()
    {
        Schema::create('moughataas', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('name_ar');
            $table->decimal('lat', 10, 8);
            $table->decimal('lon', 11, 8);
            $table->foreignId('wilaya_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('moughataas');
    }
}