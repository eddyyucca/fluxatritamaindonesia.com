<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tax_returns', function (Blueprint $table) {
            $table->id();
            $table->string('tax_type');
            $table->string('year');
            $table->string('period');
            $table->string('status')->default('draft');
            $table->string('file_path')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tax_returns');
    }
};
