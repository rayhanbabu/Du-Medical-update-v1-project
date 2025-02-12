<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('testreports', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('testprovide_id');
            $table->foreign('testprovide_id')->references('id')->on('testprovides');
           
            $table->unsignedBigInteger('appointment_id');
            $table->foreign('appointment_id')->references('id')->on('appointments');

            $table->unsignedBigInteger('test_id');
            $table->foreign('test_id')->references('id')->on('tests');

            $table->unsignedBigInteger('diagnostic_id');
            $table->foreign('diagnostic_id')->references('id')->on('diagnostics');

            $table->unsignedBigInteger('character_id');
            $table->foreign('character_id')->references('id')->on('characters');
 
            $table->integer('report_status')->default('0');
            $table->string('result');
            $table->string('reference_range')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testreports');
    }
};
