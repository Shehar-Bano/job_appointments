<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointment_forms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('position_id');
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade');
            $table->unsignedBigInteger('slot_id');
            $table->foreign('slot_id')->references('id')->on('slots')->onDelete('cascade');
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('email');
            $table->string('contact');
            $table->longText('cover_letter');
            $table->string('resume');
            $table->date('date');
            $table->enum('mode', ['in-person', 'virtual']);
            $table->enum('status', ['scheduled', 'done', 'canceled'])->default('scheduled');
            $table->softDeletes();
            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment_forms');
    }
};
