<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. Domain, Cpanel, Microsoft 365
            $table->unsignedBigInteger('client_id')->nullable();
            $table->string('billing_cycle'); // monthly, yearly, lifetime
            $table->date('start_date');
            $table->date('expiry_date')->nullable();
            $table->decimal('price', 15, 2)->default(0);
            $table->string('status')->default('active'); // active, expired
            $table->timestamps();
            
            $table->foreign('client_id')->references('id')->on('clients')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('licenses');
    }
};
