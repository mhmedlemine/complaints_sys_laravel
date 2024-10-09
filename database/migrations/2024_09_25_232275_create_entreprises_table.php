<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntreprisesTable extends Migration
{
    public function up()
    {
        Schema::create('entreprises', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('name_ar');
            $table->foreignId('neighbourhood_id')->constrained();
            $table->foreignId('owner_id')->constrained('merchants');
            $table->string('status');
            $table->string('type');
            $table->date('registeredon');
            $table->foreignId('agent_id')->constrained('users');
            $table->decimal('lat', 10, 8);
            $table->decimal('lon', 11, 8);
            $table->string('rg');
            $table->text('notes')->nullable();
            $table->text('address');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('entreprises');
    }
}