<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashingFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashing_files', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('path');
            $table->date('delivery_date');
            $table->string('modifier');
            $table->integer('size')->nullable();
            $table->integer('lines_number')->nullable();
            $table->unsignedBigInteger('bank_id');
            $table->boolean('received')->default(false);
            $table->boolean('status')->default(true);
            $table->timestamps();

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
        Schema::dropIfExists('cashing_files');
    }
}
