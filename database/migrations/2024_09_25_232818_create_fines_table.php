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
            $table->foreignId('summon_id')->constrained();
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'paid', 'appealed']);
            $table->date('duedate');
            $table->timestamp('issued_on');
            $table->foreignId('issued_by')->constrained('users');
            $table->timestamp('paid_on')->nullable();
            $table->text('notes')->nullable();
            $table->string('receipt_number')->nullable();
            $table->timestamp('receipt_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fines');
    }
}