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
        Schema::create('cash_loan_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cash_loan_id');
            $table->string('position');
            $table->string('name');
            $table->string('phone');
            $table->string('nik');
            $table->text('address');
            $table->string('gurantor_name');
            $table->string('gurantor_phone');
            $table->string('gurantor_nik');
            $table->text('gurantor_address');
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
        Schema::dropIfExists('cash_loan_members');
    }
};