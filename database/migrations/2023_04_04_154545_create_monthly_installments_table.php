<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthly_installments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cash_loan_id');
            $table->unsignedDecimal('principal_payment', 10, 0);
            $table->unsignedDecimal('contribution_payment', 10, 0);
            $table->date('installment_date');
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
        Schema::dropIfExists('monthly_installments');
    }
};