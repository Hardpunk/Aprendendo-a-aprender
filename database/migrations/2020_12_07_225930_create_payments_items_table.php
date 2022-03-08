<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_id');
            $table->unsignedBigInteger('trail_id')->nullable();
            $table->unsignedBigInteger('course_id')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('payment_id')
                ->references('id')
                ->on('payments');

            $table->foreign('trail_id')
                ->references('id')
                ->on('trails');

            $table->foreign('course_id')
                ->references('id')
                ->on('courses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments_items');
    }
}
