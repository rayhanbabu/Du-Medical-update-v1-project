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
        Schema::create('testprovides', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('appointment_id');
            $table->foreign('appointment_id')->references('id')->on('appointments');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('member_id');
            $table->foreign('member_id')->references('id')->on('members');

            $table->unsignedBigInteger('test_id');
            $table->foreign('test_id')->references('id')->on('tests');

          

            $table->integer('test_status')->default('0');
            $table->date('date');
            $table->integer('month');
            $table->integer('year');
            $table->integer('day');
            $table->string('comment')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testprovides');
    }
};
