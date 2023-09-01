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
        Schema::create('table_advert_screening', function (Blueprint $table) {
            $table->id();
            $table->foreignId('advert_id')->constrained('adverts')->cascadeOnDelete();
            $table->foreignId('screening_id')->constrained('screenings')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_advert_screening');
    }
};
