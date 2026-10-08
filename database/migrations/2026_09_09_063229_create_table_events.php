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
        Schema::create('health_event_informations', function (Blueprint $table) {
            $table->id();
            $table->string('type_event');
            $table->foreignId('category_id')->constrained('event_categories')->cascadeOnDelete();
            $table->foreignId('event_id')->constrained('event_participants')->cascadeOnDelete();
            $table->string('site_location');
            $table->string('site_longitude');
            $table->string('site_lattitude');
            $table->string('event_name');
            $table->unsignedTinyInteger("max_client");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_event_informations');
    }
};
