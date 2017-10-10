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
            $table->foreign('sample_id')->references('id')->on('samples');

            $table->integer('survey_id')->unsigned();
            $table->foreign('survey_id')->references('id')->on('surveys');

            $table->boolean('active')->default(true);

            $table->timestamps();
        });

        Schema::create('subjects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('company')->nullable();
            $table->string('address')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('ocupation')->nullable();
            $table->string('telephone')->nullable();

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sample_subject', function (Blueprint $table) {
            $table->integer('sample_id')->unsigned();
            $table->foreign('sample_id')->references('id')->on('samples');

            $table->integer('subject_id')->unsigned();
            $table->foreign('subject_id')->references('id')->on('subjects');

            $table->dateTime('finished_at')->nullable();

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->unique(['sample_id','subject_id']);
        });

        Schema::create('answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sample_id')->unsigned();
            $table->foreign('sample_id')->references('id')->on('samples');
            $table->integer('subject_id')->unsigned();
            $table->foreign('subject_id')->references('id')->on('subjects');
            $table->integer('question_id')->unsigned();
            $table->foreign('question_id')->references('id')->on('questions');
            $table->text('value')->nullable();

            $table->boolean('refused')->default(false);
            $table->boolean('dontknow')->default(false);

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('answer_option', function (Blueprint $table) {
            $table->integer('answer_id')->unsigned();
            $table->foreign('answer_id')->references('id')->on('answers');

            $table->integer('option_id')->unsigned();
            $table->foreign('option_id')->references('id')->on('options');

            $table->integer('sub_option_id')->unsigned()->nullable();
            $table->foreign('sub_option_id')->references('id')->on('options');

            $table->text('value')->nullable();

            $table->unique(['answer_id','option_id','sub_option_id']);

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
        Schema::dropIfExists('answer_option');
        Schema::dropIfExists('answers');
        Schema::dropIfExists('sample_subject');
        Schema::dropIfExists('subjects');
        Schema::dropIfExists('samples');
    }
}
