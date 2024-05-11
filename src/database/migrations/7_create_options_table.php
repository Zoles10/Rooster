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
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->string('question_id', 5);
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->string('option_text', 511);
            $table->boolean('correct')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('options');
    }
};
