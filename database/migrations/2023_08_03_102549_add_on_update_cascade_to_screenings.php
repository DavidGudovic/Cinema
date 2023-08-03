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
        Schema::table('screenings', function (Blueprint $table) {
            $table->dropForeign(['movie_id']);
            $table->dropForeign(['hall_id']);
            $table->foreign('movie_id')->references('id')->on('movies')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('hall_id')->references('id')->on('halls')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('screenings', function (Blueprint $table) {
            $table->dropForeign(['movie_id']);
            $table->dropForeign(['hall_id']);
            $table->foreign('movie_id')->references('id')->on('movies')->cascadeOnDelete();
            $table->foreign('hall_id')->references('id')->on('halls')->cascadeOnDelete();
        });
    }
};
