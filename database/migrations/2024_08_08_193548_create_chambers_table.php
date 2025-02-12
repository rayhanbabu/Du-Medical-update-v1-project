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
        Schema::create('chambers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('service_name');
            $table->foreign('service_name')->references('service_name')->on('services');


            $table->integer('chamber_name');
            $table->integer('chamber_status');

           
            $table->enum('duty_type', ['Morning','Evening','Night']);
            $table->enum('chamber_type', ['Male','Female','Both']);  
           
            $table->string('room');
            $table->integer('serial')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chambers');
    }
};
