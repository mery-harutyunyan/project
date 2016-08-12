<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('transaction_id');
            $table->string('state');
            $table->string('payment_method');
            $table->float('amount');
            $table->string('invoice_number');
            $table->string('payer_id');
            $table->string('payer_email');
            $table->string('payer_first_name');
            $table->string('payer_last_name');
            $table->string('payer_shipping_address');
            $table->string('payer_billing_address');
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
        Schema::drop('transactions');
    }
}
