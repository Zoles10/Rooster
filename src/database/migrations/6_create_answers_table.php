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
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->string('question_id', 5);
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->text('user_text');
            $table->timestamps();
            $table->boolean('archived')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('answers');
    }
};
