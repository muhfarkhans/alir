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
        Schema::create('community_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('community_group_id');
            $table->unsignedBigInteger('citizen_id');
            $table->unsignedBigInteger('gurantor_citizen_id');
            $table->string('role');
            $table->timestamps();

            $table->foreign('community_group_id')->references('id')->on('community_groups')->onUpdate('cascade')->onDelete('no action');
            $table->foreign('citizen_id')->references('id')->on('citizens')->onUpdate('cascade')->onDelete('no action');
            $table->foreign('gurantor_citizen_id')->references('id')->on('citizens')->onUpdate('cascade')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('community_members');
    }
};