<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_loans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('community_group_id');
            $table->string('acceptance_code'); 
            $table->date('disbursement_date');
            $table->unsignedDecimal('total_loan', 10, 0);
            $table->integer('loan_period');
            $table->integer('contribution_percentage');
            $table->unsignedDecimal('contribution', 10, 0);
            $table->unsignedDecimal('monthly_payment', 10, 0);
            $table->unsignedDecimal('remaining_fund', 10, 0);
            $table->enum('loan_status', ['ongoing', 'done']);
            $table->timestamps();

            $table->foreign('community_group_id')->references('id')->on('community_groups')->onUpdate('cascade')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_loans');
    }
};
