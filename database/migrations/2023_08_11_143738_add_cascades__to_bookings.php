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
        Schema::table('bookings', function (Blueprint $table) {
                                  $table->dropForeign(['business_request_id']);
            // Modify the column to be nullable
            $table->foreignId('business_request_id')->nullable()->change();

            $table->foreign('business_request_id')->references('id')->on('business_requests')->onDelete('cascade');
        });
    }

    /**
    * Reverse the migrations.
    */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['business_request_id']);
            $table->foreignId('business_request_id')->constrained()->change();
        });
    }
};
