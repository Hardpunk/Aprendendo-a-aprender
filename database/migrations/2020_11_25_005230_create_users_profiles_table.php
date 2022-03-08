<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('external_id')->nullable();
            $table->enum('document_type', ['individual', 'corporation', 'other'])->default('other');
            $table->string('document_number', 20)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('street')->nullable();
            $table->string('street_number', 10)->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('city')->nullable();
            $table->string('state', 2)->nullable();
            $table->string('zipcode', 9)->nullable();
            $table->string('complement')->nullable();
            $table->string('country', 5)->default('br');
            $table->string('platform_password');
            $table->enum('gender', ['male', 'female', 'other'])->default('male');
            $table->date('birthday')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_profiles');
    }
}
