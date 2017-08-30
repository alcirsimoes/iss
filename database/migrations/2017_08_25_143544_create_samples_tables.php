<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSamplesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('samples', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sample_survey', function (Blueprint $table) {
            $table->integer('sample_id')->unsigned();
            $table->foreign('sample_id')->references('id')->on('answers');

            $table->integer('survey_id')->unsigned();
            $table->foreign('survey_id')->references('id')->on('surveys');

            $table->boolean('active')->default(false);

            $table->unique(['sample_id','survey_id']);

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('subjects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sample_subject', function (Blueprint $table) {
            $table->integer('sample_id')->unsigned();
            $table->foreign('sample_id')->references('id')->on('answers');

            $table->integer('subject_id')->unsigned();
            $table->foreign('subject_id')->references('id')->on('subjects');

            $table->unique(['sample_id','subject_id']);

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subject_id')->unsigned();
            $table->foreign('subject_id')->references('id')->on('subjects');
            $table->integer('question_id')->unsigned();
            $table->foreign('question_id')->references('id')->on('questions');
            $table->text('value')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('answer_option', function (Blueprint $table) {
            $table->integer('answer_id')->unsigned();
            $table->foreign('answer_id')->references('id')->on('answers');

            $table->integer('option_id')->unsigned();
            $table->foreign('option_id')->references('id')->on('options');

            $table->text('value')->nullable();

            $table->unique(['answer_id','option_id']);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answer_option');
        Schema::dropIfExists('answers');
        Schema::dropIfExists('sample_subject');
        Schema::dropIfExists('subjects');
        Schema::dropIfExists('samples');
    }
}
