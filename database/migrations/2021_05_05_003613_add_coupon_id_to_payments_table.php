<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCouponIdToPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedBigInteger('coupon_id')
                ->index('payments_coupon_id_foreign')
                ->after('user_id')
                ->nullable();

            $table->foreign('coupon_id')
                ->references('id')
                ->on('coupons')
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
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign('payments_coupon_id_foreign');
            $table->dropColumn('coupon_id');
        });
    }
}
