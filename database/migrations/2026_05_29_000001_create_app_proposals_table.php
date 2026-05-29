<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_proposals', function (Blueprint $table) {
            $table->id();
            $table->string('proposal_number')->unique();
            $table->foreignId('client_id')->constrained('clients');
            $table->foreignId('created_by')->constrained('users');
            
            // Cover
            $table->string('cover_title');
            $table->string('cover_subtitle')->nullable();
            
            // Sections (Rich text)
            $table->text('introduction')->nullable();
            $table->text('scope_of_work')->nullable();
            $table->text('technology_stack')->nullable();
            $table->text('timeline_notes')->nullable();
            $table->text('terms_and_conditions')->nullable();
            
            // Financials
            $table->string('status')->default('draft'); // draft, sent, approved, rejected
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('pt_profit_percent', 5, 2)->default(11);
            $table->decimal('pt_profit_amount', 15, 2)->default(0);
            $table->decimal('user_amount', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);
            
            $table->text('director_notes')->nullable();
            $table->date('valid_until')->nullable();
            
            // Approvals
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            $table->string('qr_token')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_proposals');
    }
};
