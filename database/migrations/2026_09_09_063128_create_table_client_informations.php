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
        Schema::create('client_informations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('name_id')->constrained('client_names')->cascadeOnDelete();
            $table->foreignId('info_id')->constrained('client_personal_informations')->cascadeOnDelete();
            $table->foreignId('contact_id')->constrained('client_personal_contacts')->cascadeOnDelete();
            $table->foreignId('address_id')->constrained('client_address')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_informations');
    }
};
