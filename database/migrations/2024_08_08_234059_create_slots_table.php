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
        Schema::create('slots', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('chamber_id');
            $table->foreign('chamber_id')->references('id')->on('chambers');

            $table->string('week_name');
            $table->foreign('week_name')->references('week_name')->on('weeks');

            $table->string('slot_time');
            $table->enum('slot_type', ['Online','Offline','Tea_Brack']);
            $table->string('slot_status');
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
        Schema::dropIfExists('slots');
    }
};
