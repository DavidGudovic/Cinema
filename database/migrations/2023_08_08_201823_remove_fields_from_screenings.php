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
            $table->dropColumn('advert_slots');
            $table->dropColumn('advert_duration');
            $table->dropColumn('advert_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('screenings', function (Blueprint $table) {
            $table->integer('advert_slots');
            $table->integer('advert_duration');
            $table->decimal('advert_price', 8, 2);
        });
    }
};
