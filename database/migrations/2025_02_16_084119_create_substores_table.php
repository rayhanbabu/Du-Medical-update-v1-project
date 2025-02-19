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
        Schema::create('substores', function (Blueprint $table) {
            $table->id();

            $table->string('request_from');

            $table->unsignedBigInteger('productrequest_id');
            $table->foreign('productrequest_id')->references('id')->on('productrequests');

            $table->unsignedBigInteger('generic_id');
            $table->foreign('generic_id')->references('id')->on('generics');

            $table->unsignedBigInteger('stock_id');
            $table->foreign('stock_id')->references('id')->on('stocks');

            $table->integer('total_unit');
            $table->integer('available_unit');

            $table->integer('cmo_status')->default(0);
            $table->integer('provide_status')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('substores');
    }
};
