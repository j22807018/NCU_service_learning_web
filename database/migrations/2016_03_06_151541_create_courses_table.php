<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_for_student');
            $table->boolean('is_for_teacher');
            $table->boolean('is_for_staff');
            $table->boolean('is_announced');
            $table->string('title');
            $table->text('message');
            $table->integer('download_times');
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
        Schema::drop('courses');
    }
}
