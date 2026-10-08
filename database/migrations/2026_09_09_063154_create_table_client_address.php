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
        Schema::create('client_address', function (Blueprint $table) {
            $table->id();
            $table->foreignId('address_id')->constrained('client_informations')->cascadeOnDelete();
            $table->string('psgc_region',36);
            $table->string('psgc_province',36);
            $table->string('psgc_city',36);
            $table->string('psgc_barangay',36);
            $table->string('home_number',36);
            $table->string('street',36);
            $table->string('full_address',100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_address');
    }
};
