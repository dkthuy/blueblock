<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->dateTime('apply_date');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('furigana_first_name');
            $table->string('furigana_last_name');
            $table->string('gender')->nullable();
            $table->string('age')->nullable();
            $table->string('post_code');
            $table->string('prefecture');
            $table->string('city');
            $table->string('additional_address');
            $table->string('room_building_number')->nullable();
            $table->string('telephone');
            $table->string('apply_id');

            $table->foreignId('user_id');
            $table->foreignId('gift_id');
            $table->string('gift_name')->nullable();
            $table->mediumText('qanda');
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
        Schema::dropIfExists('applications');
    }
}
