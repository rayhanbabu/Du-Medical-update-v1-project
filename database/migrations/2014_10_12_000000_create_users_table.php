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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->enum('userType', ['Doctor','Nursing','Pharmacy','Staff','Admin'
              ,'Homeopathy','Driver','Test','Ward']);
            $table->string('image')->nullable();  
            $table->integer('status')->default(1); 
            $table->string('card_verify_access')->nullable(); 
            $table->string('offline_reg_access')->nullable(); 
            $table->string('reports_access')->nullable();
            $table->string('oncall_access')->nullable();
            $table->string('patient_report_access')->nullable(); 
            $table->string('diagnostic')->nullable();   
            $table->timestamp('email_verified_at')->nullable();
            $table->string('designation')->nullable();  
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
