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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('generic_id');
            $table->foreign('generic_id')->references('id')->on('generics');

            $table->unsignedBigInteger('brand_id');
            $table->foreign('brand_id')->references('id')->on('brands');
         
            $table->string('medicine_name');
            $table->integer('box');
            $table->integer('piece_per_box');
            $table->integer('total_piece');
            $table->integer('available_piece');
            $table->float('total_amount');
            $table->float('sale_per_piece');
            $table->integer('stock_status');
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
        Schema::dropIfExists('stocks');
    }
};
