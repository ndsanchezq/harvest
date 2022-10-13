<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoveltiesFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('novelties_files', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('path');
            $table->date('delivery_date');
            $table->string('modifier');
            $table->integer('size')->nullable();
            $table->integer('lines_number')->nullable();
            $table->unsignedBigInteger('cashing_file_id')->nullable();
            $table->unsignedBigInteger('bank_id');
            $table->boolean('status')->default(true);
            $table->timestamps();

            /** Foreign keys */
            $table->foreign('cashing_file_id')->references('id')->on('cashing_files')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('novelties_files');
    }
}
