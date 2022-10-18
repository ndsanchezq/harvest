<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_header_rules', function (Blueprint $table) {
            $table->id();
            $table->string('register_type_value');
            $table->integer('register_type_lenght');
            $table->string('did_main_collector_company_value');
            $table->integer('did_main_collector_company_lenght');
            $table->string('did_additional_collector_company_value');
            $table->integer('did_additional_collector_company_lenght');
            $table->string('financial_entity_code_value');
            $table->integer('financial_entity_code_length');
            $table->integer('reserved_white_spaces');
            $table->enum('file_type', ['novelty', 'cashing']);
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
        Schema::dropIfExists('file_header_rules');
    }
}
