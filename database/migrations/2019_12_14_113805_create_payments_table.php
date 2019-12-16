<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->integer('Number');
            $table->string('FName');
            $table->string('MName');
            $table->string('LName');
            $table->string('TransactionType');
            $table->string('TransID');
            $table->string('TransTime');
            $table->double('TransAmount', 7, 2);
            $table->string('ShortCode');
            $table->string('BillRefNumber');
            $table->string('InvoiceNumber');
            $table->string('ThirdPartyTransID');
            $table->string('MSISDN');
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
        Schema::dropIfExists('payments');
    }
}
