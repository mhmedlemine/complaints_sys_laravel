<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckupInfractionsTable extends Migration
{
    public function up()
    {
        Schema::create('checkup_infractions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checkup_id')->constrained()->onDelete('cascade');
            $table->foreignId('infraction_id')->nullable()->constrained()->onDelete('cascade');
            $table->text('custom_infraction_text')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_reported')->default(false);
            $table->enum('status', ['pending', 'confirmed', 'rejected']);
            $table->json('evidence_files')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('checkup_infractions');
    }
}