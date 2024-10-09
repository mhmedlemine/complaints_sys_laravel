<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinesTable extends Migration
{
    public function up()
    {
        Schema::create('fines', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->decimal('amount', 10, 2);
            $table->dateTime('filledon');
            $table->foreignId('filledby')->constrained('users');
            $table->string('status');
            $table->date('duedate');
            $table->date('paidon')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fines');
    }
}