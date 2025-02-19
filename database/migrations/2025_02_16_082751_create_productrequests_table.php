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
        Schema::create('productrequests', function (Blueprint $table) {
            $table->id();

            $table->string('request_from');

            $table->unsignedBigInteger('request_by');
            $table->foreign('request_by')->references('id')->on('users');

            $table->integer('cmo_status')->default(0);
            $table->integer('provide_status')->default(0);

            $table->unsignedBigInteger('provide_by');
            $table->foreign('provide_by')->references('id')->on('users');

            $table->date('date');
            $table->integer('month');
            $table->integer('year');
            $table->integer('day');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productrequests');
    }
};
