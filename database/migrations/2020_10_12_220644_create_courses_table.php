<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('category_id');
            $table->string('title');
            $table->longText('description');
            $table->string('slug');
            $table->string('category_slug');
            $table->string('category_title');
            $table->decimal('rating');
            $table->integer('students');
            $table->string('captions');
            $table->integer('hours');
            $table->text('topics');
            $table->string('video')->nullable();
            $table->string('image')->nullable();
            $table->string('background')->nullable();
            $table->text('slideshow')->nullable();
            $table->string('teacher_name')->nullable();
            $table->longText('teacher_description')->nullable();
            $table->string('teacher_image')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('category_id')
                ->references('category_id')
                ->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
