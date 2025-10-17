<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        // Now create the questions table with foreign keyss
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('question', 1023);
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->string('quiz_id', 5)->nullable();
            $table->foreign('quiz_id')->references('id')->on('quizes')->onDelete('cascade');
            $table->foreignId('subject_id')->nullable()->constrained('subjects')->onDelete('cascade');
            $table->boolean('active')->default(true);
            $table->date('last_closed')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('questions');
    }
};
