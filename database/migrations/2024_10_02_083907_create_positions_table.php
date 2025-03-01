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
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->enum('job_type', ['full_time', 'part_time']);
            $table->string('qualification');
            $table->string('experience');
            $table->string('skills')->nullable();
            $table->enum('status', ['open', 'close'])->default('open');
            $table->text('description');
            $table->date('post_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
