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
        Schema::create('ambulances', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('driver_id');
            $table->foreign('driver_id')->references('id')->on('users');

            $table->unsignedBigInteger('member_id');
            $table->foreign('member_id')->references('id')->on('members');

           
            $table->string('to_address');
            $table->string('disease');
            $table->integer('distance');
            $table->integer('status');
            $table->date('date');
            $table->integer('month');
            $table->integer('year');
            $table->integer('day');
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
        Schema::dropIfExists('ambulances');
    }
};
