<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLotHeaderRules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_lot_header_rules', function (Blueprint $table) {
            $table->id();
            $table->string('register_type_value');
            $table->integer('register_type_lenght');
            $table->string('invoiced_service_code_value');
            $table->integer('invoiced_service_code_lenght');
            $table->string('lot_number_value');
            $table->integer('lot_number_lenght');
            $table->string('invoiced_service_description_value');
            $table->integer('invoiced_service_description_length');
            $table->integer('reserved_white_spaces');
            $table->unsignedBigInteger('bank_id');

            /** Foreign keys */
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_lot_header_rules');
    }
}
