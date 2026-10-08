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
        Schema::create('client_personal_informations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('info_id')->constrained('client_informations')->cascadeOnDelete();
            $table->date('birth_date');
            $table->string('gender',1);
            $table->string('civil_status',10);
            $table->string('occupation',100);
            $table->string('education_attainment',100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_personal_informations');
    }
};
