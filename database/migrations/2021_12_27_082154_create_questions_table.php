<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('question');
            $table->mediumText('answers');
            $table->boolean('have_other_option')->default(0);
            $table->string('other_option_name')->nullable();
            $table->unsignedInteger('order')->default(0);
            $table->boolean('is_required')->default(0);
            $table->json('options')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
