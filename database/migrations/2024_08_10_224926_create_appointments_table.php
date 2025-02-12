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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chamber_id');
            $table->foreign('chamber_id')->references('id')->on('chambers');

            $table->string('week_name');
            $table->foreign('week_name')->references('week_name')->on('weeks');

            $table->string('service_name');
            $table->foreign('service_name')->references('service_name')->on('services');
          
            $table->unsignedBigInteger('slot_id');
            $table->foreign('slot_id')->references('id')->on('slots');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('member_id');
            $table->foreign('member_id')->references('id')->on('members');


            $table->unsignedBigInteger('careof_id');
            $table->foreign('careof_id')->references('id')->on('families');
           
            $table->enum('confirm_status', ['0','1'])->default('0');
            $table->enum('appointment_status', ['0','1'])->default('0');
            $table->enum('chamber_type', ['Male','Female','Both']); 
            $table->enum('duty_type', ['Morning','Evening','Night']); 

            $table->string('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('room')->nullable();
            $table->string('slot_time');

            $table->string('disease_problem')->nullable();
            $table->string('file_name')->nullable();
            $table->string('advice')->nullable();

            $table->string('nursing_service')->nullable();
            $table->string('nursing_comment')->nullable();
            $table->integer('nursing_status')->nullable();

            $table->string('indoor_service')->nullable();
            $table->string('indoor_comment')->nullable();
            $table->integer('indoor_status')->nullable();
           
            $table->enum('appointment_category',['Offline','Online'])->nullable();
           
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');

            $table->date('date')->nullable();
            $table->integer('year')->nullable();
            $table->integer('month')->nullable();
            $table->integer('day')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appoinments');
    }
};
