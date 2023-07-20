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
        Schema::create('cash_loans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('market_id');
            $table->string('code_dpm');
            $table->string('name');
            $table->text('address');
            $table->date('due_date');
            $table->date('disbursement_date');
            $table->unsignedDecimal('total_loan', 10, 0);
            $table->integer('loan_period');
            $table->integer('contribution_percentage');
            $table->unsignedDecimal('contribution', 10, 0);
            $table->unsignedDecimal('contribution_tolerance', 10, 0);
            $table->tinyInteger('status');
            $table->timestamps();

            $table->foreign('market_id')->references('id')->on('community_groups')->onUpdate('cascade')->onDelete('restrict');
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