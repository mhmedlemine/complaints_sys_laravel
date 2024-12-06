<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfractionsTable extends Migration
{
    public function up()
    {
        Schema::create('infractions', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('label');
            $table->string('label_ar')->nullable();
            $table->text('description');
            $table->text('description_ar')->nullable();
            $table->enum('severity', ['low', 'medium', 'high']);
            $table->decimal('fine_min_amount', 10, 2);
            $table->decimal('fine_max_amount', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('infractions');
    }
}