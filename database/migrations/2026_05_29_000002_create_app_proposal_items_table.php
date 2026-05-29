<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_proposal_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('app_proposal_id')->constrained('app_proposals')->onDelete('cascade');
            $table->string('item_name');
            $table->text('description')->nullable();
            $table->decimal('amount', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_proposal_items');
    }
};
