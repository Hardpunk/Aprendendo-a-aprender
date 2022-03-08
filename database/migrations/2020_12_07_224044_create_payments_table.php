<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('order_id');
            $table->unsignedBigInteger('external_id')->nullable();
            $table->enum('payment_method', ['credit_card', 'boleto']);
            $table->decimal('amount');
            $table->integer('installments');
            $table->string('card_brand')->nullable();
            $table->string('boleto_url')->nullable();
            $table->string('boleto_barcode')->nullable();
            $table->date('boleto_expiration_date')->nullable();
            $table->string('status')->nullable();
            $table->string('refuse_reason')->nullable();
            $table->string('status_reason')->nullable();
            $table->dateTime('date_created')->nullable();
            $table->dateTime('date_updated')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
