<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveysTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('intro')->nullable();
            $table->dateTime('init_at')->nullable();
            $table->dateTime('end_at')->nullable();
            $table->boolean('active')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('survey_id')->unsigned();
            $table->foreign('survey_id')->references('id')->on('surveys');
            $table->string('name')->nullable();
            $table->text('statement')->nullable();
            $table->string('answers_header')->nullable();
            $table->string('options_header')->nullable();
            $table->text('attachment')->nullable();
            $table->integer('type');
            $table->integer('format')->nullable();
            $table->integer('order')->nullable();
            $table->boolean('other')->nullable();
            $table->boolean('none')->nullable();
            $table->boolean('unknow')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('question_question', function (Blueprint $table) {
            $table->integer('father_id')->unsigned();
            $table->foreign('father_id')->references('id')->on('questions');

            $table->integer('question_id')->unsigned();
            $table->foreign('question_id')->references('id')->on('questions');

            $table->unique(['father_id','question_id']);

            $table->timestamps();
        });

        Schema::create('options', function (Blueprint $table) {
            $table->increments('id');
            $table->text('statement')->nullable();
            $table->string('value')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('option_question', function (Blueprint $table) {
            $table->integer('option_id')->unsigned();
            $table->foreign('option_id')->references('id')->on('options');

            $table->integer('question_id')->unsigned();
            $table->foreign('question_id')->references('id')->on('questions');

            $table->unique(['option_id','question_id']);

            $table->timestamps();
        });

        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });

        Schema::create('group_options', function (Blueprint $table) {
            $table->integer('option_id')->unsigned();
            $table->foreign('option_id')->references('id')->on('options');

            $table->integer('group_id')->unsigned();
            $table->foreign('group_id')->references('id')->on('groups');
            $table->timestamps();
        });

        Schema::create('jumps', function (Blueprint $table) {
            $table->increments('id');

            $table->enum('show', [true, false]);

            $table->integer('question_id')->unsigned();
            $table->foreign('question_id')->references('id')->on('questions');

            $table->integer('option_id')->unsigned();
            $table->foreign('option_id')->references('id')->on('options');

            $table->integer('to_question_id')->unsigned()->nullable();
            $table->foreign('to_question_id')->references('id')->on('questions');

            $table->timestamps();
        });

        Schema::create('conditions', function (Blueprint $table) {
            $table->increments('id');

            $table->enum('show', [true, false]);

            $table->integer('question_id')->unsigned();
            $table->foreign('question_id')->references('id')->on('questions');

            $table->integer('option_id')->unsigned();
            $table->foreign('option_id')->references('id')->on('options');

            $table->integer('to_question_id')->unsigned()->nullable();
            $table->foreign('to_question_id')->references('id')->on('questions');

            $table->integer('to_option_id')->unsigned()->nullable();
            $table->foreign('to_option_id')->references('id')->on('options');

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
        Schema::dropIfExists('conditions');
        Schema::dropIfExists('jumps');
        Schema::dropIfExists('group_options');
        Schema::dropIfExists('groups');
        Schema::dropIfExists('option_question');
        Schema::dropIfExists('options');
        Schema::dropIfExists('question_question');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('surveys');
    }
}
