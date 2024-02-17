<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responses', function (Blueprint $table) {
            $table->id();
            //surve id foreign
            $table->foreignId('survey_id')->constrained('surveys');
            $table->foreignId('question_id')->constrained('questions');
            $table->foreignId('option_id')->constrained('options');
            $table->text('response_text')->nullable();
            $table->string('voucher')->nullable()->unique();
            $table->foreignId('user_id')->nullable()->constrained('users');
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
        Schema::dropIfExists('responses');
    }
}
