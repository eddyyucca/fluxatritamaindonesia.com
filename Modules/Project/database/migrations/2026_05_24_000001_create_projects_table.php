<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->date('deadline')->nullable();
            $table->string('status')->default('active'); // active, completed, on_hold
            $table->timestamps();
            
            $table->foreign('client_id')->references('id')->on('clients')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
