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
        Schema::table('candidate_profiles', function (Blueprint $table) {
            $table->enum('gender', ['Laki-laki', 'Perempuan'])->nullable()->after('address');
            $table->date('date_of_birth')->nullable()->after('gender');
            $table->string('education_level')->nullable()->after('date_of_birth');
            $table->string('major')->nullable()->after('education_level');
            $table->string('university')->nullable()->after('major');
            $table->integer('experience_years')->nullable()->after('university');
            $table->text('skills')->nullable()->after('experience_years');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidate_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'gender', 'date_of_birth', 'education_level', 
                'major', 'university', 'experience_years', 'skills'
            ]);
        });
    }
};
