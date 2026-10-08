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
        Schema::create('client_names', function (Blueprint $table) {
            $table->id();
            $table->foreignId('name_id')->constrained('client_informations')->cascadeOnDelete();
            $table->string('last_name',64);
            $table->string('first_name',64);
            $table->string('middle_name')->nullable();
            $table->string('suffix',10)->nullable();
            $table->string('title',20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_names');
    }
};
