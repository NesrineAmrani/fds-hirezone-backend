<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skill_id')
                ->constrained('skills')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->string('name');
            $table->string('description');
            $table->integer('number_questions');
            $table->enum('difficulty', ['easy', 'hard', 'medium'])->default('medium');
            $table->integer('base_score');
            $table->date('date');
            $table->integer('hours');
            $table->integer('minutes');
            $table->unsignedTinyInteger('duration');
            $table->boolean('hasStarted')->default(0);
            $table->bigInteger('created_by')->unsigned();
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
        Schema::dropIfExists('exams');
    }
}
