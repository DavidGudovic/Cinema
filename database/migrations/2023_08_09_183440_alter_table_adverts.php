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
        Schema::table('adverts', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['business_request_id']);
            // Modify the column to be nullable
            $table->foreignId('business_request_id')->nullable()->change();

            $table->foreign('business_request_id')->references('id')->on('business_requests');
        });
    }

    /**
    * Reverse the migrations.
    */
    public function down(): void
    {
        Schema::table('adverts', function (Blueprint $table) {
            // Modify the column to be non-nullable
            $table->foreignId('business_request_id')->nullable(false)->change();
        });
    }
};
