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
        Schema::table('tickets', function (Blueprint $table) {
            $table->integer('technology_price_addon')->after('screening_id')->default(0);
            $table->integer('long_movie_addon')->after('technology_price_addon')->default(0);
            $table->integer('subtotal')->after('long_movie_addon')->default(0);
            $table->integer('discount')->after('subtotal')->default(0);
            $table->integer('total')->after('discount')->default(0);
            $table->integer('seat_count')->after('total')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn([
                'technology_price_addon',
                'long_movie_addon',
                'subtotal',
                'discount',
                'total',
                'seat_count'
            ]);
        });
    }
};
