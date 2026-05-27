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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('job_vacancy_id')->constrained('job_vacancies')->onDelete('cascade');
            $table->string('cv_path')->nullable();
            $table->enum('status', ['pending', 'reviewed', 'interview', 'rejected', 'hired'])->default('pending');
            $table->timestamps();
            
            // Seorang user hanya bisa melamar satu lowongan satu kali
            $table->unique(['user_id', 'job_vacancy_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
